<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSpace - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#6366F1',
                        accent: '#C4B5FD',
                        dark: '#1E293B',
                        light: '#F8FAFC'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'glow': '0 0 15px rgba(99, 102, 241, 0.5)'
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #6366F1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #4F46E5; }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .animate-fadeIn { animation: fadeIn 0.3s ease-out forwards; }
        .animate-slideIn { animation: slideInLeft 0.4s ease-out forwards; }
        .animate-pulse { animation: pulse 2s infinite; }
        
        /* Menu hover effects */
        .menu-item {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .menu-item::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #4F46E5;
            transition: width 0.3s ease;
        }
        
        .menu-item:hover::after {
            width: 100%;
        }
        
        .menu-item.active {
            background-color: rgba(99, 102, 241, 0.1);
            border-radius: 0.5rem;
        }
        
        .menu-item.active::after {
            width: 100%;
        }
        
        /* Card hover effects */
        .hover-card {
            transition: all 0.3s ease;
        }
        
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Gradient backgrounds */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
        }
        
        .bg-gradient-secondary {
            background: linear-gradient(135deg, #6366F1 0%, #C4B5FD 100%);
        }
        
        /* Glass effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
@php
    $user = Auth::user();
@endphp
<body class="bg-gray-50 min-h-screen" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">
    <div class="drawer lg:drawer-open">
        <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />
        
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-white dark:bg-dark shadow-soft sticky top-0 z-30 transition-all duration-300">
                <div class="flex-none lg:hidden">
                    <label for="drawer-toggle" class="btn btn-square btn-ghost drawer-button">
                        <i class="ri-menu-line text-xl"></i>
                    </label>
                </div>
                
                <div class="flex-1 px-2 mx-2">
                    <div class="flex items-center lg:hidden">
                        <i class="ri-quill-pen-line text-2xl text-primary mr-2"></i>
                        <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">Go Blogs^_^</span>
                    </div>
                </div>
                
                <div class="flex-none gap-3">
                    <!-- Notifications -->
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                            <div class="indicator">
                                <i class="ri-notification-3-line text-lg"></i>
                                <span class="badge badge-sm badge-primary indicator-item">3</span>
                            </div>
                        </div>
                        <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-80 bg-white shadow-xl rounded-box">
                            <div class="card-body">
                                <h3 class="font-bold text-lg border-b pb-2">Notifications</h3>
                                <div class="space-y-3 mt-2 max-h-64 overflow-y-auto">
                                    <div class="flex items-start gap-3 p-2 hover:bg-base-200 rounded-lg transition-all">
                                        <div class="avatar">
                                            <div class="w-10 rounded-full">
                                                <img src="https://picsum.photos/id/237/200/200" alt="User" />
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-medium">New comment on your post</p>
                                            <p class="text-xs text-gray-500">2 minutes ago</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3 p-2 hover:bg-base-200 rounded-lg transition-all">
                                        <div class="avatar">
                                            <div class="w-10 rounded-full bg-primary flex items-center justify-center text-white">
                                                <i class="ri-user-add-line"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-medium">New user registered</p>
                                            <p class="text-xs text-gray-500">1 hour ago</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3 p-2 hover:bg-base-200 rounded-lg transition-all">
                                        <div class="avatar">
                                            <div class="w-10 rounded-full bg-success flex items-center justify-center text-white">
                                                <i class="ri-article-line"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="font-medium">Your post was approved</p>
                                            <p class="text-xs text-gray-500">3 hours ago</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-actions justify-end mt-2 pt-2 border-t">
                                    <button class="btn btn-sm btn-primary btn-block">View All Notifications</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Theme Toggle -->
                    <button class="btn btn-ghost btn-circle" @click="darkMode = !darkMode">
                        <i class="ri-sun-line text-lg" x-show="!darkMode"></i>
                        <i class="ri-moon-line text-lg" x-show="darkMode" style="display: none;"></i>
                    </button>
                    
                    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">
                        <i class="ri-home-line mr-1"></i>Beranda
                    </a>
                    
                    <!-- User Menu -->
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar online">
                            <div class="w-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="{{ asset(e($user->profile_image)) }}" alt="Profile" />
                            </div>
                        </div>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow-lg menu menu-sm dropdown-content bg-white rounded-box w-52">
                            <li class="font-medium p-3 text-center border-b border-base-200">
                                <span class="block font-bold">{{ $user->username }}</span>
                                <span class="text-xs text-base-content/70 bg-primary/10 px-2 py-1 rounded-full">{{ $user->role->name }}</span>
                            </li>
                            <li class="hover:bg-base-200 rounded-lg mt-2">
                                <a href="{{ route('admin.setting') }}" class="flex py-2">
                                    <i class="ri-user-settings-line mr-2"></i>Profile
                                </a>
                            </li>
                            <li class="hover:bg-base-200 rounded-lg">
                                <a href="{{ route('admin.setting') }}" class="flex py-2">
                                    <i class="ri-settings-3-line mr-2"></i>Settings
                                </a>
                            </li>
                            <li class="hover:bg-red-100 rounded-lg mt-2">
                                <form action="{{route('logout')}}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                                    @csrf
                                    <button type="submit" class="flex py-2 text-error w-full">
                                        <i class="ri-logout-box-r-line mr-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-6 overflow-y-auto bg-gray-50 dark:bg-gray-800 transition-all duration-300">
                <!-- Breadcrumbs -->
                <div class="text-sm breadcrumbs mb-4 p-2 bg-white dark:bg-gray-700 rounded-lg shadow-sm animate-fadeIn">
                    <ul>
                        <li><a href="{{ route('admin.dashboard') }}" class="flex items-center"><i class="ri-dashboard-line mr-1"></i>Dashboard</a></li>
                        <li class="flex items-center"><i class="ri-arrow-right-s-line mx-1"></i>@yield('breadcrumb', 'Home')</li>
                    </ul>
                </div>
                
                <!-- Notifications -->
                @if (session('success'))
                <div class="alert alert-success shadow-lg mb-6 animate-fadeIn">
                    <div>
                        <i class="ri-checkbox-circle-line text-xl"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button class="btn btn-sm btn-circle btn-ghost" onclick="this.parentElement.remove();">✕</button>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-error shadow-lg mb-6 animate-fadeIn">
                    <div>
                        <i class="ri-error-warning-line text-xl"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button class="btn btn-sm btn-circle btn-ghost" onclick="this.parentElement.remove();">✕</button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-warning shadow-lg mb-6 animate-fadeIn">
                    <div>
                        <i class="ri-alert-line text-xl"></i>
                        <div>
                            <h3 class="font-bold">Terjadi Kesalahan:</h3>
                            <ul class="mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-circle btn-ghost" onclick="this.parentElement.remove();">✕</button>
                </div>
                @endif
                
                <!-- Page Content -->
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-soft p-4 md:p-6 transition-all duration-300">
                    @yield('content')
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="footer footer-center p-4 bg-white dark:bg-gray-700 text-base-content border-t transition-all duration-300">
                <div class="flex flex-col md:flex-row items-center justify-between w-full">
                    <p class="text-sm">Copyright © 2023 - Go Blogs Admin Panel</p>
                    <div class="flex space-x-2 mt-2 md:mt-0">
                        <a href="#" class="btn btn-ghost btn-circle btn-sm">
                            <i class="ri-github-fill text-lg"></i>
                        </a>
                        <a href="#" class="btn btn-ghost btn-circle btn-sm">
                            <i class="ri-twitter-fill text-lg"></i>
                        </a>
                        <a href="#" class="btn btn-ghost btn-circle btn-sm">
                            <i class="ri-instagram-fill text-lg"></i>
                        </a>
                    </div>
                </div>
            </footer>
        </div>
        
        <!-- Quick Action Button -->
        <div class="fixed bottom-6 right-6 z-50">
            <div class="dropdown dropdown-top dropdown-end">
                <div tabindex="0" role="button" class="btn btn-circle btn-lg btn-primary shadow-lg animate-pulse">
                    <i class="ri-add-line text-2xl"></i>
                </div>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow-lg bg-white rounded-box w-52 mt-4">
                    <li><a href="{{ route('admin.blogs.create') }}" class="flex items-center"><i class="ri-article-line mr-2"></i> New Blog Post</a></li>
                    <li><a href="{{ route('admin.categories.create') }}" class="flex items-center"><i class="ri-price-tag-3-line mr-2"></i> New Category</a></li>
                    <li><a href="{{ route('admin.users.add') }}" class="flex items-center"><i class="ri-user-add-line mr-2"></i> Add User</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="drawer-side z-40">
            <label for="drawer-toggle" class="drawer-overlay"></label>
            <aside class="bg-white dark:bg-gray-800 w-80 h-full transition-all duration-300 flex flex-col relative">
                <!-- Close Button for Mobile -->
                <label for="drawer-toggle" class="btn btn-sm btn-circle absolute right-2 top-2 lg:hidden z-50 bg-white text-gray-700 hover:bg-gray-200">
                    <i class="ri-close-line text-lg"></i>
                </label>
                
                <!-- Logo and Brand -->
                <div class="px-6 py-6 bg-gradient-primary text-white">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                            <i class="ri-quill-pen-line text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">Go Blogs^_^</h1>
                            <p class="text-xs opacity-80">Admin Dashboard</p>
                        </div>
                    </div>
                </div>
                
                <!-- User Profile -->
                <div class="p-4 border-b border-base-200 bg-base-100 dark:bg-gray-700 transition-all duration-300">
                    <div class="flex items-center space-x-3">
                        <div class="avatar online">
                            <div class="w-14 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="{{ asset(e($user->profile_image)) }}" alt="Admin Avatar">
                            </div>
                        </div>
                        <div>
                            <h2 class="font-bold text-lg">{{ $user->username }}</h2>
                            <div class="flex items-center mt-1">
                                <span class="text-xs bg-primary/10 text-primary px-2 py-0.5 rounded-full">{{ $user->role->name }}</span>
                                <span class="text-xs text-success ml-2 flex items-center">
                                    <i class="ri-checkbox-circle-fill mr-1"></i>Active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <div class="overflow-y-auto flex-grow">
                   <ul class="menu p-4 text-base-content">
                        <li class="menu-title">
                            <span class="font-semibold uppercase text-xs tracking-wider text-gray-500 dark:text-gray-400">Main Navigation</span>
                        </li>
                        <li class="mt-2">
                            <a href="{{ route('admin.dashboard') }}" class="menu-item flex items-center p-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="ri-dashboard-line text-lg mr-3"></i>
                                Dashboard
                                @if(request()->routeIs('admin.dashboard'))
                                <span class="ml-auto bg-primary text-white text-xs px-2 py-1 rounded-full">Current</span>
                                @endif
                            </a>
                        </li>
                        
                        <li class="menu-title mt-6">
                            <span class="font-semibold uppercase text-xs tracking-wider text-gray-500 dark:text-gray-400">Content Management</span>
                        </li>
                        <li class="mt-2">
                            <a href="{{ route('admin.blogs.list') }}" class="menu-item flex items-center p-3 {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                                <i class="ri-article-line text-lg mr-3"></i>
                                Manage Blogs
                                <span class="ml-auto bg-info/20 text-info text-xs px-2 py-1 rounded-full">24 New</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="menu-item flex items-center p-3 {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <i class="ri-price-tag-3-line text-lg mr-3"></i>
                                Manage Categories
                            </a>
                        </li>
                        <li>
                            <a href="#" class="menu-item flex items-center p-3">
                                <i class="ri-image-line text-lg mr-3"></i>
                                Media Library
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.comments.index') }}" class="menu-item flex items-center p-3">
                                <i class="ri-chat-3-line text-lg mr-3"></i>
                                Comments
                                <span class="ml-auto bg-error/20 text-error text-xs px-2 py-1 rounded-full">12</span>
                            </a>
                        </li>
                        
                        <li class="menu-title mt-6">
                            <span class="font-semibold uppercase text-xs tracking<span class="font-semibold uppercase text-xs tracking-wider text-gray-500 dark:text-gray-400">User Management</span>
                        </li>
                        <li class="mt-2">
                            <a href="{{ route('admin.users') }}" class="menu-item flex items-center p-3 {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                <i class="ri-user-line text-lg mr-3"></i>
                                Manage Users
                            </a>
                        </li>
                        {{-- <li>
                            <a href="#" class="menu-item flex items-center p-3">
                                <i class="ri-shield-user-line text-lg mr-3"></i>
                                Roles & Permissions
                            </a>
                        </li>
                        
                        <li class="menu-title mt-6">
                            <span class="font-semibold uppercase text-xs tracking-wider text-gray-500 dark:text-gray-400">Analytics</span>
                        </li>
                        <li class="mt-2">
                            <a href="#" class="menu-item flex items-center p-3">
                                <i class="ri-line-chart-line text-lg mr-3"></i>
                                Traffic Overview
                            </a>
                        </li>
                        <li>
                            <a href="#" class="menu-item flex items-center p-3">
                                <i class="ri-user-heart-line text-lg mr-3"></i>
                                User Engagement
                            </a>
                        </li>
                        <li>
                            <a href="#" class="menu-item flex items-center p-3">
                                <i class="ri-file-chart-line text-lg mr-3"></i>
                                Content Performance
                            </a>
                        </li> --}}
                        
                        <li class="menu-title mt-6">
                            <span class="font-semibold uppercase text-xs tracking-wider text-gray-500 dark:text-gray-400">System</span>
                        </li>
                        <li class="mt-2">
                            <a href="{{ route('admin.setting') }}" class="menu-item flex items-center p-3 {{ request()->routeIs('admin.setting') ? 'active' : '' }}">
                                <i class="ri-settings-3-line text-lg mr-3"></i>
                                Setting 
                            </a>
                        </li>
                        <li>
                            <a href="#" class="menu-item flex items-center p-3">
                                <i class="ri-database-2-line text-lg mr-3"></i>
                                System Status
                                <span class="ml-auto bg-success/20 text-success text-xs px-2 py-1 rounded-full">Healthy</span>
                            </a>
                        </li>
                        <li class="mt-4">
                            <form action="{{route('logout')}}" method="POST" class="w-full" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                                @csrf
                                <button type="submit" class="flex items-center text-error w-full p-3 hover:bg-red-50 rounded-lg transition-all">
                                    <i class="ri-logout-box-r-line text-lg mr-3"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>

    <script>
        // Close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on page load
            const animateElements = document.querySelectorAll('.animate-fadeIn');
            animateElements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100 * index);
            });
            
            // Auto-close alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    alert.style.transition = 'opacity 0.5s, transform 0.5s';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
            
            // Add active class to current menu item
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                const link = item.getAttribute('href');
                if (link && currentPath.includes(link)) {
                    item.classList.add('active');
                }
            });
        });
        
        // Responsive sidebar
        const drawerToggle = document.getElementById('drawer-toggle');
        const mediaQuery = window.matchMedia('(min-width: 1024px)');
        const drawerOverlay = document.querySelector('.drawer-overlay');
        
        function handleScreenChange(e) {
            if (e.matches) {
                drawerToggle.checked = false;
            }
        }
        
        mediaQuery.addEventListener('change', handleScreenChange);
        
        // Close sidebar when clicking outside on mobile
        drawerOverlay.addEventListener('click', function() {
            drawerToggle.checked = false;
        });
        
        // Close sidebar when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && drawerToggle.checked) {
                drawerToggle.checked = false;
            }
        });
        
        // Close sidebar when clicking on a menu item on mobile
        const mobileMenuItems = document.querySelectorAll('.drawer-side .menu-item');
        mobileMenuItems.forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth < 1024) {
                    drawerToggle.checked = false;
                }
            });
        });
    </script>
    @stack('scripts')
</body>

    <script>
        // Close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on page load
            const animateElements = document.querySelectorAll('.animate-fadeIn');
            animateElements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 100 * index);
            });
            
            // Auto-close alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    alert.style.transition = 'opacity 0.5s, transform 0.5s';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
            
            // Add active class to current menu item
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                const link = item.getAttribute('href');
                if (link && currentPath.includes(link)) {
                    item.classList.add('active');
                }
            });
        });
        
        // Responsive sidebar
        const drawerToggle = document.getElementById('drawer-toggle');
        const mediaQuery = window.matchMedia('(min-width: 1024px)');
        const drawerOverlay = document.querySelector('.drawer-overlay');
        
        function handleScreenChange(e) {
            if (e.matches) {
                drawerToggle.checked = false;
            }
        }
        
        mediaQuery.addEventListener('change', handleScreenChange);
        
        // Close sidebar when clicking outside on mobile
        drawerOverlay.addEventListener('click', function() {
            drawerToggle.checked = false;
        });
        
        // Close sidebar when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && drawerToggle.checked) {
                drawerToggle.checked = false;
            }
        });
        
        // Close sidebar when clicking on a menu item on mobile
        const mobileMenuItems = document.querySelectorAll('.drawer-side .menu-item');
        mobileMenuItems.forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth < 1024) {
                    drawerToggle.checked = false;
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>