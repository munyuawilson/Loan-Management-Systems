@extends('layouts.shop')

@section('title', 'Ageing Analysis - LoanTrack Pro')
@section('page-title', 'Ageing Analysis Report')
@section('page-description', 'Loans categorized by days outstanding')

@section('page-actions')
    <button onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition-colors flex items-center">
        <i class="fas fa-print mr-2"></i>
        Print
    </button>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $categories = [
                'Current (0-30 days)' => ['color' => 'green', 'icon' => 'check-circle'],
                '31-60 days' => ['color' => 'yellow', 'icon' => 'clock'],
                '61-90 days' => ['color' => 'orange', 'icon' => 'exclamation-triangle'],
                'Over 90 days' => ['color' => 'red', 'icon' => 'exclamation-circle'],
            ];
        @endphp
        
        @foreach($categories as $category => $info)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-{{ $info['color'] }}-100 rounded-lg mr-4">
                    <i class="fas fa-{{ $info['icon'] }} text-{{ $info['color'] }}-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">{{ $category }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $summary[$category]['count'] ?? 0 }}</p>
                    <p class="text-sm text-{{ $info['color'] }}-600 font-medium">
                        ${{ number_format($summary[$category]['amount'] ?? 0, 2) }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Analysis Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Ageing Analysis Details</h3>
                <div class="text-sm text-gray-500">
                    {{ $loans->count() }} running loans analyzed
                </div>
            </div>
        </div>

        @if($loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days Outstanding</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($loans as $loan)
                        @php
                            $lastPayment = $loan->payments->sortByDesc('paid_at')->first();
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">#{{ $loan->id }}</div>
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium 
                                    {{ $loan->days_outstanding > 90 ? 'text-red-600' : 
                                       ($loan->days_outstanding > 60 ? 'text-orange-600' : 
                                       ($loan->days_outstanding > 30 ? 'text-yellow-600' : 'text-green-600')) }}">
                                    {{ $loan->days_outstanding }} days
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $bgColor = match($loan->category_color) {
                                        'green' => 'bg-green-100 text-green-800',
                                        'yellow' => 'bg-yellow-100 text-yellow-800',
                                        'orange' => 'bg-orange-100 text-orange-800',
                                        'red' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgColor }}">
                                    {{ $loan->age_category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($lastPayment)
                                    {{ $lastPayment->paid_at->format('M d, Y') }}
                                @else
                                    <span class="text-gray-400 italic">No payments</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('loans.show', $loan) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($loan->days_outstanding > 30)
                                        <a href="{{ route('payments.create', $loan) }}" class="text-green-600 hover:text-green-900 transition-colors" title="Collect Payment">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </a>
                                    @endif
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
                    <i class="fas fa-hourglass-end text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No running loans</h3>
                <p class="text-gray-600 mb-6">All loans are cleared or there are no active loans.</p>
                <a href="{{ route('loans.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors inline-flex items-center">
                    <i class="fas fa-hand-holding-usd mr-2"></i>
                    Create New Loan
                </a>
            </div>
        @endif
    </div>

    <!-- Action Plan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Collections Action Plan</h3>
        <div class="space-y-4">
            @foreach($summary as $category => $data)
                @if($data['count'] > 0)
                    @php
                        $priority = match($category) {
                            'Over 90 days' => 'High Priority - Immediate Action Required',
                            '61-90 days' => 'Medium Priority - Follow up this week',
                            '31-60 days' => 'Low Priority - Gentle reminders',
                            default => 'Monitor',
                        };
                        
                        $action = match($category) {
                            'Over 90 days' => 'Call customer immediately. Consider collection agency if no response.',
                            '61-90 days' => 'Send payment reminder. Schedule follow-up call.',
                            '31-60 days' => 'Send friendly reminder email/text.',
                            default => 'Keep track of payment schedule.',
                        };
                    @endphp
                    <div class="border-l-4 border-{{ $loan->category_color }}-500 pl-4 py-2">
                        <h4 class="font-semibold text-gray-900">{{ $category }} ({{ $data['count'] }} loans)</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-medium">Priority:</span> {{ $priority }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Action:</span> {{ $action }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Total Amount:</span> 
                            <span class="font-semibold text-{{ $loan->category_color }}-600">
                                ${{ number_format($data['amount'], 2) }}
                            </span>
                        </p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection