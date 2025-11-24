@extends('layouts.shop')

@section('title', 'Dashboard - LoanTrack Pro')
@section('page-title', 'Dashboard')
@section('page-description', 'Welcome to your loan management dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_customers'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                    <i class="fas fa-hand-holding-usd text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Running Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['running_loans'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Cleared Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['cleared_loans'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg mr-4">
                    <i class="fas fa-money-bill-wave text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Balance</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_balance'] ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('customers.create') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover group hover:border-red-300 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-red-600">Add Customer</h3>
                    <p class="text-gray-600 mt-2">Register a new customer</p>
                </div>
                <i class="fas fa-user-plus text-gray-400 group-hover:text-red-600 text-xl transition-colors"></i>
            </div>
        </a>

        <a href="{{ route('loans.create') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover group hover:border-red-300 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-red-600">Create Loan</h3>
                    <p class="text-gray-600 mt-2">Record a new loan</p>
                </div>
                <i class="fas fa-hand-holding-usd text-gray-400 group-hover:text-red-600 text-xl transition-colors"></i>
            </div>
        </a>

        <a href="{{ route('reports.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover group hover:border-red-300 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-red-600">View Reports</h3>
                    <p class="text-gray-600 mt-2">Generate loan statements</p>
                </div>
                <i class="fas fa-chart-bar text-gray-400 group-hover:text-red-600 text-xl transition-colors"></i>
            </div>
        </a>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Loans</h2>
        </div>
        <div class="p-6">
            <!-- Recent loans content here -->
        </div>
    </div>
</div>
@endsection