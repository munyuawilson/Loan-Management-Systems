@extends('layouts.shop')

@section('title', $customer->name . ' - LoanTrack Pro')
@section('page-title', $customer->name)
@section('page-description', 'Customer details and loan history')

@section('breadcrumb')
    Customer Details
@endsection

@section('page-actions')
    <div class="flex items-center space-x-3">
        <a href="{{ route('loans.create') }}?customer_id={{ $customer->id }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors flex items-center">
            <i class="fas fa-hand-holding-usd mr-2"></i>
            Add Loan
        </a>
        <a href="{{ route('customers.edit', $customer) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Edit
        </a>
        <a href="{{ route('customers.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back
        </a>
    </div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Customer Information -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Customer Information</h2>
            </div>
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-red-600 font-semibold text-2xl">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h3>
                    <p class="text-gray-600">Customer ID: {{ $customer->id }}</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Phone</label>
                        <p class="text-gray-900">{{ $customer->phone }}</p>
                    </div>
                    
                    @if($customer->email)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-gray-900">{{ $customer->email }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Registered</label>
                        <p class="text-gray-900">{{ $customer->created_at->format('M d, Y') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Last Updated</label>
                        <p class="text-gray-900">{{ $customer->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Loan Summary</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Loans</span>
                        <span class="font-semibold text-gray-900">{{ $customer->loans->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Active Loans</span>
                        <span class="font-semibold text-red-600">{{ $customer->loans->where('status', 'running')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Cleared Loans</span>
                        <span class="font-semibold text-green-600">{{ $customer->loans->where('status', 'cleared')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Owed</span>
                        <span class="font-semibold text-red-600">${{ number_format($customer->loans->sum('balance'), 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan History -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Loan History</h2>
            </div>

            @if($loans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loan ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loans as $loan)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $loan->id }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($loan->description, 30) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($loan->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ${{ number_format($loan->balance, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $loan->status === 'running' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loan->created_at->format('M d, Y') }}
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
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-hand-holding-usd text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No loans yet</h3>
                    <p class="text-gray-600 mb-4">This customer doesn't have any loans recorded.</p>
                    <a href="{{ route('loans.create') }}?customer_id={{ $customer->id }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors inline-flex items-center">
                        <i class="fas fa-hand-holding-usd mr-2"></i>
                        Create First Loan
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection