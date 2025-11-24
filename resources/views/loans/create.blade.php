@extends('layouts.shop')

@section('title', 'Create Loan - LoanTrack Pro')
@section('page-title', 'Create New Loan')
@section('page-description', 'Record a new loan for a customer')

@section('breadcrumb')
    Create Loan
@endsection

@section('page-actions')
    <a href="{{ route('loans.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition-colors flex items-center">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Loans
    </a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Loan Information</h2>
            <p class="text-sm text-gray-600 mt-1">Create a new loan for your customer</p>
        </div>

        <form action="{{ route('loans.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Customer Selection -->
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Select Customer *</label>
                    <select name="customer_id" id="customer_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        <option value="">Choose a customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" 
                                    {{ old('customer_id', request('customer_id')) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} - {{ $customer->phone }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    @if($customers->isEmpty())
                        <div class="mt-2 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                                <p class="text-yellow-800 text-sm">No customers found. 
                                    <a href="{{ route('customers.create') }}" class="font-semibold underline">Add a customer first</a>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Loan Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Loan Amount *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input type="number" name="amount" id="amount" required step="0.01" min="1"
                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="0.00"
                               value="{{ old('amount') }}">
                    </div>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Loan Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors resize-none"
                              placeholder="Optional: Purpose of the loan (e.g., Business capital, Emergency fund, etc.)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Loan Summary -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Loan Summary</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Principal Amount:</span>
                            <span class="font-medium text-gray-900" id="summaryAmount">$0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Initial Balance:</span>
                            <span class="font-medium text-red-600" id="summaryBalance">$0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium text-yellow-600">Running</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('loans.index') }}" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center"
                        {{ $customers->isEmpty() ? 'disabled' : '' }}>
                    <i class="fas fa-save mr-2"></i>
                    Create Loan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Update loan summary in real-time
    document.getElementById('amount').addEventListener('input', function() {
        const amount = parseFloat(this.value) || 0;
        document.getElementById('summaryAmount').textContent = '$' + amount.toFixed(2);
        document.getElementById('summaryBalance').textContent = '$' + amount.toFixed(2);
    });
</script>
@endsection