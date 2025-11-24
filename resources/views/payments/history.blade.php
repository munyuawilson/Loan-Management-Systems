@extends('layouts.shop')

@section('title', 'Payment History - LoanTrack Pro')
@section('page-title', 'Payment History')
@section('page-description', 'Payment history for loan #' . $loan->id)

@section('breadcrumb')
    Payment History
@endsection

@section('page-actions')
    <div class="flex items-center space-x-3">
        @if($loan->status === 'running')
            <a href="{{ route('payments.create', $loan) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors flex items-center">
                <i class="fas fa-money-bill-wave mr-2"></i>
                Record Payment
            </a>
        @endif
        <a href="{{ route('loans.show', $loan) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Loan
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <!-- Loan Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Payment History</h2>
                    <p class="text-sm text-gray-600 mt-1">All payments recorded for loan #{{ $loan->id }}</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">Customer: <span class="font-semibold">{{ $loan->customer->name }}</span></div>
                    <div class="text-sm text-gray-600">Current Balance: <span class="font-semibold {{ $loan->balance > 0 ? 'text-red-600' : 'text-green-600' }}">${{ number_format($loan->balance, 2) }}</span></div>
                </div>
            </div>
        </div>

        <!-- Payment Statistics -->
        <div class="p-6 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="text-2xl font-bold text-blue-600">${{ number_format($loan->amount, 2) }}</div>
                    <div class="text-sm text-blue-700 mt-1">Principal Amount</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                    <div class="text-2xl font-bold text-green-600">${{ number_format($loan->amount - $loan->balance, 2) }}</div>
                    <div class="text-sm text-green-700 mt-1">Total Paid</div>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-lg border border-red-200">
                    <div class="text-2xl font-bold text-red-600">${{ number_format($loan->balance, 2) }}</div>
                    <div class="text-sm text-red-700 mt-1">Remaining Balance</div>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                    <div class="text-2xl font-bold text-purple-600">{{ $payments->count() }}</div>
                    <div class="text-sm text-purple-700 mt-1">Total Payments</div>
                </div>
            </div>
        </div>

        <!-- Payment List -->
        <div class="p-6">
            @if($payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment ID</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Paid</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Balance After</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $payment->paid_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $payment->paid_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    #{{ $payment->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 text-right">
                                    +${{ number_format($payment->amount_paid, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    ${{ number_format($payment->remaining_balance, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($payment->remaining_balance == 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Loan Cleared
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Partial Payment
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-sm font-semibold text-gray-900 text-right">
                                    Totals:
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 text-right">
                                    ${{ number_format($payments->sum('amount_paid'), 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">
                                    ${{ number_format($loan->balance, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $payments->count() }} payments
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Payment Timeline -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Payment Timeline</h3>
                    <div class="space-y-4">
                        @foreach($payments as $payment)
                        <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="fas fa-money-bill-wave text-green-600"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900">Payment Recorded</h4>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Payment of <span class="font-semibold text-green-600">${{ number_format($payment->amount_paid, 2) }}</span> was recorded
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-900">{{ $payment->paid_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->paid_at->format('h:i A') }}</div>
                                    </div>
                                </div>
                                <div class="mt-2 text-xs text-gray-500">
                                    Balance after payment: <span class="font-semibold {{ $payment->remaining_balance > 0 ? 'text-red-600' : 'text-green-600' }}">${{ number_format($payment->remaining_balance, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-money-bill-wave text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No payments recorded</h3>
                    <p class="text-gray-600 mb-6">No payments have been recorded for this loan yet.</p>
                    @if($loan->status === 'running')
                        <a href="{{ route('payments.create', $loan) }}" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors inline-flex items-center">
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