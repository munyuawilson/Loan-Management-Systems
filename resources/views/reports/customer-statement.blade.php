@extends('layouts.shop')

@section('title', 'Customer Statement - LoanTrack Pro')
@section('page-title', 'Customer Statement')
@section('page-description', 'Detailed transaction history for customers')

@section('page-actions')
    <button onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition-colors flex items-center">
        <i class="fas fa-print mr-2"></i>
        Print
    </button>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Customer Selection Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Customer</h3>
        <form method="GET" action="{{ route('reports.customer-statement') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                    <select name="customer_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" required>
                        <option value="">Select a customer</option>
                        @foreach($customers as $cust)
                            <option value="{{ $cust->id }}" {{ isset($customer) && $customer->id == $cust->id ? 'selected' : '' }}>
                                {{ $cust->name }} - {{ $cust->phone }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2 flex items-end">
                    <button type="submit" class="bg-red-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-red-700 transition-colors w-full md:w-auto">
                        Generate Statement
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if(isset($customer))
        <!-- Customer Statement -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Customer Header -->
            <div class="p-6 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-red-600 font-semibold text-lg">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h3>
                                <p class="text-gray-600">{{ $customer->phone }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Statement Date</p>
                        <p class="font-semibold">{{ now()->format('F d, Y') }}</p>
                    </div>
                </div>

                <!-- Summary Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600">Total Loans</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalLoans }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600">Total Amount</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($totalAmount, 2) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600">Total Paid</p>
                        <p class="text-2xl font-bold text-green-600">${{ number_format($totalPaid, 2) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600">Balance</p>
                        <p class="text-2xl font-bold text-red-600">${{ number_format($totalBalance, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Loans and Transactions -->
            @if($loans->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($loans as $loan)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <div class="flex items-center space-x-3">
                                    <h4 class="text-lg font-semibold text-gray-900">Loan #{{ $loan->id }}</h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $loan->status === 'running' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mt-1">
                                    Created: {{ $loan->created_at->format('M d, Y') }}
                                    @if($loan->description)
                                        • {{ $loan->description }}
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Loan Amount</p>
                                <p class="text-lg font-bold text-gray-900">${{ number_format($loan->amount, 2) }}</p>
                                <p class="text-sm {{ $loan->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    Balance: ${{ number_format($loan->balance, 2) }}
                                </p>
                            </div>
                        </div>

                        <!-- Payments for this loan -->
                        @if($loan->payments->count() > 0)
                            <div class="ml-8 mt-4 space-y-3">
                                <h5 class="text-sm font-semibold text-gray-700">Payment History</h5>
                                @foreach($loan->payments as $payment)
                                    <div class="flex justify-between items-center py-2 px-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $payment->paid_at ? $payment->paid_at->format('M d, Y h:i A') : 'Date not set' }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-semibold text-green-600">${{ number_format($payment->amount_paid, 2) }}</p>
                                            <p class="text-xs text-gray-500">Balance: ${{ number_format($payment->remaining_balance, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="ml-8 mt-4">
                                <p class="text-sm text-gray-500 italic">No payments made yet</p>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">No loans found for this customer</p>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection