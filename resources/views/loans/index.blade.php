@extends('layouts.shop')

@section('title', 'Loans - LoanTrack Pro')
@section('page-title', 'Loans')
@section('page-description', 'Manage all customer loans')

@section('page-actions')
    <a href="{{ route('loans.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
        <i class="fas fa-hand-holding-usd mr-2"></i>
        Create Loan
    </a>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Loan Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4">
                    <i class="fas fa-hand-holding-usd text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Loans</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $loans->count() }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $loans->where('status', 'running')->count() }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $loans->where('status', 'cleared')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg mr-4">
                    <i class="fas fa-money-bill-wave text-red-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Balance</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($loans->sum('balance'), 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="{{ route('loans.index') }}" class="{{ !request()->has('status') ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500' }} group inline-flex items-center py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                    <i class="fas fa-list mr-2"></i>
                    All Loans
                    <span class="bg-gray-100 text-gray-900 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $loans->count() }}</span>
                </a>
                <a href="{{ route('loans.running') }}" class="{{ request()->routeIs('loans.running') ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500' }} group inline-flex items-center py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                    <i class="fas fa-clock mr-2"></i>
                    Running
                    <span class="bg-red-100 text-red-800 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $loans->where('status', 'running')->count() }}</span>
                </a>
                <a href="{{ route('loans.cleared') }}" class="{{ request()->routeIs('loans.cleared') ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500' }} group inline-flex items-center py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                    <i class="fas fa-check-circle mr-2"></i>
                    Cleared
                    <span class="bg-green-100 text-green-800 ml-2 py-0.5 px-2 rounded-full text-xs">{{ $loans->where('status', 'cleared')->count() }}</span>
                </a>
            </nav>
        </div>

        @if($loans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($loans as $loan)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">#{{ $loan->id }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $loan->description ? Str::limit($loan->description, 40) : 'No description' }}
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold 
                                {{ $loan->balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                                ${{ number_format($loan->balance, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                                        <div class="bg-red-600 h-2 rounded-full" 
                                             style="width: {{ $loan->amount > 0 ? (($loan->amount - $loan->balance) / $loan->amount) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-600">
                                        {{ number_format((($loan->amount - $loan->balance) / $loan->amount) * 100, 1) }}%
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $loan->status === 'running' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('loans.show', $loan) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($loan->status === 'running')
                                        <a href="{{ route('payments.create', $loan) }}" class="text-green-600 hover:text-green-900 transition-colors" title="Add Payment">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('loans.statement', $loan) }}" class="text-purple-600 hover:text-purple-900 transition-colors" title="Statement">
                                        <i class="fas fa-file-invoice"></i>
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
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-hand-holding-usd text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No loans yet</h3>
                <p class="text-gray-600 mb-6">Start by creating your first loan for a customer.</p>
                <a href="{{ route('loans.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors inline-flex items-center">
                    <i class="fas fa-hand-holding-usd mr-2"></i>
                    Create First Loan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection