<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Scan;
use App\Services\CustomerService;
use App\Services\ScanService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    protected CustomerService $customerService;
    protected ScanService $scanService;
    public function __construct(CustomerService  $customerService,  ScanService $scanService) {
        $this->customerService = $customerService;
        $this->scanService = $scanService;
    }

    public function index()
    {
        $scans = Scan::all();
        return view('scans', [
            'scans' => $scans
        ]);

    }

    public function showScan()
    {
        return view('scan');
    }

    public function startScan(Request $request){
        try{
            $customers = $this->customerService->getCustomersData();
            $scannedCustomers = $this->scanService->scanFraud($customers);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Failed to retrieve customers: ' . $e->getMessage());
        }

        if($scannedCustomers){
            $scan = Scan::create([
                'scan_date' => now(),
            ]);

            foreach($scannedCustomers as $customer){
                $dob = Carbon::createFromFormat('d-m-Y', $customer['dateOfBirth'])->format('Y-m-d');
                $customerModel = Customer::firstOrCreate(
                    ['customer_id' => $customer['customerId']],
                    [
                        'firstName' => $customer['firstName'],
                        'lastName' => $customer['lastName'],
                        'phoneNumber' => $customer['phoneNumber'],
                        'dob' => $dob,
                        'ipAddress' => $customer['ipAddress'],
                        'iban' => $customer['iban'],
                    ]);
                $is_fraudulent = $customer['is_fraudulent'] ? 1 : 0;
                $scan->customers()->attach($customerModel->customer_id, [
                    'is_fraudulent' =>  $is_fraudulent,
                ]);
            }
        }
        return view('scan', [
            'customers' =>  $scannedCustomers
        ]);
    }
}
