@extends('layouts.main')

@section('container')
    <h1 class="text-3xl font-bold text-blue-500 leading-tight">Scan History</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($scans as $scan)
            <a href="{{ route('scan', ['scan' => $scan['scan_date']]) }}">

                <div class="bg-white rounded-xl shadow p-5 border border-gray-100">
                    <h2 class="text-xl font-semibold mb-2 text-gray-800">Scan Date</h2>
                    <p class="text-gray-600 mb-4">{{ $scan->scan_date}}</p>
                    <div class="text-sm space-y-1">
                        <p class="text-green-600"><strong>Safe:</strong> {{ $scan['total_safe'] }}</p>
                        <p class="text-red-600"><strong>Fraudulent:</strong> {{ $totalFraudulent}}</p>
                    </div>
                </div>
            </a>
        @endforeach

    </div>
    <div class="mt-6">
        {{ $scans->links() }}
    </div>

@endsection



