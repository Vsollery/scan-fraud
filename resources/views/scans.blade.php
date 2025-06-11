@extends('layouts.main')

@section('container')
    <h1 class="text-3xl font-bold text-blue-500 leading-tight">Scan History</h1>

    @foreach($scans as $scan)
        <div class="scan mt-4 p-4 border rounded shadow-md">
            <p><strong>Scan Date:</strong> {{ $scan->scan_date }}</p>
            <h3 class="mt-2 font-medium">Associated Customers:</h3>
            <ul>
                @foreach($scan->customers as $customer)
                    <li>
                        <p><strong>Name:</strong> {{ $customer->firstName }} {{ $customer->lastName }}</p>
                        <p><strong>Phone:</strong> {{ $customer->phoneNumber }}</p>
                        <p><strong>Date of Birth:</strong> {{ $customer->dob }}</p>
                        <p><strong>IP Address:</strong> {{ $customer->ipAddress }}</p>
                        <p><strong>IBAN:</strong> {{ $customer->iban }}</p>
                        <p><strong>Status:</strong>
                            <span class="{{ $customer->pivot->is_fraudulent ? 'text-red-600' : 'text-green-600' }}">
                                {{ $customer->pivot->is_fraudulent ? 'Fraudulent' : 'Safe' }}
                            </span>
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
@endsection



