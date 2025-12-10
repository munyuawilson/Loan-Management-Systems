@extends('layouts.shop')

@section('title', 'Running Loans Report - LoanTrack Pro')
@section('page-title', 'Running Loans Report')
@section('page-description', 'Active loans with outstanding balances')

@section('page-actions')
    <div class="flex items-center space-x-3">
        <button onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition-colors flex items-center">
            <i class="fas fa-print mr-2"></i>
            Print
        </button>
        <a href="javascript:window.location.href=window.location.href.replace('running-loans','running-loans?export=pdf')" 
           class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
            <i class="fas fa-file-pdf mr-2"></i>
            Export PDF
        </a>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg mr-4">
                    <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Running Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalLoans }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                    <i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Outstanding Balance</p>
                    <p class="text-2xl font-bold text-red-600">${{ number_format($totalBalance, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <i class="fas fa-calculator text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Average Loan Balance</p>
                    <p class="text-2xl font-bold text-blue-600">${{ number_format($totalLoans > 0 ? $totalBalance / $totalLoans : 0, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loans Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Active Loans ({{ $totalLoans }})</h3>
                <div class="text-sm text-gray-500">
                    Generated: {{ now()->format('M d, Y h:i A') }}
                </div>
            </div>
        </div>

        @if($loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Active</th>
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
                                    {{ $loan->created_at->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-red-600 font-semibold text-xs">
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-600">
                                ${{ number_format($loan->balance, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                ${{ number_format($loan->amount - $loan->balance, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                        @php
                                            $progress = $loan->amount > 0 ? (($loan->amount - $loan->balance) / $loan->amount) * 100 : 0;
                                            $color = $progress >= 70 ? 'bg-green-600' : ($progress >= 40 ? 'bg-yellow-600' : 'bg-red-600');
                                        @endphp
                                        <div class="{{ $color }} h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600">
                                        {{ number_format($progress, 1) }}%
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $daysActive = now()->diffInDays($loan->created_at);
                                    $color = $daysActive > 90 ? 'text-red-600' : ($daysActive > 60 ? 'text-yellow-600' : 'text-green-600');
                                @endphp
                                <span class="text-sm font-medium {{ $color }}">
                                    {{ $daysActive }} days
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('loans.show', $loan) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('payments.create', $loan) }}" class="text-green-600 hover:text-green-900 transition-colors" title="Add Payment">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                                Totals:
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600">
                                ${{ number_format($totalBalance, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                ${{ number_format($loans->sum('amount') - $totalBalance, 2) }}
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No running loans</h3>
                <p class="text-gray-600 mb-6">All loans are cleared. Great job!</p>
                <a href="{{ route('loans.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors inline-flex items-center">
                    <i class="fas fa-hand-holding-usd mr-2"></i>
                    Create New Loan
                </a>
            </div>
        @endif
    </div>

    <!-- Distribution Chart (Visual) -->
    @if($loans->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Balance Distribution</h3>
        <div class="space-y-4">
            @foreach($loans->take(5) as $loan)
            <div class="flex items-center">
                <div class="w-1/3">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $loan->customer->name }}</p>
                    <p class="text-xs text-gray-500">Loan #{{ $loan->id }}</p>
                </div>
                <div class="flex-1 mx-4">
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        @php
                            $percentage = ($loan->balance / $totalBalance) * 100;
                        @endphp
                        <div class="bg-red-600 h-3 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                <div class="w-1/4 text-right">
                    <p class="text-sm font-semibold text-red-600">${{ number_format($loan->balance, 2) }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($percentage, 1) }}% of total</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection