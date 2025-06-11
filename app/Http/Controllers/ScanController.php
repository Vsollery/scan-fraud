<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Services\ScanService;
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
        return view('scans');

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
        return view('scan', [
            'customers' =>  $scannedCustomers
        ]);
    }
}
