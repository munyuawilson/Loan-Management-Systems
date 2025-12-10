@extends('layouts.shop')

@section('title', 'Daily Collections Report - LoanTrack Pro')
@section('page-title', 'Daily Collections Report')
@section('page-description', 'View all payments received on a specific day')

@section('page-actions')
    <div class="flex items-center space-x-3">
        <form method="GET" action="{{ route('reports.daily-collections') }}" class="flex items-center space-x-2">
            <input type="date" name="date" value="{{ $date }}" 
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                Filter
            </button>
        </form>
        <button onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition-colors flex items-center">
            <i class="fas fa-print mr-2"></i>
            Print
        </button>
    </div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Collections for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h3>
                <p class="text-gray-600 text-sm mt-1">Total Collected: <span class="font-semibold text-green-600">${{ number_format($total, 2) }}</span></p>
            </div>
            <div class="text-sm text-gray-500">
                {{ $collections->count() }} {{ Str::plural('payment', $collections->count()) }}
            </div>
        </div>
    </div>

    @if($collections->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Paid</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance After</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($collections as $payment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->paid_at ? $payment->paid_at->format('h:i A') : 'N/A' }}
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
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                            Total Collections:
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-green-600">
                            ${{ number_format($total, 2) }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-money-bill-wave text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No collections found</h3>
            <p class="text-gray-600 mb-6">No payments were received on {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>
            <a href="{{ route('reports.index') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Reports
            </a>
        </div>
    @endif
</div>

<div class="mt-6 text-sm text-gray-600">
    <p><i class="fas fa-info-circle mr-2"></i>This report shows all payments received on the selected date.</p>
</div>
@endsection