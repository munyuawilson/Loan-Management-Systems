@extends('layouts.shop')

@section('title', 'Loan Portfolio - LoanTrack Pro')
@section('page-title', 'Loan Portfolio Report')
@section('page-description', 'Complete overview of your loan book')

@section('page-actions')
    <div class="flex items-center space-x-3">
        <button onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition-colors flex items-center">
            <i class="fas fa-print mr-2"></i>
            Print
        </button>
        <a href="{{ route('reports.loan-portfolio') }}?export=pdf" 
           class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
            <i class="fas fa-file-pdf mr-2"></i>
            Export PDF
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Portfolio Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <i class="fas fa-hand-holding-usd text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $summary['total_loans'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Running Loans</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $summary['running_loans'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Cleared Loans</p>
                    <p class="text-2xl font-bold text-green-600">{{ $summary['cleared_loans'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg mr-4">
                    <i class="fas fa-money-bill-wave text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Outstanding Balance</p>
                    <p class="text-2xl font-bold text-red-600">${{ number_format($summary['total_balance'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Portfolio Composition -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Portfolio Composition</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Running Loans</span>
                        <span class="text-sm font-medium text-gray-700">
                            {{ $summary['total_loans'] > 0 ? number_format(($summary['running_loans'] / $summary['total_loans']) * 100, 1) : 0 }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-600 h-2 rounded-full" 
                             style="width: {{ $summary['total_loans'] > 0 ? ($summary['running_loans'] / $summary['total_loans']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Cleared Loans</span>
                        <span class="text-sm font-medium text-gray-700">
                            {{ $summary['total_loans'] > 0 ? number_format(($summary['cleared_loans'] / $summary['total_loans']) * 100, 1) : 0 }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" 
                             style="width: {{ $summary['total_loans'] > 0 ? ($summary['cleared_loans'] / $summary['total_loans']) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Total Loan Amount</p>
                            <p class="font-semibold text-gray-900">${{ number_format($summary['total_amount'], 2) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Total Collected</p>
                            <p class="font-semibold text-green-600">${{ number_format($summary['total_paid'], 2) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Collection Rate</p>
                            <p class="font-semibold text-blue-600">
                                {{ $summary['total_amount'] > 0 ? number_format(($summary['total_paid'] / $summary['total_amount']) * 100, 1) : 0 }}%
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600">Avg Loan Size</p>
                            <p class="font-semibold text-purple-600">${{ number_format($summary['avg_loan_size'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Customers by Loan Amount</h3>
            <div class="space-y-4">
                @foreach($topCustomers as $index => $customer)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-red-600 font-semibold text-xs">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $customer->name }}</p>
                            <p class="text-xs text-gray-500">{{ $customer->phone }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">${{ number_format($customer->loans_sum_amount, 2) }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $customer->loans_count ?? $customer->loans()->count() }} {{ Str::plural('loan', $customer->loans_count ?? 1) }}
                        </p>
                    </div>
                </div>
                @endforeach
                
                @if($topCustomers->isEmpty())
                    <p class="text-gray-500 text-center py-4">No customer data available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Payments</h3>
        </div>
        
        @if($recentPayments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Paid</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance After</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentPayments as $payment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $payment->paid_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-blue-600 font-semibold text-xs">
                                            {{ strtoupper(substr($payment->loan->customer->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $payment->loan->customer->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                #{{ $payment->loan->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                ${{ number_format($payment->amount_paid, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                ${{ number_format($payment->remaining_balance, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500">No recent payments found</p>
            </div>
        @endif
    </div>

    <!-- Performance Metrics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Portfolio Performance Metrics</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-6 bg-gray-50 rounded-xl">
                <div class="text-4xl font-bold text-gray-900 mb-2">
                    {{ $summary['total_loans'] > 0 ? number_format(($summary['cleared_loans'] / $summary['total_loans']) * 100, 0) : 0 }}%
                </div>
                <p class="text-gray-600 font-medium">Completion Rate</p>
                <p class="text-sm text-gray-500 mt-2">Percentage of loans that have been cleared</p>
            </div>
            
            <div class="text-center p-6 bg-gray-50 rounded-xl">
                <div class="text-4xl font-bold text-gray-900 mb-2">
                    {{ $summary['total_amount'] > 0 ? number_format(($summary['total_balance'] / $summary['total_amount']) * 100, 0) : 0 }}%
                </div>
                <p class="text-gray-600 font-medium">Outstanding Ratio</p>
                <p class="text-sm text-gray-500 mt-2">Percentage of total amount still outstanding</p>
            </div>
            
            <div class="text-center p-6 bg-gray-50 rounded-xl">
                <div class="text-4xl font-bold text-gray-900 mb-2">
                    {{ $summary['total_loans'] > 0 ? number_format($loans->where('status', 'running')->avg('balance') ?? 0, 0) : 0 }}
                </div>
                <p class="text-gray-600 font-medium">Avg Running Balance</p>
                <p class="text-sm text-gray-500 mt-2">Average balance of active loans</p>
            </div>
        </div>
    </div>
</div>
@endsection