<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LoanTrack Pro</title>
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
        
        .section-divider {
            border: none;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.2), transparent);
            margin: 2rem 0;
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
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
                            Create Your Shop
                        </h1>
                        <p class="text-gray-600 text-lg">
                            Start managing loans efficiently in minutes
                        </p>
                    </div>

                    <!-- Registration Form -->
                    <form class="space-y-8" action="{{ route('register') }}" method="POST">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user text-red-600 text-sm"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label for="name" class="text-sm font-medium text-gray-700">Full Name</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                        <input id="name" name="name" type="text" required 
                                               class="input-field block w-full pl-10 pr-4 py-4 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none transition-all duration-300"
                                               placeholder="Enter your full name"
                                               value="{{ old('name') }}">
                                    </div>
                                    @error('name')
                                        <p class="text-red-600 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="email" class="text-sm font-medium text-gray-700">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input id="email" name="email" type="email" autocomplete="email" required 
                                               class="input-field block w-full pl-10 pr-4 py-4 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none transition-all duration-300"
                                               placeholder="Enter your email address"
                                               value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <p class="text-red-600 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="phone" class="text-sm font-medium text-gray-700">Phone Number</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-phone text-gray-400"></i>
                                        </div>
                                        <input id="phone" name="phone" type="tel" required 
                                               class="input-field block w-full pl-10 pr-4 py-4 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none transition-all duration-300"
                                               placeholder="Enter your phone number"
                                               value="{{ old('phone') }}">
                                    </div>
                                    @error('phone')
                                        <p class="text-red-600 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="section-divider">

                        <!-- Shop Information -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-store text-red-600 text-sm"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Shop Information</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label for="shop_name" class="text-sm font-medium text-gray-700">Shop Name</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-signature text-gray-400"></i>
                                        </div>
                                        <input id="shop_name" name="shop_name" type="text" required 
                                               class="input-field block w-full pl-10 pr-4 py-4 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none transition-all duration-300"
                                               placeholder="Enter your shop name"
                                               value="{{ old('shop_name') }}">
                                    </div>
                                    @error('shop_name')
                                        <p class="text-red-600 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="shop_phone" class="text-sm font-medium text-gray-700">Shop Phone</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-phone-alt text-gray-400"></i>
                                        </div>
                                        <input id="shop_phone" name="shop_phone" type="tel" required 
                                               class="input-field block w-full pl-10 pr-4 py-4 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none transition-all duration-300"
                                               placeholder="Enter shop phone number"
                                               value="{{ old('shop_phone') }}">
                                    </div>
                                    @error('shop_phone')
                                        <p class="text-red-600 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="address" class="text-sm font-medium text-gray-700">Shop Address</label>
                                    <div class="relative">
                                        <div class="absolute top-3 left-3 flex items-center pointer-events-none">
                                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                                        </div>
                                        <textarea id="address" name="address" rows="3" required 
                                                  class="input-field block w-full pl-10 pr-4 py-4 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none transition-all duration-300 resize-none"
                                                  placeholder="Enter your shop address">{{ old('address') }}</textarea>
                                    </div>
                                    @error('address')
                                        <p class="text-red-600 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="section-divider">

                        <!-- Security -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-lock text-red-600 text-sm"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Security</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-key text-gray-400"></i>
                                        </div>
                                        <input id="password" name="password" type="password" autocomplete="new-password" required 
                                               class="input-field block w-full pl-10 pr-4 py-4 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none transition-all duration-300"
                                               placeholder="Create a strong password">
                                    </div>
                                    @error('password')
                                        <p class="text-red-600 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="password_confirmation" class="text-sm font-medium text-gray-700">Confirm Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-key text-gray-400"></i>
                                        </div>
                                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                                               class="input-field block w-full pl-10 pr-4 py-4 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none transition-all duration-300"
                                               placeholder="Confirm your password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Terms Agreement -->
                        <div class="flex items-start space-x-3 p-4 bg-red-50 rounded-xl border border-red-100">
                            <input id="terms" name="terms" type="checkbox" required
                                   class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500 bg-white mt-1 flex-shrink-0">
                            <label for="terms" class="text-sm text-gray-700">
                                I agree to the 
                                <a href="#" class="text-red-600 hover:text-red-500 font-semibold">Terms of Service</a> 
                                and 
                                <a href="#" class="text-red-600 hover:text-red-500 font-semibold">Privacy Policy</a>
                            </label>
                        </div>
                        @error('terms')
                            <p class="text-red-600 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="btn-primary w-full py-4 px-6 rounded-xl text-white font-semibold shadow-lg transition-all duration-300 group">
                            <span class="flex items-center justify-center">
                                Create Shop Account
                                <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                            </span>
                        </button>

                        <!-- Login Link -->
                        <div class="text-center pt-4">
                            <p class="text-gray-600">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-500 font-semibold transition-colors duration-300">
                                    Sign in here
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Section - Features -->
            <div class="fade-in hidden lg:block">
                <div class="gradient-bg rounded-3xl p-8 lg:p-12 text-white shadow-2xl relative overflow-hidden sticky top-8">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-10 right-10 w-20 h-20 bg-white rounded-full"></div>
                        <div class="absolute bottom-10 left-10 w-16 h-16 bg-white rounded-full"></div>
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 bg-white rounded-full"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <h2 class="text-2xl lg:text-3xl font-bold mb-8 text-center">
                            Start Your Loan Management Journey
                        </h2>
                        
                        <div class="space-y-6 mb-8">
                            <!-- Feature 1 -->
                            <div class="feature-card rounded-2xl p-6 cursor-pointer">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-rocket text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Quick Setup</h3>
                                        <p class="text-gray-600 text-sm mt-1">Get started in minutes with our guided onboarding</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Feature 2 -->
                            <div class="feature-card rounded-2xl p-6 cursor-pointer">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-chart-line text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Smart Analytics</h3>
                                        <p class="text-gray-600 text-sm mt-1">Track performance with real-time insights</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Feature 3 -->
                            <div class="feature-card rounded-2xl p-6 cursor-pointer">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-headset text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">24/7 Support</h3>
                                        <p class="text-gray-600 text-sm mt-1">Get help whenever you need it</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-quote-left text-white/60 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-white/90 text-sm italic">
                                        "LoanTrack Pro helped us reduce loan tracking time by 80% and improved our recovery rate significantly. The setup was incredibly smooth!"
                                    </p>
                                    <p class="text-white/70 text-sm font-semibold mt-3">- Ahmed Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                            <div class="text-white">
                                <div class="text-2xl font-bold">500+</div>
                                <div class="text-xs text-red-100">Shops</div>
                            </div>
                            <div class="text-white">
                                <div class="text-2xl font-bold">$2M+</div>
                                <div class="text-xs text-red-100">Loans</div>
                            </div>
                            <div class="text-white">
                                <div class="text-2xl font-bold">98%</div>
                                <div class="text-xs text-red-100">Satisfied</div>
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

        // Textarea auto-resize
        const textarea = document.getElementById('address');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    </script>
</body>
</html>