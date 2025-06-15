<?php

use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/scans', [ScanController::class, 'index']);
Route::get('/scan/{id}', [ScanController::class, 'show']);
