<?php

namespace App\Http\Controllers;

use App\Services\ScanService;
use Illuminate\Http\Request;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    protected CustomerService $customerService;
    protected ScanService $scanService;

    public function __construct(CustomerService  $customerService, ScanService $scanService) {
        $this->customerService = $customerService;
        $this->scanService = $scanService;
    }


    /**
     * @throws \Exception
     */
    public function index()
    {
        $response = $this->customerService->getCustomersData();
        $scannedCustomers = $this->scanService->scanFraud($response);
        return view('scan',
        [
            'customers' => $scannedCustomers,
        ]);

    }
}
