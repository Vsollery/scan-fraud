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
}
