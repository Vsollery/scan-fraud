@extends('layouts.main')
@section('container')
    <div class="row justify-content-center mb-3">
        <form method="GET">
            <label for="filter" class="font-medium mr-2">Filter by status:</label>
            <select name="filter" id="filter" class="border rounded px-3 py-1" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="safe" {{ request('filter') == 'safe' ? 'selected' : '' }}>Safe</option>
                <option value="fraudulent" {{ request('filter') == 'fraudulent' ? 'selected' : '' }}>Fraudulent</option>
            </select>
        </form>

    </div>
    <table class="w-full border-collapse border border-gray-400">
        <thead class="h-10">
        <tr>
            <th class="table-head">Name</th>
            <th class="table-head">Phone Number</th>
            <th class="table-head">Date of Birth</th>
            <th class="table-head">IP address</th>
            <th class="table-head">IBan</th>
            <th class="table-head">Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customers as $customer)
            <tr>
                <td class="table-cell">{{ $customer->firstName }} {{ $customer->lastName }}</td>
                <td class="table-cell">{{ $customer->phoneNumber }}</td>
                <td class="table-cell">{{ $customer->dob }}</td>
                <td class="table-cell">{{ $customer->ipAddress }}</td>
                <td class="table-cell">{{ $customer->iban }}</td>
                <td class="table-cell">
                    <span class="{{ $customer->pivot->is_fraudulent ? 'text-red-600' : 'text-green-600' }}">
                        {{ $customer->pivot->is_fraudulent ? 'Fraudulent' : 'Safe' }}
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
@endsection
