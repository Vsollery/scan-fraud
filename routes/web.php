<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/scan', function () {
    return view('scan');
});

//Route::get('/scan2', [CustomerController::class, 'index']);
Route::get('/scan-history', [ScanController::class, 'index'])->name('scan.history');
Route::get('/home', [ScanController::class, 'home'])->name('scan.page');;
Route::get('/scan/{scan}', [ScanController::class, 'scan'])->name('scan');
Route::post('/scan/start', [ScanController::class, 'startScan'])->name('scan.start');
