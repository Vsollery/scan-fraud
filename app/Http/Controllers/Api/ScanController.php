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

    public function show($id){
        $scan = Scan::with('customers')->find($id);
        if(!$scan){
            return response()->json(['message' => 'Scan not found'], 404);
        }
        return response()->json($scan, 200);
    }
}
