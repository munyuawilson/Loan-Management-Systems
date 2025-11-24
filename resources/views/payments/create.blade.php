@extends('layouts.shop')

@section('title', 'Record Payment - LoanTrack Pro')
@section('page-title', 'Record Payment')
@section('page-description', 'Record a payment for loan #' . $loan->id)

@section('breadcrumb')
    Record Payment
@endsection

@section('page-actions')
    <a href="{{ route('loans.show', $loan) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition-colors flex items-center">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Loan
    </a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Record Payment</h2>
            <p class="text-sm text-gray-600 mt-1">Record a payment for the selected loan</p>
        </div>

        <!-- Loan Summary -->
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <h3 class="text-md font-semibold text-gray-900 mb-3">Loan Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Loan ID:</span>
                    <span class="font-medium ml-2">#{{ $loan->id }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Customer:</span>
                    <span class="font-medium ml-2">{{ $loan->customer->name }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Principal Amount:</span>
                    <span class="font-medium ml-2">${{ number_format($loan->amount, 2) }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Current Balance:</span>
                    <span class="font-medium text-red-600 ml-2">${{ number_format($loan->balance, 2) }}</span>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="mt-4">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>Payment Progress</span>
                    <span>{{ number_format((($loan->amount - $loan->balance) / $loan->amount) * 100, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-600 h-2 rounded-full" 
                         style="width: {{ ($loan->amount - $loan->balance) / $loan->amount * 100 }}%">
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('payments.store', $loan) }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Payment Amount -->
                <div>
                    <label for="amount_paid" class="block text-sm font-medium text-gray-700 mb-2">Payment Amount *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input type="number" name="amount_paid" id="amount_paid" required step="0.01" min="0.01" max="{{ $loan->balance }}"
                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="0.00"
                               value="{{ old('amount_paid') }}">
                    </div>
                    @error('amount_paid')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maximum allowed: ${{ number_format($loan->balance, 2) }}</p>
                </div>

                <!-- Payment Date -->
                <div>
                    <label for="paid_at" class="block text-sm font-medium text-gray-700 mb-2">Payment Date</label>
                    <input type="datetime-local" name="paid_at" id="paid_at"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                           value="{{ old('paid_at', now()->format('Y-m-d\TH:i')) }}">
                    @error('paid_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Leave empty for current date and time</p>
                </div>

                <!-- Payment Summary -->
                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                    <h3 class="text-md font-semibold text-green-900 mb-3">Payment Summary</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-green-700">Current Balance:</span>
                            <span class="font-medium text-green-900">${{ number_format($loan->balance, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-green-700">Payment Amount:</span>
                            <span class="font-medium text-green-900" id="summaryAmount">$0.00</span>
                        </div>
                        <div class="flex justify-between border-t border-green-200 pt-2">
                            <span class="text-green-700 font-semibold">New Balance:</span>
                            <span class="font-semibold text-green-900" id="summaryBalance">${{ number_format($loan->balance, 2) }}</span>
                        </div>
                        <div id="fullPaymentMessage" class="hidden mt-2 p-2 bg-green-100 border border-green-300 rounded text-green-800 text-sm">
                            <i class="fas fa-check-circle mr-1"></i>
                            This payment will fully clear the loan!
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('loans.show', $loan) }}" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors flex items-center">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    Record Payment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Update payment summary in real-time
    document.getElementById('amount_paid').addEventListener('input', function() {
        const amountPaid = parseFloat(this.value) || 0;
        const currentBalance = {{ $loan->balance }};
        const newBalance = currentBalance - amountPaid;
        
        document.getElementById('summaryAmount').textContent = '$' + amountPaid.toFixed(2);
        document.getElementById('summaryBalance').textContent = '$' + newBalance.toFixed(2);
        
        // Show full payment message
        const fullPaymentMessage = document.getElementById('fullPaymentMessage');
        if (newBalance <= 0) {
            fullPaymentMessage.classList.remove('hidden');
        } else {
            fullPaymentMessage.classList.add('hidden');
        }
        
        // Update input max dynamically
        this.max = currentBalance;
    });
</script>
@endsection