<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoanTrack Pro - Simple Loan Management for Kenyan Shops</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }
        
        .hero-bg {
            background: linear-gradient(135deg, #ffffff 0%, #fef2f2 100%);
        }
        
        .accent-red {
            color: #dc2626;
        }
        
        .bg-accent-red {
            background-color: #dc2626;
        }
        
        .border-accent-red {
            border-color: #dc2626;
        }
        
        .btn-primary {
            background: #dc2626;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(220, 38, 38, 0.3);
        }
        
        .feature-card {
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            border-bottom-color: #dc2626;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translate(0, 0px); }
            50% { transform: translate(0, -10px); }
            100% { transform: translate(0, -0px); }
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        @media (max-width: 768px) {
            .stat-number {
                font-size: 2.5rem;
            }
        }
        
        .testimonial-card {
            background: linear-gradient(135deg, #ffffff 0%, #fef2f2 100%);
            border-left: 4px solid #dc2626;
        }
        
        .avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .kenyan-flag {
            background: linear-gradient(to bottom, #000 33%, #FF0000 33%, #FF0000 66%, #006600 66%);
            width: 24px;
            height: 16px;
            display: inline-block;
            margin-right: 8px;
            vertical-align: middle;
            border-radius: 2px;
        }
        
        .swahili-badge {
            background-color: #fef7f7;
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            margin-left: 6px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .hero-visual {
                margin-top: 2rem;
            }
            
            .floating {
                animation: none; /* Disable floating on mobile for better performance */
            }
            
            .feature-card, .testimonial-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white z-50 shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-gray-900">LoanTrack</span>
                        <span class="text-red-600 font-semibold">Pro</span>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-red-600 transition-colors font-medium">Features</a>
                    <a href="#solutions" class="text-gray-700 hover:text-red-600 transition-colors font-medium">Solutions</a>
                    <a href="#testimonials" class="text-gray-700 hover:text-red-600 transition-colors font-medium">Testimonials</a>
                    <a href="#pricing" class="text-gray-700 hover:text-red-600 transition-colors font-medium">Pricing</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="login.html" class="text-gray-700 hover:text-red-600 transition-colors font-medium hidden md:block">Login</a>
                    <a href="signup.html" class="btn-primary text-white px-4 md:px-6 py-2.5 rounded-lg font-medium text-sm md:text-base">Sign Up</a>
                    
                    <!-- Mobile menu button -->
                    <button class="md:hidden text-gray-700" id="mobile-menu-button">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden hidden bg-white border-t border-gray-100" id="mobile-menu">
            <div class="px-4 py-4 space-y-4">
                <a href="#features" class="block text-gray-700 hover:text-red-600 transition-colors font-medium py-2">Features</a>
                <a href="#solutions" class="block text-gray-700 hover:text-red-600 transition-colors font-medium py-2">Solutions</a>
                <a href="#testimonials" class="block text-gray-700 hover:text-red-600 transition-colors font-medium py-2">Testimonials</a>
                <a href="#pricing" class="block text-gray-700 hover:text-red-600 transition-colors font-medium py-2">Pricing</a>
                <a href="login.html" class="block text-gray-700 hover:text-red-600 transition-colors font-medium py-2">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-16 hero-bg overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="fade-in">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-700 text-sm font-medium mb-6">
                        <span class="w-2 h-2 bg-red-600 rounded-full mr-2"></span>
                        Trusted by 500+ Shop Owners in Kenya
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                        Simple Loan Management for 
                        <span class="accent-red">Kenyan Shops</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-600 mt-4 sm:mt-6 max-w-lg">
                        Track customer loans, process payments, and manage balances with our intuitive, no-interest loan management platform.
                    </p>
                    <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="signup.html" class="btn-primary text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold text-base sm:text-lg text-center">
                            Start Free Trial
                        </a>
                        <a href="https://calendly.com/wmunyua4/new-meeting" target="_blank" class="border-2 border-gray-300 text-gray-700 px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold text-base sm:text-lg text-center hover:border-red-600 hover:text-red-600 transition-colors">
                            Schedule Demo
                        </a>
                    </div>
                    <div class="mt-4 sm:mt-6 flex items-center text-gray-500 text-sm sm:text-base">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        <span>No credit card required • Free setup assistance</span>
                    </div>
                </div>

                <!-- Hero Visual -->
                <div class="relative fade-in hero-visual">
                    <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-6 floating">
                        <!-- Dashboard Mockup -->
                        <div class="border border-gray-200 rounded-xl overflow-hidden">
                            <!-- Mockup Header -->
                            <div class="bg-gray-50 px-3 sm:px-4 py-2 sm:py-3 border-b border-gray-200 flex items-center justify-between">
                                <div class="flex space-x-2">
                                    <div class="w-2 h-2 sm:w-3 sm:h-3 bg-red-500 rounded-full"></div>
                                    <div class="w-2 h-2 sm:w-3 sm:h-3 bg-yellow-500 rounded-full"></div>
                                    <div class="w-2 h-2 sm:w-3 sm:h-3 bg-green-500 rounded-full"></div>
                                </div>
                                <div class="text-xs sm:text-sm text-gray-500 font-medium">LoanTrack Dashboard</div>
                                <div class="w-4 sm:w-6"></div>
                            </div>
                            
                            <!-- Mockup Content -->
                            <div class="p-3 sm:p-6">
                                <!-- Stats Row -->
                                <div class="grid grid-cols-3 gap-2 sm:gap-4 mb-4 sm:mb-6">
                                    <div class="text-center p-2 sm:p-4 bg-red-50 rounded-lg">
                                        <div class="text-lg sm:text-2xl font-bold text-red-600">520+</div>
                                        <div class="text-xs text-gray-600 mt-1">Shops</div>
                                    </div>
                                    <div class="text-center p-2 sm:p-4 bg-green-50 rounded-lg">
                                        <div class="text-lg sm:text-2xl font-bold text-green-600">KSh 400k+</div>
                                        <div class="text-xs text-gray-600 mt-1">Active Loans</div>
                                    </div>
                                    <div class="text-center p-2 sm:p-4 bg-blue-50 rounded-lg">
                                        <div class="text-lg sm:text-2xl font-bold text-blue-600">94%</div>
                                        <div class="text-xs text-gray-600 mt-1">Recovery Rate</div>
                                    </div>
                                </div>
                                
                                <!-- Recent Activity -->
                                <div class="space-y-2 sm:space-y-3">
                                    <div class="flex justify-between items-center py-1 sm:py-2 border-b border-gray-100">
                                        <div class="pr-2">
                                            <div class="font-medium text-gray-900 text-sm sm:text-base">Kamau Groceries</div>
                                            <div class="text-xs text-gray-500">Payment via M-Pesa</div>
                                        </div>
                                        <div class="text-green-600 font-semibold text-sm sm:text-base">+KSh 2,000</div>
                                    </div>
                                    <div class="flex justify-between items-center py-1 sm:py-2 border-b border-gray-100">
                                        <div class="pr-2">
                                            <div class="font-medium text-gray-900 text-sm sm:text-base">Njeri Fashions</div>
                                            <div class="text-xs text-gray-500">New loan created</div>
                                        </div>
                                        <div class="text-red-600 font-semibold text-sm sm:text-base">-KSh 5,000</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -right-4 w-16 h-16 sm:w-20 sm:h-20 bg-red-100 rounded-full opacity-50 floating" style="animation-delay: 0.2s;"></div>
                    <div class="absolute -bottom-4 -left-4 w-20 h-20 sm:w-24 sm:h-24 bg-red-50 rounded-full opacity-70 floating" style="animation-delay: 0.4s;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-8 sm:py-12 bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 text-center">
                <div class="fade-in">
                    <div class="stat-number">500+</div>
                    <p class="text-gray-600 font-medium text-sm sm:text-base">Shop Owners</p>
                </div>
                <div class="fade-in">
                    <div class="stat-number">KSh 400k+</div>
                    <p class="text-gray-600 font-medium text-sm sm:text-base">Loans Managed</p>
                </div>
                <div class="fade-in">
                    <div class="stat-number">98%</div>
                    <p class="text-gray-600 font-medium text-sm sm:text-base">Satisfaction Rate</p>
                </div>
                <div class="fade-in">
                    <div class="stat-number">24/7</div>
                    <p class="text-gray-600 font-medium text-sm sm:text-base">Support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-12 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center fade-in">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">Designed for Kenyan Shop Owners</h2>
                <p class="text-lg sm:text-xl text-gray-600 mt-3 sm:mt-4 max-w-2xl mx-auto">
                    Everything you need to manage customer loans efficiently, without the complexity
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mt-8 sm:mt-16">
                <!-- Feature 1 -->
                <div class="feature-card bg-white rounded-xl p-6 sm:p-8 border border-gray-100 fade-in">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-red-50 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-user-friends text-red-600 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3">Customer Management</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Organize customer information, contact details, and loan history in one centralized system.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white rounded-xl p-6 sm:p-8 border border-gray-100 fade-in">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-red-50 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-file-invoice-dollar text-red-600 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3">Loan Tracking</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Monitor principal amounts, track balances, and view payment history with zero interest calculations.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white rounded-xl p-6 sm:p-8 border border-gray-100 fade-in">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-red-50 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-mobile-alt text-red-600 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3">M-Pesa Integration <span class="swahili-badge">mpya</span></h3>
                    <p class="text-gray-600 text-sm sm:text-base">Record customer payments via M-Pesa and automatically update loan balances in real-time.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-white rounded-xl p-6 sm:p-8 border border-gray-100 fade-in">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-red-50 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-bell text-red-600 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3">SMS Alerts <span class="swahili-badge">rahisi</span></h3>
                    <p class="text-gray-600 text-sm sm:text-base">Receive timely SMS notifications for due payments, completed loans, and important updates.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-white rounded-xl p-6 sm:p-8 border border-gray-100 fade-in">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-red-50 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-chart-bar text-red-600 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3">Reports & Analytics</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Generate comprehensive reports and gain insights into your loan portfolio performance.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-white rounded-xl p-6 sm:p-8 border border-gray-100 fade-in">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-red-50 rounded-xl flex items-center justify-center mb-4 sm:mb-6">
                        <i class="fas fa-sync text-red-600 text-xl sm:text-2xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 sm:mb-3">Cross-Platform</h3>
                    <p class="text-gray-600 text-sm sm:text-base">Works on mobile, tablet, or computer - access your loan management from any device.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions Section -->
    <section id="solutions" class="py-12 sm:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 items-center">
                <!-- Content -->
                <div class="fade-in">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">Perfect for All Types of Kenyan Shops</h2>
                    <p class="text-lg sm:text-xl text-gray-600 mt-3 sm:mt-4">
                        Whether you run a grocery store, clothing boutique, electronics shop, or general store, LoanTrack adapts to your business needs.
                    </p>
                    
                    <div class="mt-6 sm:mt-8 space-y-4 sm:space-y-6">
                        <div class="flex items-start">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-red-100 rounded-full flex items-center justify-center mt-1 mr-3 sm:mr-4">
                                <i class="fas fa-check text-red-600 text-xs sm:text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base">No Technical Skills Required</h4>
                                <p class="text-gray-600 mt-1 text-sm sm:text-base">Simple interface designed for shop owners, not tech experts</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-red-100 rounded-full flex items-center justify-center mt-1 mr-3 sm:mr-4">
                                <i class="fas fa-check text-red-600 text-xs sm:text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base">Setup in Minutes <span class="swahili-badge">haraka</span></h4>
                                <p class="text-gray-600 mt-1 text-sm sm:text-base">Get started immediately with our guided setup process</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 bg-red-100 rounded-full flex items-center justify-center mt-1 mr-3 sm:mr-4">
                                <i class="fas fa-check text-red-600 text-xs sm:text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base">Grows With Your Business</h4>
                                <p class="text-gray-600 mt-1 text-sm sm:text-base">Scale from 10 to 10,000 customers without changing systems</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visual -->
                <div class="fade-in">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
                        <div class="grid grid-cols-2 gap-4 sm:gap-6">
                            <div class="text-center p-4 sm:p-6 bg-red-50 rounded-xl">
                                <i class="fas fa-store text-red-600 text-2xl sm:text-3xl mb-3 sm:mb-4"></i>
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base">Retail Stores</h4>
                            </div>
                            <div class="text-center p-4 sm:p-6 bg-red-50 rounded-xl">
                                <i class="fas fa-tshirt text-red-600 text-2xl sm:text-3xl mb-3 sm:mb-4"></i>
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base">Fashion Boutiques</h4>
                            </div>
                            <div class="text-center p-4 sm:p-6 bg-red-50 rounded-xl">
                                <i class="fas fa-mobile-alt text-red-600 text-2xl sm:text-3xl mb-3 sm:mb-4"></i>
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base">Electronics</h4>
                            </div>
                            <div class="text-center p-4 sm:p-6 bg-red-50 rounded-xl">
                                <i class="fas fa-utensils text-red-600 text-2xl sm:text-3xl mb-3 sm:mb-4"></i>
                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base">Grocery Stores</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-12 sm:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center fade-in">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">Trusted by Kenyan Shop Owners</h2>
                <p class="text-lg sm:text-xl text-gray-600 mt-3 sm:mt-4">See how LoanTrack is transforming small businesses across Kenya</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 mt-8 sm:mt-16">
                <!-- Testimonial 1 -->
                <div class="testimonial-card rounded-xl p-6 sm:p-8 fade-in">
                    <div class="flex items-center mb-4 sm:mb-6">
                        <img src="" alt="John Kamau" class="avatar">
                        <div class="ml-3 sm:ml-4">
                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base">John Kamau</h4>
                            <p class="text-gray-500 text-xs sm:text-sm">MwendAdu Hardware, Kikuyu</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm sm:text-base">
                        "We've improved our loan recovery rate from 75% to 94% after implementing LoanTrack. The reminder system works perfectly for our customers."
                    </p>
                    <div class="flex text-red-400 mt-3 sm:mt-4 text-sm sm:text-base">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card rounded-xl p-6 sm:p-8 fade-in">
                    <div class="flex items-center mb-4 sm:mb-6">
                        <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fGJsYWNrJTIwd29tYW58ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=500&q=60" alt="Grace Njeri" class="avatar">
                        <div class="ml-3 sm:ml-4">
                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base">Grace Njeri</h4>
                            <p class="text-gray-500 text-xs sm:text-sm">Optimax Electronics, Mombasa</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm sm:text-base">
                        "The payment tracking feature has eliminated all disputes with customers. Everyone can see the clear payment history. <span class="swahili-badge">nzuri sana</span>"
                    </p>
                    <div class="flex text-red-400 mt-3 sm:mt-4 text-sm sm:text-base">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card rounded-xl p-6 sm:p-8 fade-in">
                    <div class="flex items-center mb-4 sm:mb-6">
                        <img src="" alt="David Ochieng" class="avatar">
                        <div class="ml-3 sm:ml-4">
                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base">David Ochieng</h4>
                            <p class="text-gray-500 text-xs sm:text-sm">ElectroSmart, Kisumu</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm sm:text-base">
                        "We've reduced our loan tracking time by 80%. What used to take hours with paper records now takes minutes with LoanTrack. <span class="swahili-badge">bora</span>"
                    </p>
                    <div class="flex text-red-400 mt-3 sm:mt-4 text-sm sm:text-base">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-12 sm:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center fade-in">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">Simple, Honest Pricing</h2>
                <p class="text-lg sm:text-xl text-gray-600 mt-3 sm:mt-4">Start free, upgrade as you grow</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 max-w-4xl mx-auto mt-8 sm:mt-16">
                <!-- Free Plan -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-200 fade-in hover:border-red-300 transition-colors">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Starter Trial</h3>
                    <div class="mb-4 sm:mb-6">
                        <span class="text-3xl sm:text-4xl font-bold text-gray-900">KSh 100</span>
                        <span class="text-gray-600">/month</span>
                    </div>
                    <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">Perfect for small shops just getting started with digital loan management</p>
                    <ul class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        <li class="flex items-center text-gray-600 text-sm sm:text-base">
                            <i class="fas fa-check text-green-500 mr-2 sm:mr-3"></i>
                            Up to 50 customers
                        </li>
                        <li class="flex items-center text-gray-600 text-sm sm:text-base">
                            <i class="fas fa-check text-green-500 mr-2 sm:mr-3"></i>
                            Basic loan tracking
                        </li>
                        <li class="flex items-center text-gray-600 text-sm sm:text-base">
                            <i class="fas fa-check text-green-500 mr-2 sm:mr-3"></i>
                            Email notifications
                        </li>
                        <li class="flex items-center text-gray-600 text-sm sm:text-base">
                            <i class="fas fa-check text-green-500 mr-2 sm:mr-3"></i>
                            Standard reports
                        </li>
                    </ul>
                    <a href="signup.html" class="block w-full bg-gray-100 text-gray-800 py-3 rounded-lg font-semibold text-center text-sm sm:text-base hover:bg-gray-200 transition-colors">
                        Get Started Free
                    </a>
                </div>

                <!-- Pro Plan -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border-2 border-red-500 shadow-lg fade-in relative">
                    <div class="absolute -top-3 sm:-top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-red-500 text-white px-3 sm:px-4 py-1 rounded-full text-xs sm:text-sm font-semibold">MOST POPULAR</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Professional</h3>
                    <div class="mb-4 sm:mb-6">
                        <span class="text-3xl sm:text-4xl font-bold text-gray-900">KSh 350</span>
                        <span class="text-gray-600">/month</span>
                    </div>
                    <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">For growing shops that need advanced features and unlimited capacity</p>
                    <ul class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                        <li class="flex items-center text-gray-600 text-sm sm:text-base">
                            <i class="fas fa-check text-red-500 mr-2 sm:mr-3"></i>
                            Unlimited customers
                        </li>
                        <li class="flex items-center text-gray-600 text-sm sm:text-base">
                            <i class="fas fa-check text-red-500 mr-2 sm:mr-3"></i>
                            Advanced analytics
                        </li>
                        <li class="flex items-center text-gray-600 text-sm sm:text-base">
                            <i class="fas fa-check text-red-500 mr-2 sm:mr-3"></i>
                            SMS & email alerts <span class="swahili-badge">muhimu</span>
                        </li>
                        <li class="flex items-center text-gray-600 text-sm sm:text-base">
                            <i class="fas fa-check text-red-500 mr-2 sm:mr-3"></i>
                            Priority support
                        </li>
                        <li class="flex items-center text-gray-600 text-sm sm:text-base">
                            <i class="fas fa-check text-red-500 mr-2 sm:mr-3"></i>
                            Custom reports
                        </li>
                    </ul>
                    <a href="signup.html" class="block w-full bg-red-600 text-white py-3 rounded-lg font-semibold text-center text-sm sm:text-base hover:bg-red-700 transition-colors">
                        Start Professional Trial
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 sm:py-20 bg-white border-t border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4 sm:mb-6">Ready to Simplify Your Loan Management?</h2>
            <p class="text-lg sm:text-xl text-gray-600 mb-6 sm:mb-8">Join hundreds of Kenyan shop owners who have transformed their business with LoanTrack Pro</p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <a href="signup.html" class="btn-primary text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold text-base sm:text-lg">
                    Start Free Trial
                </a>
                <a href="https://calendly.com/wmunyua4/new-meeting" target="_blank" class="border-2 border-gray-300 text-gray-700 px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold text-base sm:text-lg hover:border-red-600 hover:text-red-600 transition-colors">
                    Schedule Demo
                </a>
            </div>
            <p class="text-gray-500 mt-4 sm:mt-6 text-sm sm:text-base">No credit card required • Free onboarding support • 30-day money back guarantee</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 sm:gap-8">
                <!-- Brand -->
                <div>
                    <div class="flex items-center space-x-3 mb-3 sm:mb-4">
                        <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-white text-sm"></i>
                        </div>
                        <div>
                            <span class="text-xl font-bold">LoanTrack</span>
                            <span class="text-red-400 font-semibold">Pro</span>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm sm:text-base">Modern loan management solutions for forward-thinking Kenyan shop owners.</p>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="font-semibold mb-3 sm:mb-4 text-sm sm:text-base">Product</h4>
                    <ul class="space-y-1 sm:space-y-2 text-gray-400 text-sm sm:text-base">
                        <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#solutions" class="hover:text-white transition-colors">Solutions</a></li>
                        <li><a href="#pricing" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Updates</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="font-semibold mb-3 sm:mb-4 text-sm sm:text-base">Company</h4>
                    <ul class="space-y-1 sm:space-y-2 text-gray-400 text-sm sm:text-base">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="font-semibold mb-3 sm:mb-4 text-sm sm:text-base">Support</h4>
                    <ul class="space-y-1 sm:space-y-2 text-gray-400 text-sm sm:text-base">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="login.html" class="hover:text-white transition-colors">Login</a></li>
                        <li><a href="signup.html" class="hover:text-white transition-colors">Sign Up</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-6 sm:mt-8 pt-6 sm:pt-8 text-center text-gray-400 text-sm sm:text-base">
                <p>&copy; 2025 LoanTrack Pro. All rights reserved. Built for Kenyan shop owners.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-button');
            if (!menu.contains(event.target) && !button.contains(event.target) && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

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
    </script>
</body>
</html>