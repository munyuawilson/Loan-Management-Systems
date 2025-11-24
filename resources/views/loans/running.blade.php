@extends('layouts.shop')

@section('title', 'Running Loans - LoanTrack Pro')
@section('page-title', 'Running Loans')
@section('page-description', 'Active loans that need attention')

@section('breadcrumb')
    Running Loans
@endsection

@section('page-actions')
    <a href="{{ route('loans.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
        <i class="fas fa-hand-holding-usd mr-2"></i>
        Create Loan
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Running Loans Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $loans->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg mr-4">
                    <i class="fas fa-money-bill-wave text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Balance Due</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($loans->sum('balance'), 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Customers with Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $loans->unique('customer_id')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Running Loans Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Active Running Loans</h2>
            <p class="text-sm text-gray-600 mt-1">Loans that are currently active and have outstanding balances</p>
        </div>

        @if($loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Principal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance Due</th>
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
                                <div class="flex items-center">
                                    <div class="w-20 bg-gray-200 rounded-full h-2 mr-3">
                                        <div class="bg-red-600 h-2 rounded-full" 
                                             style="width: {{ ($loan->amount - $loan->balance) / $loan->amount * 100 }}%">
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-600">
                                        {{ number_format((($loan->amount - $loan->balance) / $loan->amount) * 100, 1) }}%
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $loan->created_at->diffInDays(now()) }} days
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('payments.create', $loan) }}" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition-colors flex items-center">
                                        <i class="fas fa-money-bill-wave mr-1"></i>
                                        Payment
                                    </a>
                                    <a href="{{ route('loans.show', $loan) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No running loans</h3>
                <p class="text-gray-600 mb-6">All loans have been cleared! Great job managing your loans.</p>
                <a href="{{ route('loans.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors inline-flex items-center">
                    <i class="fas fa-hand-holding-usd mr-2"></i>
                    Create New Loan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection