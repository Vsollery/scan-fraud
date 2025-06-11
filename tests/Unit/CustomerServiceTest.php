<?php

use App\Services\CustomerService;
use Illuminate\Support\Facades\Http;


test('test get customer data success', function () {
    //arrange
    Http::fake([
        'http://localhost:8080/api/v1/customers' => Http::response([
            'success' => true,
            'customers' => [
                ['customerId' => 1, 'firstName' => 'Elena'],
                ['customerId' => 2, 'firstName' => 'Evelien'],
            ]
        ], 200),
    ]);

    //act
    $customerService = new CustomerService();
    $customers = $customerService->getCustomersData();

    //assert
    expect($customers)->toHaveCount(2)
        ->and($customers[0]['firstName'])->toBe('Elena');
});

test('test get customer data throw exception', function () {
    //arrange: arrange to return no customers
    Http::fake([
        'http://localhost:8080/api/v1/customers' => Http::response([], 503),
    ]);

    //act
    $customerService = new CustomerService();

    //assert
    expect(fn() => $customerService->getCustomersData()->toThrow(Exception::class));
});

test('test detect same iban and ip address', function () {});
