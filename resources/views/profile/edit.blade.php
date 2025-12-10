{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.shop')

@section('title', 'My Profile - LoanTrack Pro')
@section('page-title', 'My Profile')
@section('page-description', 'Manage your account and shop settings')

@section('content')
<div class="space-y-8">
    <!-- Profile Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        @if($user->profile_photo)
                            <img src="{{ Storage::url($user->profile_photo) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-24 h-24 rounded-full object-cover border-4 border-white shadow">
                        @else
                            <div class="w-24 h-24 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center border-4 border-white shadow">
                                <span class="text-white text-3xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('profile.photo.delete') }}" class="absolute -bottom-2 -right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-10 h-10 bg-red-600 text-white rounded-full flex items-center justify-center hover:bg-red-700 transition-colors shadow"
                                    onclick="return confirm('Remove profile photo?')">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500 mt-1">Member since {{ $user->created_at->format('F Y') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        <i class="fas fa-check-circle mr-2"></i>
                        Active Account
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px" id="profileTabs">
                <button type="button" 
                        data-tab="personal"
                        class="tab-button border-red-500 text-red-600 group inline-flex items-center py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                    <i class="fas fa-user-circle mr-2"></i>
                    Personal Info
                </button>
                <button type="button" 
                        data-tab="security"
                        class="tab-button border-transparent text-gray-500 hover:text-gray-700 group inline-flex items-center py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                    <i class="fas fa-lock mr-2"></i>
                    Security
                </button>
                <button type="button" 
                        data-tab="shop"
                        class="tab-button border-transparent text-gray-500 hover:text-gray-700 group inline-flex items-center py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                    <i class="fas fa-store mr-2"></i>
                    Shop Settings
                </button>
                <button type="button" 
                        data-tab="preferences"
                        class="tab-button border-transparent text-gray-500 hover:text-gray-700 group inline-flex items-center py-4 px-6 border-b-2 font-medium text-sm transition-colors">
                    <i class="fas fa-cog mr-2"></i>
                    Preferences
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Personal Info Tab -->
            <div id="personalTab" class="tab-content">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       required
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                          
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1">
                                        <input type="file" 
                                               name="profile_photo"
                                               accept="image/*"
                                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Maximum file size: 2MB. Allowed formats: JPG, PNG, GIF.</p>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea name="address" 
                                          rows="3"
                                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">{{ old('address', $user->address) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="pt-6 border-t border-gray-200">
                            <button type="submit" 
                                    class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Security Tab -->
            <div id="securityTab" class="tab-content hidden">
                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="max-w-md space-y-6">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-yellow-800">Password Security</h4>
                                    <p class="text-sm text-yellow-700 mt-1">Use a strong password that includes letters, numbers, and special characters.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Password *</label>
                            <input type="password" 
                                   name="current_password" 
                                   required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">New Password *</label>
                            <input type="password" 
                                   name="password" 
                                   required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password *</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                        </div>
                        
                        <div class="pt-6">
                            <button type="submit" 
                                    class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
                                <i class="fas fa-key mr-2"></i>
                                Update Password
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Security Sessions -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Login Sessions</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">Current Session</p>
                                <p class="text-sm text-gray-600">Logged in on {{ request()->ip() }}</p>
                                <p class="text-xs text-gray-500 mt-1">Started: {{ now()->format('M d, Y h:i A') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shop Settings Tab -->
            <div id="shopTab" class="tab-content hidden">
                <form method="POST" action="{{ route('profile.shop.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Shop Logo -->
                        <div class="flex items-center space-x-6">
                            @if($shop && $shop->logo)
                                <div class="relative">
                                    <img src="{{ Storage::url($shop->logo) }}" 
                                         alt="{{ $shop->shop_name }}" 
                                         class="w-20 h-20 rounded-lg object-cover border border-gray-200">
                                    <form method="POST" action="{{ route('profile.shop-logo.delete') }}" class="absolute -top-2 -right-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-8 h-8 bg-red-600 text-white rounded-full flex items-center justify-center hover:bg-red-700 transition-colors shadow"
                                                onclick="return confirm('Remove shop logo?')">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="w-20 h-20 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-store text-red-600 text-2xl"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shop Logo</label>
                                <input type="file" 
                                       name="shop_logo"
                                       accept="image/*"
                                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                                <p class="text-xs text-gray-500 mt-2">Recommended: 200x200px, max 2MB</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shop Name *</label>
                                <input type="text" 
                                       name="shop_name" 
                                       value="{{ old('shop_name', $shop->shop_name ?? '') }}"
                                       required
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                                @error('shop_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shop Phone</label>
                                <input type="text" 
                                       name="shop_phone" 
                                       value="{{ old('shop_phone', $shop->shop_phone ?? '') }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shop Email</label>
                                <input type="email" 
                                       name="shop_email" 
                                       value="{{ old('shop_email', $shop->shop_email ?? '') }}"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                                <select name="currency" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                                    <option value="USD" {{ ($shop->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                    <option value="KES" {{ ($shop->currency ?? '') == 'KES' ? 'selected' : '' }}>KES (KSh)</option>
                                    <option value="EUR" {{ ($shop->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                    <option value="GBP" {{ ($shop->currency ?? '') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shop Address</label>
                                <textarea name="shop_address" 
                                          rows="3"
                                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">{{ old('shop_address', $shop->address ?? '') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="pt-6 border-t border-gray-200">
                            <button type="submit" 
                                    class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
                                <i class="fas fa-save mr-2"></i>
                                Save Shop Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Preferences Tab -->
            <div id="preferencesTab" class="tab-content hidden">
                <div class="space-y-6">
                    <!-- Notification Settings -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Preferences</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">Email Notifications</p>
                                    <p class="text-sm text-gray-600">Receive email alerts for important updates</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">Payment Reminders</p>
                                    <p class="text-sm text-gray-600">Get notified when payments are due</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">Loan Overdue Alerts</p>
                                    <p class="text-sm text-gray-600">Alerts for loans past due date</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Display Preferences -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Display Preferences</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                                <select class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                                    <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                                    <option value="DD/MM/YYYY">DD/MM/YYYY</option>
                                    <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Time Format</label>
                                <select class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                                    <option value="12h">12-hour (AM/PM)</option>
                                    <option value="24h">24-hour</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Items Per Page</label>
                                <select class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                                    <option value="10">10 items</option>
                                    <option value="25" selected>25 items</option>
                                    <option value="50">50 items</option>
                                    <option value="100">100 items</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Theme</label>
                                <select class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors">
                                    <option value="light">Light Mode</option>
                                    <option value="dark">Dark Mode</option>
                                    <option value="auto">Auto (System)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Export Data -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Management</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">Export Your Data</p>
                                    <p class="text-sm text-gray-600">Download all your loans, customers, and payments as CSV</p>
                                </div>
                                <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
                                    <i class="fas fa-download mr-2"></i>
                                    Export Data
                                </button>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">Delete Account</p>
                                        <p class="text-sm text-gray-600">Permanently delete your account and all data</p>
                                    </div>
                                    <button type="button" 
                                            class="bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition-colors flex items-center"
                                            onclick="confirmDeleteAccount()">
                                        <i class="fas fa-trash-alt mr-2"></i>
                                        Delete Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Tab Switching
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    // Show first tab by default
    tabContents[0].classList.remove('hidden');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Update active tab styling
            tabs.forEach(t => {
                t.classList.remove('border-red-500', 'text-red-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-red-500', 'text-red-600');
            
            // Show selected tab content
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(`${tabId}Tab`).classList.remove('hidden');
        });
    });
    
    // Check for URL hash to open specific tab
    const hash = window.location.hash.substring(1);
    if (hash && ['personal', 'security', 'shop', 'preferences'].includes(hash)) {
        document.querySelector(`[data-tab="${hash}"]`).click();
    }
});

// Preview profile photo before upload
document.addEventListener('DOMContentLoaded', function() {
    const profilePhotoInput = document.querySelector('input[name="profile_photo"]');
    const shopLogoInput = document.querySelector('input[name="shop_logo"]');
    
    if (profilePhotoInput) {
        profilePhotoInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update preview (you can add a preview element if needed)
                    console.log('Profile photo selected');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});

function confirmDeleteAccount() {
    if (confirm('Are you sure you want to delete your account? This action cannot be undone. All your data will be permanently deleted.')) {
        // In a real app, you would submit a form to delete the account
        alert('Account deletion would be processed here. In a real app, this would make an API call.');
    }
}

// Password strength indicator (optional enhancement)
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.querySelector('input[name="password"]');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            updateStrengthIndicator(strength);
        });
    }
});

function checkPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    return strength;
}

function updateStrengthIndicator(strength) {
    const indicator = document.getElementById('password-strength');
    if (!indicator) return;
    
    const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
    const texts = ['Very Weak', 'Weak', 'Fair', 'Strong'];
    
    indicator.className = `h-2 rounded-full transition-all ${colors[strength] || 'bg-gray-300'}`;
    indicator.style.width = `${(strength / 4) * 100}%`;
    
    const textElement = document.getElementById('password-strength-text');
    if (textElement) {
        textElement.textContent = texts[strength] || '';
        textElement.className = `text-sm ${strength >= 3 ? 'text-green-600' : strength >= 2 ? 'text-yellow-600' : 'text-red-600'}`;
    }
}
</script>
@endpush
@endsection