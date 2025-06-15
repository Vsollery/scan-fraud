<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Scan;
use App\Services\CustomerService;
use App\Services\ScanService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
        $scans = Scan::with('customers')
            ->withCount('fraudulentCustomers')
            ->latest('scan_date')
            ->paginate(9);
        ;

        return view('scans', [
            'scans' => $scans,
        ]);
    }

    public function home()
    {
        $cacheKey = 'last_scan';
        if(Cache::has($cacheKey)) {
            // Cache exists, retrieve it
            $cachedData = Cache::get($cacheKey);

            return view('home',[
                'customers' => $cachedData['customers'],
            ]);
        }

        return view('home');
    }

    public function scan(Scan $scan)
    {

        $query = $scan->customers();

        if ($filter = request('filter')) {
            if ($filter == 'safe') {
                $query->wherePivot('is_fraudulent', 0);
            } elseif ($filter == 'fraudulent') {
                $query->wherePivot('is_fraudulent', 1);
            }
        }

        $customers = $query->get();

        return view('scan', [
            'scan' => $scan,
            'customers' => $customers
        ]);
    }

    public function startScan(){

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

            // Cache the scan data with customer details
            Cache::put('last_scan', [
                'scan_date' => $scan->scan_date->toDateTimeString(),
                'customers' => $scannedCustomers,
            ], now()->addMinutes(30));
        }
        return redirect('/home')
            ->with('success', 'Scan created successfully')
            ->with('customers', $scannedCustomers);
    }
}


