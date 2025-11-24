<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LoanTrack Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #fef2f2 0%, #ffffff 50%, #fef2f2 100%);
            min-height: 100vh;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(220, 38, 38, 0.1);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px -3px rgba(220, 38, 38, 0.4);
        }
        
        .input-field {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            border: 1.5px solid #e5e7eb;
        }
        
        .input-field:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: #dc2626;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            transform: translateY(-1px);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translate(0, 0px); }
            50% { transform: translate(0, -8px); }
            100% { transform: translate(0, -0px); }
        }
        
        .pulse-gentle {
            animation: pulse-gentle 3s infinite;
        }
        
        @keyframes pulse-gentle {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(220, 38, 38, 0.1);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(220, 38, 38, 0.3);
            box-shadow: 0 12px 25px -3px rgba(220, 38, 38, 0.15);
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .glow {
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 lg:p-8">
    <!-- Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-red-100 rounded-full mix-blend-multiply filter blur-3xl opacity-40 floating"></div>
        <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-red-50 rounded-full mix-blend-multiply filter blur-3xl opacity-40 floating" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/3 left-1/3 w-40 h-40 bg-red-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 floating" style="animation-delay: 4s;"></div>
    </div>

    <div class="relative w-full max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <!-- Left Section - Form -->
            <div class="fade-in">
                <div class="glass-effect rounded-3xl p-8 lg:p-12 glow">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3 mb-8">
                        <div class="w-12 h-12 gradient-bg rounded-xl flex items-center justify-center shadow-lg pulse-gentle">
                            <i class="fas fa-chart-line text-white text-xl"></i>
                        </div>
                        <div>
                            <span class="text-2xl font-bold text-gray-900">LoanTrack</span>
                            <span class="text-gradient font-semibold">Pro</span>
                        </div>
                    </div>

                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                            Welcome Back
                        </h1>
                        <p class="text-gray-600 text-lg">
                            Sign in to continue managing your shop loans
                        </p>
                    </div>

                    <!-- Login Form -->
                    <form class="space-y-6" action="{{ route('login') }}" method="POST">
                        @csrf
                        
                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-gray-700">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" name="email" type="email" autocomplete="email" required 
                                       class="input-field block w-full pl-10 pr-4 py-4 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none transition-all duration-300"
                                       placeholder="Enter your email"
                                       value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <p class="text-red-600 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" name="password" type="password" autocomplete="current-password" required 
                                       class="input-field block w-full pl-10 pr-4 py-4 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none transition-all duration-300"
                                       placeholder="Enter your password">
                            </div>
                            @error('password')
                                <p class="text-red-600 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" name="remember" type="checkbox" 
                                       class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500 bg-white transition-colors">
                                <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                            </div>

                            <a href="{{ route('password.request') }}" class="text-sm text-red-600 hover:text-red-500 transition-colors duration-300 font-medium">
                                Forgot password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="btn-primary w-full py-4 px-6 rounded-xl text-white font-semibold shadow-lg transition-all duration-300">
                            <span class="flex items-center justify-center">
                                Sign In
                                <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                            </span>
                        </button>

                        <!-- Register Link -->
                        <div class="text-center pt-4">
                            <p class="text-gray-600">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="text-red-600 hover:text-red-500 font-semibold transition-colors duration-300">
                                    Create your shop
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Section - Features -->
            <div class="fade-in hidden lg:block">
                <div class="gradient-bg rounded-3xl p-8 lg:p-12 text-white shadow-2xl relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-10 right-10 w-20 h-20 bg-white rounded-full"></div>
                        <div class="absolute bottom-10 left-10 w-16 h-16 bg-white rounded-full"></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 bg-white rounded-full"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <h2 class="text-2xl lg:text-3xl font-bold mb-8 text-center">
                            Streamline Your Loan Management
                        </h2>
                        
                        <div class="space-y-6">
                            <!-- Feature 1 -->
                            <div class="feature-card rounded-2xl p-6 cursor-pointer">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-bolt text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Lightning Fast</h3>
                                        <p class="text-gray-600 text-sm mt-1">Process loans and payments in seconds with our optimized platform</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Feature 2 -->
                            <div class="feature-card rounded-2xl p-6 cursor-pointer">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-shield-alt text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Secure & Reliable</h3>
                                        <p class="text-gray-600 text-sm mt-1">Bank-level security to protect your business data</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Feature 3 -->
                            <div class="feature-card rounded-2xl p-6 cursor-pointer">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-chart-line text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Smart Analytics</h3>
                                        <p class="text-gray-600 text-sm mt-1">Get valuable insights into your loan portfolio performance</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Feature 4 -->
                            <div class="feature-card rounded-2xl p-6 cursor-pointer">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-mobile-alt text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Mobile Friendly</h3>
                                        <p class="text-gray-600 text-sm mt-1">Manage your business from anywhere on any device</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                            <div class="text-white">
                                <div class="text-2xl font-bold">500+</div>
                                <div class="text-xs text-red-100">Active Shops</div>
                            </div>
                            <div class="text-white">
                                <div class="text-2xl font-bold">$2M+</div>
                                <div class="text-xs text-red-100">Loans Managed</div>
                            </div>
                            <div class="text-white">
                                <div class="text-2xl font-bold">99.9%</div>
                                <div class="text-xs text-red-100">Uptime</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for smooth animations -->
    <script>
        // Fade in animation
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

        // Add floating animation to feature cards with delay
        document.querySelectorAll('.feature-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });

        // Input field interactions
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('transform', 'scale-105');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('transform', 'scale-105');
            });
        });

        // Button hover effect
        const loginButton = document.querySelector('button[type="submit"]');
        if (loginButton) {
            loginButton.addEventListener('mouseenter', function() {
                this.classList.add('group');
            });
        }
    </script>
</body>
</html>