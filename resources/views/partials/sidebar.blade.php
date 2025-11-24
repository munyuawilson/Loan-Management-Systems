<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-white shadow-lg border-r border-gray-200 sidebar-transition transform -translate-x-full lg:translate-x-0 lg:static fixed inset-y-0 left-0 z-40">
    <!-- Logo Section -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center shadow-lg">
                <i class="fas fa-chart-line text-white text-lg"></i>
            </div>
            <div>
                <span class="text-xl font-bold text-gray-900">LoanTrack</span>
                <span class="text-red-600 font-semibold">Pro</span>
            </div>
        </div>
        
        <!-- Close button for mobile -->
        <button class="lg:hidden text-gray-600 hover:text-red-600 transition-colors" id="closeSidebar">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    
    <!-- Shop Info -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-store text-red-600"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">
                    {{ Auth::user()->shop->shop_name ?? 'Setup Your Shop' }}
                </p>
                <p class="text-xs text-gray-500 truncate">
                    {{ Auth::user()->name }}
                </p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <div class="nav-item {{ request()->routeIs('shop.dashboard') ? 'active' : '' }} rounded-lg">
            <a href="{{ route('shop.dashboard') }}" class="flex items-center px-3 py-3 text-gray-700 hover:text-red-600 transition-colors">
                <i class="fas fa-home mr-3 text-gray-400 w-5 text-center"></i>
                <span class="font-medium">Dashboard</span>
            </a>
        </div>
        
        <!-- Customers -->
        <div class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }} rounded-lg">
            <a href="{{ route('customers.index') }}" class="flex items-center px-3 py-3 text-gray-700 hover:text-red-600 transition-colors">
                <i class="fas fa-users mr-3 text-gray-400 w-5 text-center"></i>
                <span class="font-medium">Customers</span>
            </a>
        </div>
        
        <!-- Loans -->
        <div class="nav-item {{ request()->routeIs('loans.*') ? 'active' : '' }} rounded-lg">
            <a href="{{ route('loans.index') }}" class="flex items-center px-3 py-3 text-gray-700 hover:text-red-600 transition-colors">
                <i class="fas fa-hand-holding-usd mr-3 text-gray-400 w-5 text-center"></i>
                <span class="font-medium">Loans</span>
                <span class="ml-auto bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-semibold">
                    @php
                        $runningLoans = Auth::user()->shop ? Auth::user()->shop->loans()->where('status', 'running')->count() : 0;
                        echo $runningLoans;
                    @endphp
                </span>
            </a>
        </div>
        
        <!-- Payments -->
        <div class="nav-item {{ request()->routeIs('payments.*') ? 'active' : '' }} rounded-lg">
            <a href="{{ route('payments.index') }}" class="flex items-center px-3 py-3 text-gray-700 hover:text-red-600 transition-colors">
                <i class="fas fa-money-bill-wave mr-3 text-gray-400 w-5 text-center"></i>
                <span class="font-medium">Payments</span>
            </a>
        </div>
        
        <!-- Reports -->
        <div class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }} rounded-lg">
            <a href="{{ route('reports.index') }}" class="flex items-center px-3 py-3 text-gray-700 hover:text-red-600 transition-colors">
                <i class="fas fa-chart-bar mr-3 text-gray-400 w-5 text-center"></i>
                <span class="font-medium">Reports</span>
            </a>
        </div>
        
        <!-- Divider -->
        <div class="border-t border-gray-200 my-4"></div>
        
        <!-- Settings -->
        <div class="nav-item {{ request()->routeIs('shop.settings') ? 'active' : '' }} rounded-lg">
            <a href="{{ route('shop.settings') }}" class="flex items-center px-3 py-3 text-gray-700 hover:text-red-600 transition-colors">
                <i class="fas fa-cog mr-3 text-gray-400 w-5 text-center"></i>
                <span class="font-medium">Settings</span>
            </a>
        </div>
        
        <!-- Help & Support -->
        <div class="nav-item rounded-lg">
            <a href="#" class="flex items-center px-3 py-3 text-gray-700 hover:text-red-600 transition-colors">
                <i class="fas fa-question-circle mr-3 text-gray-400 w-5 text-center"></i>
                <span class="font-medium">Help & Support</span>
            </a>
        </div>
    </nav>
    
    <!-- Quick Stats Footer -->
    <div class="border-t border-gray-200 p-4 bg-gray-50">
        <div class="space-y-3">
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600">Active Loans</span>
                <span class="font-semibold text-red-600">
                    @php
                        $activeLoans = Auth::user()->shop ? Auth::user()->shop->loans()->where('status', 'running')->count() : 0;
                        echo $activeLoans;
                    @endphp
                </span>
            </div>
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600">Total Balance</span>
                <span class="font-semibold text-green-600">
                    $@php
                        $totalBalance = Auth::user()->shop ? number_format(Auth::user()->shop->loans()->sum('balance'), 2) : '0.00';
                        echo $totalBalance;
                    @endphp
                </span>
            </div>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden" style="display: none;"></div>