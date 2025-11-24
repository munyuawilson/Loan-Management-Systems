@extends('layouts.shop')

@section('title', 'Loan Statement #' . $loan->id . ' - LoanTrack Pro')
@section('page-title', 'Loan Statement #' . $loan->id)
@section('page-description', 'Complete loan transaction history')

@section('breadcrumb')
    Loan Statement
@endsection

@section('page-actions')
    <div class="flex items-center space-x-3">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center">
            <i class="fas fa-print mr-2"></i>
            Print Statement
        </button>
        <a href="{{ route('loans.show', $loan) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Loan
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Printable Statement -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 print:shadow-none print:border-none">
        <!-- Statement Header -->
        <div class="p-8 border-b border-gray-200 print:border-b-2">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-chart-line text-white text-lg"></i>
                        </div>
                        <div>
                            <span class="text-2xl font-bold text-gray-900">LoanTrack</span>
                            <span class="text-red-600 font-semibold">Pro</span>
                        </div>
                    </div>
                    <p class="text-gray-600">Loan Management System</p>
                    <p class="text-gray-600">{{ Auth::user()->shop->shop_name ?? 'My Shop' }}</p>
                </div>
                
                <div class="text-right">
                    <h1 class="text-2xl font-bold text-gray-900">LOAN STATEMENT</h1>
                    <p class="text-gray-600">Statement #: {{ $loan->id }}-{{ now()->format('Ymd') }}</p>
                    <p class="text-gray-600">Generated: {{ now()->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Loan & Customer Information -->
        <div class="p-8 border-b border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Loan Information</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Loan ID:</span>
                        <span class="font-medium">#{{ $loan->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Principal Amount:</span>
                        <span class="font-medium">${{ number_format($loan->amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Current Balance:</span>
                        <span class="font-medium {{ $loan->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                            ${{ number_format($loan->balance, 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-medium {{ $loan->status === 'running' ? 'text-yellow-600' : 'text-green-600' }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created Date:</span>
                        <span class="font-medium">{{ $loan->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Customer Name:</span>
                        <span class="font-medium">{{ $loan->customer->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Phone:</span>
                        <span class="font-medium">{{ $loan->customer->phone }}</span>
                    </div>
                    @if($loan->customer->email)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span class="font-medium">{{ $loan->customer->email }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Customer Since:</span>
                        <span class="font-medium">{{ $loan->customer->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment History -->
        <div class="p-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Payment History</h3>
            
            @if($loan->payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Paid</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining Balance</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Initial Loan Entry -->
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $loan->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    Loan Disbursement
                                    @if($loan->description)
                                        <br><span class="text-gray-500 text-xs">{{ $loan->description }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-600">
                                    -${{ number_format($loan->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                    ${{ number_format($loan->amount, 2) }}
                                </td>
                            </tr>

                            <!-- Payment Entries -->
                            @foreach($loan->payments as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->paid_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    Payment Received
                                    <br><span class="text-gray-500 text-xs">{{ $payment->paid_at->format('h:i A') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-green-600">
                                    +${{ number_format($payment->amount_paid, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-900">
                                    ${{ number_format($payment->remaining_balance, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-sm font-semibold text-gray-900 text-right">
                                    Final Balance:
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">
                                    @php
                                        $totalPaid = $loan->payments->sum('amount_paid');
                                    @endphp
                                    ${{ number_format($totalPaid, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $loan->balance > 0 ? 'text-red-600' : 'text-green-600' }} text-right">
                                    ${{ number_format($loan->balance, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="text-center py-8 border border-gray-200 rounded-lg">
                    <i class="fas fa-receipt text-gray-400 text-4xl mb-4"></i>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">No Payment History</h4>
                    <p class="text-gray-600">No payments have been recorded for this loan yet.</p>
                </div>
            @endif

            <!-- Summary Section -->
            <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Loan Summary</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Principal Amount:</span>
                            <span class="font-medium">${{ number_format($loan->amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Paid:</span>
                            <span class="font-medium text-green-600">${{ number_format($loan->amount - $loan->balance, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Remaining Balance:</span>
                            <span class="font-medium {{ $loan->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                ${{ number_format($loan->balance, 2) }}
                            </span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Progress:</span>
                            <span class="font-medium">{{ number_format((($loan->amount - $loan->balance) / $loan->amount) * 100, 1) }}%</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Number of Payments:</span>
                            <span class="font-medium">{{ $loan->payments->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Average Payment:</span>
                            <span class="font-medium">
                                ${{ $loan->payments->count() > 0 ? number_format(($loan->amount - $loan->balance) / $loan->payments->count(), 2) : '0.00' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="p-8 border-t border-gray-200 text-center text-gray-500 text-sm">
            <p>This is an computer-generated statement. No signature is required.</p>
            <p class="mt-2">Generated by LoanTrack Pro on {{ now()->format('F d, Y \a\t h:i A') }}</p>
        </div>
    </div>
</div>

<style>
    @media print {
        .print\:shadow-none {
            box-shadow: none !important;
        }
        .print\:border-none {
            border: none !important;
        }
        .print\:border-b-2 {
            border-bottom-width: 2px !important;
        }
        body {
            background: white !important;
        }
        .bg-gray-50 {
            background-color: #f9fafb !important;
        }
    }
</style>
@endsection