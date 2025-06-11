@extends('layouts.main')

@section('container')
    <form method="POST" action="{{ route('scan.start') }}">
        @csrf
        <div class="flex justify-center">
            <button type="submit" class="bg-orange-400 hover:bg-orange-500 text-white font-bold py-2 px-8 rounded w-3/4">
                Start Scan
            </button>
        </div>

    </form>

    @if(isset($customers))
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
        @foreach ($customers as $customer)
            @php
                $dob = DateTime::createFromFormat('d-m-Y', $customer['dateOfBirth']);
               $age = $dob ? $dob->diff(new DateTime('now'))->y : 'N/A';
            @endphp
            <div class="p-4 rounded shadow border
                {{ $customer['is_fraudulent'] ? 'bg-red-100 border-red-400' : 'bg-green-100 border-green-400' }}">

                <h2 class="text-lg font-bold mb-2">
                    {{ $customer['firstName'] }} {{ $customer['lastName'] }}
                </h2>

                <ul class="text-sm space-y-1">
                    <li><strong>IP Address:</strong> {{ $customer['ipAddress'] }}</li>
                    <li><strong>IBAN:</strong> {{ $customer['iban'] }}</li>
                    <li>
                        <strong>Date of Birth:</strong> {{ $customer['dateOfBirth'] }}
                        (Age: {{ $age }})
                    </li>
                    <li>
                        <strong>Status:</strong>
                        <span class="{{ $customer['is_fraudulent'] ? 'text-red-600 font-semibold' : 'text-green-700' }}">
                            {{ $customer['is_fraudulent'] ? 'Fraudulent' : 'Safe' }}
                        </span>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
    @endif

@endsection

