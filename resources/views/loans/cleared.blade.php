@extends('layouts.shop')

@section('title', 'Cleared Loans - LoanTrack Pro')
@section('page-title', 'Cleared Loans')
@section('page-description', 'Successfully paid loans')

@section('breadcrumb')
    Cleared Loans
@endsection

@section('page-actions')
    <a href="{{ route('loans.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
        <i class="fas fa-hand-holding-usd mr-2"></i>
        Create Loan
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Cleared Loans Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Cleared Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $loans->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Amount Cleared</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($loans->sum('amount'), 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg mr-4">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Customers Served</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $loans->unique('customer_id')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cleared Loans Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Successfully Cleared Loans</h2>
            <p class="text-sm text-gray-600 mt-1">Loans that have been fully paid by customers</p>
        </div>

        @if($loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Principal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payments</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cleared Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($loans as $loan)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">#{{ $loan->id }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $loan->description ? Str::limit($loan->description, 30) : 'No description' }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    Created: {{ $loan->created_at->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-green-600 font-semibold text-xs">
                                            {{ strtoupper(substr($loan->customer->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $loan->customer->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $loan->customer->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${{ number_format($loan->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex items-center text-green-600">
                                    <i class="fas fa-check-circle mr-1 text-xs"></i>
                                    {{ $loan->payments->count() }} payments
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php
                                    $clearedDate = $loan->updated_at;
                                    $duration = $loan->created_at->diffInDays($clearedDate);
                                @endphp
                                {{ $duration }} days
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $loan->updated_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('loans.show', $loan) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('loans.statement', $loan) }}" class="text-purple-600 hover:text-purple-900 transition-colors" title="Statement">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-usd text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No cleared loans yet</h3>
                <p class="text-gray-600 mb-6">Cleared loans will appear here once customers complete their payments.</p>
                <a href="{{ route('loans.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors inline-flex items-center">
                    <i class="fas fa-hand-holding-usd mr-2"></i>
                    Create New Loan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection