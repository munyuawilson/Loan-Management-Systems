{{-- resources/views/help-support.blade.php --}}
@extends('layouts.shop')

@section('title', 'Help & Support - LoanTrack Pro')
@section('page-title', 'Help & Support')
@section('page-description', 'Get help with LoanTrack Pro and find answers to common questions')

@section('content')
<div class="space-y-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 text-white">
        <div class="max-w-3xl">
            <h1 class="text-3xl font-bold mb-4">How can we help you today?</h1>
            <p class="text-red-100 text-lg mb-6">Find answers to common questions or contact our support team for assistance.</p>
            
            <!-- Search Bar -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       placeholder="Search for answers, guides, or troubleshooting..." 
                       class="w-full pl-10 pr-4 py-3 rounded-lg bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-red-200 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent">
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="#getting-started" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-rocket text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Getting Started</h3>
                    <p class="text-gray-600 text-sm">New to LoanTrack Pro? Start here.</p>
                </div>
            </div>
        </a>

        <a href="#faqs" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-question-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">FAQs</h3>
                    <p class="text-gray-600 text-sm">Frequently asked questions</p>
                </div>
            </div>
        </a>

        <a href="#contact" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover">
            <div class="flex items-start space-x-4">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-headset text-red-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Contact Support</h3>
                    <p class="text-gray-600 text-sm">Get help from our team</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Getting Started Section -->
    <div id="getting-started" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Getting Started with LoanTrack Pro</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-red-600 font-bold">1</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Add Your First Customer</h3>
                </div>
                <p class="text-gray-600">Start by adding your customers who will be taking loans from your shop.</p>
                <a href="{{ route('customers.create') }}" class="inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm">
                    Add Customer <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-red-600 font-bold">2</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Create a Loan</h3>
                </div>
                <p class="text-gray-600">Create loans for your customers with amount, description, and terms.</p>
                <a href="{{ route('loans.create') }}" class="inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm">
                    Create Loan <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <span class="text-red-600 font-bold">3</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Track Payments</h3>
                </div>
                <p class="text-gray-600">Record payments and track remaining balances automatically.</p>
                <a href="{{ route('payments.index') }}" class="inline-flex items-center text-red-600 hover:text-red-700 font-medium text-sm">
                    View Payments <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- FAQs Section -->
    <div id="faqs" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
        
        <div class="space-y-6" x-data="{ openFaq: null }">
            @php
                $faqs = [
                    [
                        'question' => 'How do I add a new customer?',
                        'answer' => 'Go to Customers → Click "Add Customer" → Fill in customer details (name, phone, email) → Click "Save". Customers are automatically linked to your shop.',
                        'category' => 'Customers'
                    ],
                    [
                        'question' => 'How do I create a loan for a customer?',
                        'answer' => 'Go to Loans → Click "Create Loan" → Select a customer → Enter loan amount and description → Click "Create Loan". The system will automatically track the balance.',
                        'category' => 'Loans'
                    ],
                    [
                        'question' => 'How do I record a payment?',
                        'answer' => 'There are two ways: 1) Go to Payments → Click "Add Payment" → Select loan and enter amount. 2) From the Loans page, click the money icon next to a running loan.',
                        'category' => 'Payments'
                    ],
                    [
                        'question' => 'Can I edit a loan after creating it?',
                        'answer' => 'Yes, you can edit the loan description and amount (if no payments have been made). Go to the loan details page and click "Edit".',
                        'category' => 'Loans'
                    ],
                    [
                        'question' => 'How do I generate reports?',
                        'answer' => 'Go to Reports section → Choose the report type (Daily Collections, Customer Statement, etc.) → Apply filters if needed → View or print the report.',
                        'category' => 'Reports'
                    ],
                    [
                        'question' => 'What happens when a loan is fully paid?',
                        'answer' => 'When the loan balance reaches zero, the status automatically changes to "cleared". You can still view it in the Cleared Loans tab.',
                        'category' => 'Loans'
                    ],
                    [
                        'question' => 'Can I have multiple shops?',
                        'answer' => 'Currently, each account is linked to one shop. If you need multiple shops, contact support for assistance.',
                        'category' => 'Account'
                    ],
                    [
                        'question' => 'How do I reset my password?',
                        'answer' => 'Click on your profile picture → Select "Settings" → Go to "Security" tab → Click "Change Password".',
                        'category' => 'Account'
                    ],
                ];
            @endphp

            <!-- FAQ Categories -->
            <div class="flex flex-wrap gap-2 mb-6">
                <button @click="openFaq = null" 
                        class="px-4 py-2 rounded-full text-sm font-medium bg-red-600 text-white">
                    All Questions
                </button>
                @foreach(['Customers', 'Loans', 'Payments', 'Reports', 'Account'] as $category)
                <button @click="openFaq = '{{ $category }}'" 
                        class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                    {{ $category }}
                </button>
                @endforeach
            </div>

            <!-- FAQ Items -->
            <div class="space-y-4">
                @foreach($faqs as $index => $faq)
                <div x-show="!openFaq || openFaq === '{{ $faq['category'] }}'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="border border-gray-200 rounded-xl overflow-hidden">
                    <button @click="document.getElementById('faq-{{ $index }}').classList.toggle('hidden')"
                            class="flex justify-between items-center w-full p-6 text-left hover:bg-gray-50 transition-colors">
                        <div class="flex items-start">
                            <div class="p-2 bg-red-100 rounded-lg mr-4">
                                <i class="fas fa-question text-red-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $faq['question'] }}</h3>
                                <span class="inline-block mt-1 px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                    {{ $faq['category'] }}
                                </span>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-200" 
                           :class="{ 'rotate-180': !document.getElementById('faq-{{ $index }}').classList.contains('hidden') }"></i>
                    </button>
                    
                    <div id="faq-{{ $index }}" class="hidden p-6 pt-0 border-t border-gray-200">
                        <div class="pl-12">
                            <p class="text-gray-600">{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Contact Support Section -->
    <div id="contact" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Contact Info -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Our Support Team</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="p-3 bg-red-100 rounded-lg mr-4">
                            <i class="fas fa-envelope text-red-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Email Support</h4>
                            <p class="text-gray-600 mt-1">wmunyua4@gmail.com</p>
                            <p class="text-sm text-gray-500 mt-2">Response time: Within 24 hours</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="p-3 bg-blue-100 rounded-lg mr-4">
                            <i class="fas fa-phone text-blue-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Phone Support</h4>
                            <p class="text-gray-600 mt-1">+254711410353</p>
                            <p class="text-sm text-gray-500 mt-2">Mon-Fri: 9AM-6PM EAT</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="p-3 bg-green-100 rounded-lg mr-4">
                            <i class="fas fa-comments text-green-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Live Chat</h4>
                            <p class="text-gray-600 mt-1">Available on the dashboard</p>
                            <p class="text-sm text-gray-500 mt-2">Click the chat icon in the bottom right</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mt-6">
                        <h4 class="font-semibold text-gray-900 mb-3">Before contacting support:</h4>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-sm"></i>
                                Check the FAQs above
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-sm"></i>
                                Clear your browser cache
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-sm"></i>
                                Try refreshing the page
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2 text-sm"></i>
                                Include screenshots if reporting an error
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Support Ticket Form -->
            <div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Submit a Support Ticket</h3>
                    
                    <form method="POST" action="{{ route('help-support.ticket') }}">
                        @csrf
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Name *</label>
                                    <input type="text" 
                                           name="name" 
                                           required
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                           value="{{ auth()->user()->name }}">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Email *</label>
                                    <input type="email" 
                                           name="email" 
                                           required
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                           value="{{ auth()->user()->email }}">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                                <input type="text" 
                                       name="subject" 
                                       required
                                       placeholder="What do you need help with?"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Priority *</label>
                                <select name="priority" 
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                    <option value="low">Low - General Question</option>
                                    <option value="medium" selected>Medium - Feature Request or Bug</option>
                                    <option value="high">High - System Not Working</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Message *</label>
                                <textarea name="message" 
                                          rows="4"
                                          required
                                          placeholder="Please describe your issue in detail..."
                                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" 
                                        class="w-full bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center justify-center">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Submit Support Ticket
                                </button>
                                <p class="text-sm text-gray-500 text-center mt-3">
                                    We'll respond within 24 hours
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Troubleshooting Guides -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Common Issues & Solutions</h2>
        
        <div class="space-y-6">
            <div class="border-l-4 border-yellow-500 pl-6 py-2 bg-yellow-50 rounded-r-lg">
                <h4 class="font-semibold text-gray-900">Loans Not Appearing</h4>
                <p class="text-gray-600 mt-1">If loans disappear after loading:</p>
                <ul class="list-disc pl-5 text-gray-600 mt-2 space-y-1">
                    <li>Clear your browser cache (Ctrl+Shift+Delete)</li>
                    <li>Try a different browser</li>
                    <li>Check if you have JavaScript enabled</li>
                    <li>Contact support if issue persists</li>
                </ul>
            </div>

            <div class="border-l-4 border-blue-500 pl-6 py-2 bg-blue-50 rounded-r-lg">
                <h4 class="font-semibold text-gray-900">Cannot Add Payments</h4>
                <p class="text-gray-600 mt-1">If payment buttons don't work:</p>
                <ul class="list-disc pl-5 text-gray-600 mt-2 space-y-1">
                    <li>Refresh the page and try again</li>
                    <li>Ensure you have internet connection</li>
                    <li>Check if the loan is still "running"</li>
                    <li>Try logging out and back in</li>
                </ul>
            </div>

            <div class="border-l-4 border-green-500 pl-6 py-2 bg-green-50 rounded-r-lg">
                <h4 class="font-semibold text-gray-900">Report Generation Issues</h4>
                <p class="text-gray-600 mt-1">If reports are slow or not loading:</p>
                <ul class="list-disc pl-5 text-gray-600 mt-2 space-y-1">
                    <li>Try reducing the date range</li>
                    <li>Use the filter options to narrow results</li>
                    <li>Check your internet speed</li>
                    <li>Try during off-peak hours</li>
                </ul>
            </div>
        </div>
    </div>

    
</div>

@push('scripts')
<script>
// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Expand all FAQs button (optional)
document.addEventListener('DOMContentLoaded', function() {
    const expandAllBtn = document.createElement('button');
    expandAllBtn.className = 'px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors mb-4';
    expandAllBtn.innerHTML = '<i class="fas fa-expand-alt mr-2"></i> Expand All';
    expandAllBtn.onclick = function() {
        document.querySelectorAll('[id^="faq-"]').forEach(faq => {
            faq.classList.remove('hidden');
        });
    };
    
    const faqSection = document.querySelector('#faqs .flex.flex-wrap');
    if (faqSection) {
        faqSection.appendChild(expandAllBtn);
    }
});
</script>
@endpush
@endsection