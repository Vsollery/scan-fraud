<?php

namespace App\Services;

use DateTime;
use Illuminate\Support\Facades\Http;
class CustomerService {
    public function getCustomersData() {
        $response = Http::get('http://localhost:8080/api/v1/customers');

        if($response->failed()) {
            throw new \Exception('API Failed to Get Customers');
        }
        return $response['customers'];
    }

    public function scanFraud($customers){
        //first loop for detecting duplicate IpAdress and Iban
        $scannedCustomers = [];
        //keeping track of ipAdress and Iban
        $ipCounts = [];
        $ibanCounts = [];

        foreach($customers as $customer){
            $ip = $customer['ipAddress'];
            $iban = $customer['iban'];

            if(isset($ipCounts[$ip])){
                $ipCounts[$ip] = $ipCounts[$ip] + 1;
            }else{
                $ipCounts[$ip] = 1;
            }

            if(isset($ibanCounts[$iban])){
                $ibanCounts[$iban] = $ibanCounts[$iban] + 1;
            }else{
                $ibanCounts[$iban] = 1;
            }

        }

        foreach($customers as $key => $customer){
            $isFraud = false;

            //check for duplicate ip address or iban
            if($ipCounts[$customer['ipAddress']] > 1 || $ibanCounts[$customer['iban']] > 1){
                $isFraud =  true;
            }

            //check for phone number outside netherlands
            if(strpos($customer['phoneNumber'], '+31') !== 0) {
            $isFraud = true;
            }

            //check if customers is younger than 18
            $dob = DateTime::createFromFormat('d-m-Y', $customer['dateOfBirth']);
            if ($dob) {
                $age = $dob->diff(new DateTime('now'))->y;
                if ($age < 18) {
                    $isFraud =  true;
                }
            }

            $customers[$key]['is_fraudulent'] = $isFraud;
        }

        return $customers;
    }

}
