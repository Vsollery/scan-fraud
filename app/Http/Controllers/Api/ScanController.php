<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index(){
        $scans = Scan::all();
        return response()->json($scans, 200);
    }

    public function show(Request $request, $id){
        $scan = Scan::with('customers')->find($id);

        if(!$scan){
            return response()->json(['message' => 'Scan not found'], 404);
        }
        $fraud = $request->query('fraud'); // 'true', 'false', or null
        $customers = $scan->customers;

        if ($fraud === 'true') {
            $customers = $customers->filter(fn($customer) => $customer->pivot->is_fraudulent == 1);
        } elseif ($fraud === 'false') {
            $customers = $customers->filter(fn($customer) => $customer->pivot->is_fraudulent == 0);
        }

        return response()->json([
            'scan_id' =>$scan->id,
            'scan_date' => $scan->scan_date,
            'customers' => $customers->values(),
        ], 200);
    }
}
