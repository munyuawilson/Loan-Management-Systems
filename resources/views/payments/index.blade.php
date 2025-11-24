@extends('layouts.shop')

@section('title', 'All Payments - LoanTrack Pro')
@section('page-title', 'All Payments')
@section('page-description', 'Complete payment history across all loans')

@section('page-actions')
    <a href="{{ route('loans.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition-colors flex items-center">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Loans
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Payment Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Payments</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $payments->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Received</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($payments->sum('amount_paid'), 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg mr-4">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Customers Paid</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $payments->unique('loan.customer_id')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg mr-4">
                    <i class="fas fa-calendar-alt text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">This Month</p>
                    <p class="text-2xl font-bold text-gray-900">
                        ${{ number_format($payments->where('paid_at', '>=', now()->startOfMonth())->sum('amount_paid'), 2) }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">All Payments</h2>
            <p class="text-sm text-gray-600 mt-1">Complete payment history across all loans and customers</p>
        </div>

        @if($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Details</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Paid</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Balance After</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $payment->paid_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $payment->paid_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-red-600 font-semibold text-xs">
                                            {{ strtoupper(substr($payment->loan->customer->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $payment->loan->customer->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $payment->loan->customer->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">Loan #{{ $payment->loan->id }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $payment->loan->description ? Str::limit($payment->loan->description, 30) : 'No description' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 text-right">
                                +${{ number_format($payment->amount_paid, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                ${{ number_format($payment->remaining_balance, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('loans.show', $payment->loan) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="View Loan">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('payments.history', $payment->loan) }}" class="text-purple-600 hover:text-purple-900 transition-colors" title="Payment History">
                                        <i class="fas fa-history"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Recent Activity Summary -->
            <div class="p-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Payment Activity</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                        <div class="text-2xl font-bold text-green-600">
                            ${{ number_format($payments->where('paid_at', '>=', now()->startOfDay())->sum('amount_paid'), 2) }}
                        </div>
                        <div class="text-sm text-green-700 mt-1">Today</div>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="text-2xl font-bold text-blue-600">
                            ${{ number_format($payments->where('paid_at', '>=', now()->startOfWeek())->sum('amount_paid'), 2) }}
                        </div>
                        <div class="text-sm text-blue-700 mt-1">This Week</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                        <div class="text-2xl font-bold text-purple-600">
                            ${{ number_format($payments->where('paid_at', '>=', now()->startOfMonth())->sum('amount_paid'), 2) }}
                        </div>
                        <div class="text-sm text-purple-700 mt-1">This Month</div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-money-bill-wave text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No payments recorded</h3>
                <p class="text-gray-600 mb-6">No payments have been recorded in the system yet.</p>
                <a href="{{ route('loans.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors inline-flex items-center">
                    <i class="fas fa-hand-holding-usd mr-2"></i>
                    Create a Loan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection