<?php

use App\Services\ScanService;

test('test iban duplicate mark as fraudulent', function () {
    //arrange customers data
    $customers = [
        ['customerId' => 1, 'ipAddress' => '192.168.0.1', 'iban' => 'NL12BANK345', 'phoneNumber' => '+31612345678', 'dateOfBirth' => '01-01-2000'],
        ['customerId' => 2, 'ipAddress' => '192.168.0.1', 'iban' => 'NL12BANK345', 'phoneNumber' => '+31698765432', 'dateOfBirth' => '02-02-1990'],
        ['customerId' => 2, 'ipAddress' => '192.168.0.0', 'iban' => 'NL12RABO345', 'phoneNumber' => '+31698765432', 'dateOfBirth' => '02-02-1990'],
        ['customerId' => 3, 'ipAddress' => '192.168.0.3', 'iban' => 'NL12RABO344', 'phoneNumber' => '+31698765432', 'dateOfBirth' => '02-02-2009'],
    ];

    $scanService = new ScanService();
    $scannedCustomers = $scanService->scanFraud($customers);

    expect($scannedCustomers[0]['is_fraudulent'])->toBeTrue();
    expect($scannedCustomers[1]['is_fraudulent'])->toBeTrue();
    expect($scannedCustomers[2]['is_fraudulent'])->toBeFalse();
    expect($scannedCustomers[3]['is_fraudulent'])->toBeTrue();
});
