@extends('layouts.shop')

@section('title', 'Edit Customer - LoanTrack Pro')
@section('page-title', 'Edit Customer')
@section('page-description', 'Update customer information')

@section('breadcrumb')
    Edit Customer
@endsection

@section('page-actions')
    <a href="{{ route('customers.show', $customer) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-600 transition-colors flex items-center">
        <i class="fas fa-arrow-left mr-2"></i>
        Back to Customer
    </a>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Edit Customer Information</h2>
            <p class="text-sm text-gray-600 mt-1">Update the customer details below</p>
        </div>

        <form action="{{ route('customers.update', $customer) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Details</h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="name" id="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                   placeholder="Enter customer full name"
                                   value="{{ old('name', $customer->name) }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" name="phone" id="phone" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                       placeholder="Enter phone number"
                                       value="{{ old('phone', $customer->phone) }}">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" id="email"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                       placeholder="Enter email address (optional)"
                                       value="{{ old('email', $customer->email) }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('customers.show', $customer) }}" class="text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    Cancel
                </a>
                <div class="flex items-center space-x-3">
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Update Customer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection