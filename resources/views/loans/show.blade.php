@extends('layouts.shop')

@section('title', 'Loan #' . $loan->id . ' - LoanTrack Pro')
@section('page-title', 'Loan #' . $loan->id)
@section('page-description', 'Loan details and payment history')

@section('breadcrumb')
    Loan Details
@endsection

@section('page-actions')
    <div class="flex items-center space-x-3">
        @if($loan->status === 'running')
            <a href="{{ route('payments.create', $loan) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors flex items-center">
                <i class="fas fa-money-bill-wave mr-2"></i>
                Record Payment
            </a>
        @endif
        <a href="{{ route('loans.statement', $loan) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center">
            <i class="fas fa-file-invoice mr-2"></i>
            Statement
        </a>
        <a href="{{ route('loans.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Loans
        </a>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Loan Information -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Loan Details Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Loan Details</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Loan ID</label>
                        <p class="text-gray-900 font-semibold">#{{ $loan->id }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Customer</label>
                        <div class="flex items-center mt-1">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-2">
                                <span class="text-red-600 font-semibold text-xs">
                                    {{ strtoupper(substr($loan->customer->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-gray-900 font-medium">{{ $loan->customer->name }}</p>
                                <p class="text-xs text-gray-500">{{ $loan->customer->phone }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Description</label>
                        <p class="text-gray-900">{{ $loan->description ?: 'No description' }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Created Date</label>
                        <p class="text-gray-900">{{ $loan->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Summary Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Loan Summary</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Principal Amount</span>
                        <span class="font-semibold text-gray-900">${{ number_format($loan->amount, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Amount Paid</span>
                        <span class="font-semibold text-green-600">${{ number_format($loan->amount - $loan->balance, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Remaining Balance</span>
                        <span class="font-semibold text-red-600">${{ number_format($loan->balance, 2) }}</span>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Progress</span>
                            <span class="font-semibold text-gray-900">
                                {{ number_format((($loan->amount - $loan->balance) / $loan->amount) * 100, 1) }}%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-red-600 h-2 rounded-full" 
                                 style="width: {{ ($loan->amount - $loan->balance) / $loan->amount * 100 }}%">
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $loan->status === 'running' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Payment History</h2>
                @if($loan->status === 'running')
                    <a href="{{ route('payments.create', $loan) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors flex items-center text-sm">
                        <i class="fas fa-plus mr-1"></i>
                        Add Payment
                    </a>
                @endif
            </div>

            @if($loan->payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Paid</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining Balance</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loan->payments as $payment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->paid_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                    +${{ number_format($payment->amount_paid, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($payment->remaining_balance, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->paid_at->format('h:i A') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-money-bill-wave text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No payments yet</h3>
                    <p class="text-gray-600 mb-4">No payments have been recorded for this loan.</p>
                    @if($loan->status === 'running')
                        <a href="{{ route('payments.create', $loan) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors inline-flex items-center">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            Record First Payment
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection