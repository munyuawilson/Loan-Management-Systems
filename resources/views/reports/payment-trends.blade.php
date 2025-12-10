@extends('layouts.shop')

@section('title', 'Payment Trends - LoanTrack Pro')
@section('page-title', 'Payment Trends Report')
@section('page-description', 'Analyze payment patterns over time')

@section('page-actions')
    <div class="flex items-center space-x-3">
        <form method="GET" action="{{ route('reports.payment-trends') }}" class="flex items-center space-x-2">
            <select name="period" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
            <select name="days" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                <option value="7" {{ $days == 7 ? 'selected' : '' }}>Last 7 days</option>
                <option value="30" {{ $days == 30 ? 'selected' : '' }}>Last 30 days</option>
                <option value="90" {{ $days == 90 ? 'selected' : '' }}>Last 90 days</option>
                <option value="180" {{ $days == 180 ? 'selected' : '' }}>Last 180 days</option>
            </select>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                Apply
            </button>
        </form>
        <button onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition-colors flex items-center">
            <i class="fas fa-print mr-2"></i>
            Print
        </button>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Collections</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($totalAmount, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Average Daily</p>
                    <p class="text-2xl font-bold text-blue-600">${{ number_format($averageAmount, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg mr-4">
                    <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Period</p>
                    <p class="text-2xl font-bold text-purple-600">{{ ucfirst($period) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Last {{ $days }} days</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Trends Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Payment Trends Over Time</h3>
        
        <!-- Simple Bar Chart Visualization -->
        <div class="relative h-64 mt-8">
            @php
                $maxAmount = $payments->max('total') ?? 1;
                $chartHeight = 200;
            @endphp
            
            <div class="absolute bottom-0 left-0 right-0 flex items-end justify-between space-x-1 px-8">
                @foreach($payments as $payment)
                    @php
                        $barHeight = ($payment->total / $maxAmount) * $chartHeight;
                        $colorClass = $payment->total >= ($maxAmount * 0.7) ? 'bg-green-500' : 
                                     ($payment->total >= ($maxAmount * 0.4) ? 'bg-yellow-500' : 'bg-red-500');
                    @endphp
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-8 {{ $colorClass }} rounded-t-lg transition-all hover:opacity-80" 
                             style="height: {{ $barHeight }}px"
                             title="{{ $payment->period }}: ${{ number_format($payment->total, 2) }}">
                        </div>
                        <div class="text-xs text-gray-500 mt-2 truncate w-full text-center">
                            @if($period == 'daily')
                                {{ \Carbon\Carbon::parse($payment->period)->format('d M') }}
                            @else
                                {{ $payment->period }}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Legend -->
        <div class="mt-12 flex justify-center space-x-6">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600">High Collection (${{ number_format($maxAmount * 0.7, 2) }}+)</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-yellow-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600">Medium (${{ number_format($maxAmount * 0.4, 2) }}+)</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600">Low</span>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Detailed Payment Data</h3>
        </div>

        @if($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Collected</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compared to Avg</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trend</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $previousTotal = null;
                        @endphp
                        @foreach($payments as $index => $payment)
                        @php
                            $status = $payment->total >= ($maxAmount * 0.7) ? 'High' : 
                                     ($payment->total >= ($maxAmount * 0.4) ? 'Medium' : 'Low');
                            
                            $statusColor = $status == 'High' ? 'text-green-600 bg-green-100' : 
                                          ($status == 'Medium' ? 'text-yellow-600 bg-yellow-100' : 'text-red-600 bg-red-100');
                            
                            $difference = $payment->total - $averageAmount;
                            $trend = $index > 0 ? $payment->total - $previousTotal : 0;
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $payment->period }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-lg font-bold text-gray-900">${{ number_format($payment->total, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm {{ $difference >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    <i class="fas fa-arrow-{{ $difference >= 0 ? 'up' : 'down' }} mr-1"></i>
                                    ${{ number_format(abs($difference), 2) }}
                                    <span class="text-gray-500 text-xs ml-1">
                                        ({{ $averageAmount > 0 ? number_format(($difference / $averageAmount) * 100, 1) : '0' }}%)
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($index > 0)
                                    <div class="text-sm {{ $trend >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        <i class="fas fa-arrow-{{ $trend >= 0 ? 'up' : 'down' }} mr-1"></i>
                                        ${{ number_format(abs($trend), 2) }}
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">—</span>
                                @endif
                            </td>
                        </tr>
                        @php
                            $previousTotal = $payment->total;
                        @endphp
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td class="px-6 py-4 text-right text-sm font-semibold text-gray-900">
                                Average:
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-blue-600">
                                ${{ number_format($averageAmount, 2) }}
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-line text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No payment data</h3>
                <p class="text-gray-600 mb-6">No payments were recorded in the selected period.</p>
                <a href="{{ route('reports.index') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Reports
                </a>
            </div>
        @endif
    </div>

    <!-- Insights -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Trend Insights</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Best Performing Day</h4>
                @if($payments->count() > 0)
                    @php
                        $bestDay = $payments->sortByDesc('total')->first();
                    @endphp
                    <p class="text-2xl font-bold text-green-600">${{ number_format($bestDay->total, 2) }}</p>
                    <p class="text-gray-600 text-sm">{{ $bestDay->period }}</p>
                @else
                    <p class="text-gray-500">No data available</p>
                @endif
            </div>
            <div>
                <h4 class="font-medium text-gray-900 mb-2">Consistency Score</h4>
                @if($payments->count() > 1)
                    @php
                        $stdDev = sqrt($payments->map(function($p) use ($averageAmount) {
                            return pow($p->total - $averageAmount, 2);
                        })->sum() / $payments->count());
                        $consistency = $stdDev > 0 ? (1 - ($stdDev / $averageAmount)) * 100 : 100;
                    @endphp
                    <p class="text-2xl font-bold {{ $consistency >= 70 ? 'text-green-600' : ($consistency >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ number_format($consistency, 0) }}%
                    </p>
                    <p class="text-gray-600 text-sm">
                        {{ $consistency >= 70 ? 'Very consistent' : ($consistency >= 50 ? 'Moderately consistent' : 'Inconsistent') }} collections
                    </p>
                @else
                    <p class="text-gray-500">Need more data</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection