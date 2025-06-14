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
        $scans = Scan::with('customers')->get();

        $scanSummaries = [];
        foreach ($scans as $scan) {
            $totalCustomers = $scan->customers->count();
            $totalFraud = $scan->customers->where('pivot.is_fraudulent', 1)->count();
            $totalSafe = $totalCustomers - $totalFraud;

            $scanSummaries[] = [
                'scan_date' => $scan->scan_date,
                'total_customers' => $totalCustomers,
                'total_safe' => $totalSafe,
                'total_fraud' => $totalFraud,
            ];
        }

        $scanSummaries = collect($scanSummaries)->sortByDesc('scan_date')->values();

        return view('scans', [
            'scans' => $scanSummaries
        ]);
    }

    public function showScan()
    {
        return view('home');
    }

    public function scan(Scan $scan)
    {
        $scan->load('customers');

        return view('scan', [
            'scan' => $scan
        ]);
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
        return view('home', [
            'customers' =>  $scannedCustomers
        ])->with('success', 'Scan created successfully');
    }
}
