{{-- resources/views/reports/index.blade.php --}}
@extends('layouts.shop')

@section('title', 'Reports - LoanTrack Pro')
@section('page-title', 'Reports')
@section('page-description', 'Generate and view detailed reports')

@section('content')
<div class="space-y-6">
    <!-- Report Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Daily Collections -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-calendar-day text-green-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Daily Collections</h3>
                    <p class="text-gray-600 text-sm mb-4">View all payments received on a specific day</p>
                    <a href="{{ route('reports.daily-collections') }}" class="inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm">
                        Generate Report
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Customer Statement -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-user-tag text-blue-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Customer Statement</h3>
                    <p class="text-gray-600 text-sm mb-4">Detailed transaction history for any customer</p>
                    <a href="{{ route('reports.customer-statement') }}" class="inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm">
                        Generate Report
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Running Loans -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-running text-yellow-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Running Loans</h3>
                    <p class="text-gray-600 text-sm mb-4">All active loans with outstanding balances</p>
                    <a href="{{ route('reports.running-loans') }}" class="inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm">
                        Generate Report
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Ageing Analysis -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-orange-100 rounded-lg">
                    <i class="fas fa-hourglass-half text-orange-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Ageing Analysis</h3>
                    <p class="text-gray-600 text-sm mb-4">Loans categorized by days outstanding</p>
                    <a href="{{ route('reports.ageing-analysis') }}" class="inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm">
                        Generate Report
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Payment Trends -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-purple-100 rounded-lg">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Payment Trends</h3>
                    <p class="text-gray-600 text-sm mb-4">Payment patterns over time</p>
                    <a href="{{ route('reports.payment-trends') }}" class="inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm">
                        Generate Report
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Loan Portfolio -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-chart-pie text-red-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Loan Portfolio</h3>
                    <p class="text-gray-600 text-sm mb-4">Complete overview of your loan book</p>
                    <a href="{{ route('reports.loan-portfolio') }}" class="inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm">
                        Generate Report
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $shop = auth()->user()->shop;
                $totalLoans = $shop ? $shop->loans()->count() : 0;
                $runningLoans = $shop ? $shop->loans()->where('status', 'running')->count() : 0;
                $totalBalance = $shop ? $shop->loans()->sum('balance') : 0;
                $totalCustomers = $shop ? $shop->customers()->count() : 0;
            @endphp
            
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">{{ $totalLoans }}</div>
                <div class="text-sm text-gray-600">Total Loans</div>
            </div>
            
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600">{{ $runningLoans }}</div>
                <div class="text-sm text-gray-600">Running Loans</div>
            </div>
            
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-red-600">${{ number_format($totalBalance, 2) }}</div>
                <div class="text-sm text-gray-600">Outstanding Balance</div>
            </div>
            
            <div class="text-center p-4 bg-gray-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ $totalCustomers }}</div>
                <div class="text-sm text-gray-600">Total Customers</div>
            </div>
        </div>
    </div>
</div>
@endsection