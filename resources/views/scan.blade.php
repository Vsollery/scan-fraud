@extends('layouts.main')
@section('container')
    <table class="table-auto w-full border">
        <thead>
        <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Date of Birth</th>
            <th>IP address</th>
            <th>IBan</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($scan->customers as $customer)
            <tr>
                <td class="border px-4 py-2">{{ $customer->firstName }} {{ $customer->lastName }}</td>
                <td class="border px-4 py-2">{{ $customer->phoneNumber }}</td>
                <td class="border px-4 py-2">{{ $customer->dob }}</td>
                <td class="border px-4 py-2">{{ $customer->ipAddress }}</td>
                <td class="border px-4 py-2">{{ $customer->iban }}</td>
                <td class="border px-4 py-2">
                                <span class="{{ $customer->pivot->is_fraudulent ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $customer->pivot->is_fraudulent ? 'Fraudulent' : 'Safe' }}
                                </span>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
