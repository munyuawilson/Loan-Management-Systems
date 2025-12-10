<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LoanTrack Pro')</title>
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
            background-color: #f8fafc;
        }
        
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .content-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-item {
            transition: all 0.2s ease;
            position: relative;
        }
        
        .nav-item:hover {
            background: rgba(220, 38, 38, 0.05);
            transform: translateX(4px);
        }
        
        .nav-item.active {
            background: rgba(220, 38, 38, 0.1);
            border-right: 3px solid #dc2626;
        }
        
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 2px;
            background: #dc2626;
        }
        
        .notification-dot {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px);
        }
        
        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.2s ease;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden content-transition" id="mainContent">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <!-- Left Section - Menu Button and Breadcrumb -->
                    <div class="flex items-center space-x-4">
                        <!-- Mobile menu button -->
                        <button id="mobileMenuButton" class="lg:hidden text-gray-600 hover:text-red-600 transition-colors">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <!-- Breadcrumb -->
                        <nav class="hidden sm:flex" aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-2">
                                <li>
                                    <div class="flex items-center">
                                        <a href="{{ route('shop.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-red-600 transition-colors">
                                            Dashboard
                                        </a>
                                    </div>
                                </li>
                                @hasSection('breadcrumb')
                                    <li>
                                        <div class="flex items-center">
                                            <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                                            @yield('breadcrumb')
                                        </div>
                                    </li>
                                @endif
                            </ol>
                        </nav>
                    </div>
                    
                    <!-- Right Section - User Menu & Notifications -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-red-600 transition-colors">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full notification-dot"></span>
                            </button>
                            
                            <!-- Notification Dropdown -->
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50 dropdown-enter"
                                 x-transition:enter="dropdown-enter"
                                 x-transition:enter-start="dropdown-enter">
                                <div class="p-4 border-b border-gray-200">
                                    <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <!-- Notification items would go here -->
                                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <p class="text-sm text-gray-700">New payment received from John Doe</p>
                                        <p class="text-xs text-gray-500 mt-1">2 minutes ago</p>
                                    </div>
                                    <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <p class="text-sm text-gray-700">Loan #1234 has been cleared</p>
                                        <p class="text-xs text-gray-500 mt-1">1 hour ago</p>
                                    </div>
                                </div>
                                <div class="p-4 border-t border-gray-200">
                                    <a href="{{ route('notifications.index') }}" class="text-red-600 hover:text-red-700 text-sm font-medium transition-colors">
                                        View all notifications
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="w-8 h-8 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">Shop Owner</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </button>
                            
                            <!-- User Dropdown -->
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50 dropdown-enter"
                                 x-transition:enter="dropdown-enter"
                                 x-transition:enter-start="dropdown-enter">
                                <div class="py-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-user-circle mr-3 text-gray-400"></i>
                                        Profile
                                    </a>
                                    <a href="{{ route('shop.settings') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-cog mr-3 text-gray-400"></i>
                                        Settings
                                    </a>
                                    <div class="border-t border-gray-200 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                            <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                <!-- Page Header -->
                <div class="bg-white shadow-sm border-b border-gray-200">
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                                <p class="text-gray-600 mt-1">@yield('page-description', 'Welcome to your loan management dashboard')</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                @yield('page-actions')
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mx-6 mt-6">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mx-6 mt-6">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Main Content Area -->
                <div class="p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <script>
        // Mobile sidebar toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        if (mobileMenuButton && sidebar) {
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                sidebar.classList.toggle('lg:translate-x-0');
            });
        }

        // Close mobile sidebar when clicking on a link
        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('lg:translate-x-0');
                }
            });
        });

        // Active navigation item highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navItems = document.querySelectorAll('.nav-item a');
            
            navItems.forEach(item => {
                if (item.getAttribute('href') === currentPath) {
                    item.parentElement.classList.add('active');
                }
            });
        });

        // Auto-hide flash messages after 5 seconds (FIXED)
document.addEventListener('DOMContentLoaded', function() {
    // Only target the specific flash message containers
    const flashContainers = document.querySelectorAll('.mx-6.mt-6 [class*="bg-"]');
    
    flashContainers.forEach(container => {
        // Only hide if it's a flash message (has check or exclamation icon)
        const hasIcon = container.querySelector('.fa-check-circle, .fa-exclamation-circle');
        const isInFlashLocation = container.closest('.mx-6.mt-6');
        
        if (hasIcon && isInFlashLocation) {
            setTimeout(() => {
                container.style.transition = 'all 0.3s ease';
                container.style.opacity = '0';
                container.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    if (container.parentNode) {
                        container.remove();
                    }
                }, 300);
            }, 5000);
        }
    });
});
    </script>
    
    @stack('scripts')
</body>
</html>