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

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#6366F1',
                        accent: '#C4B5FD',
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #6366F1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #4F46E5; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }
    </style>
</head>
@php
    $user = Auth::user();
@endphp
<body class="bg-base-200 min-h-screen">
    <div class="drawer lg:drawer-open">
        <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />
        
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-base-100 shadow-md sticky top-0 z-30">
                <div class="flex-none lg:hidden">
                    <label for="drawer-toggle" class="btn btn-square btn-ghost drawer-button">
                        <i class="ri-menu-line text-xl"></i>
                    </label>
                </div>
                
                <div class="flex-1 px-2 mx-2">
                    <div class="flex items-center lg:hidden">
                        <i class="ri-quill-pen-line text-2xl text-primary mr-2"></i>
                        <span class="text-xl font-bold">Go Blogs^_^</span>
                    </div>
                </div>
                
                <div class="flex-none gap-2">
                    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">
                        <i class="ri-home-line mr-1"></i>Beranda
                    </a>
                    
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img src="{{ asset(e($user->profile_image)) }}" alt="Profile" />
                            </div>
                        </div>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                            <li class="font-medium p-2 text-center border-b border-base-200">
                                <span>{{ $user->username }}</span>
                                <span class="text-xs text-base-content/70">{{ $user->role->name }}</span>
                            </li>
                            <li><a href="{{ route('admin.setting') }}"><i class="ri-user-settings-line mr-2"></i>Profile</a></li>
                            <li><a href="{{ route('admin.setting') }}"><i class="ri-settings-3-line mr-2"></i>Settings</a></li>
                            <li>
                                <form action="{{route('logout')}}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                                    @csrf
                                    <button type="submit" class="text-error"><i class="ri-logout-box-r-line mr-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-6 overflow-y-auto">
                <!-- Breadcrumbs -->
                <div class="text-sm breadcrumbs mb-4">
                    <ul>
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li>@yield('breadcrumb', 'Home')</li>
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
                <div class="bg-base-100 rounded-box shadow-lg p-4 md:p-6">
                    @yield('content')
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="footer footer-center p-4 bg-base-100 text-base-content border-t">
                <div>
                    <p>Copyright © 2023 - Go Blogs Admin Panel</p>
                </div>
            </footer>
        </div>
        
        <!-- Sidebar -->
        <div class="drawer-side z-40">
            <label for="drawer-toggle" class="drawer-overlay"></label>
            <aside class="bg-base-100 w-72 h-full">
                <!-- Logo and Brand -->
                <div class="px-6 py-4 bg-primary text-primary-content">
                    <div class="flex items-center space-x-3">
                        <i class="ri-quill-pen-line text-3xl"></i>
                        <div>
                            <h1 class="text-xl font-bold">Go Blogs^_^</h1>
                            <p class="text-xs opacity-80">Admin Dashboard</p>
                        </div>
                    </div>
                </div>
                
                <!-- User Profile -->
                <div class="p-4 border-b border-base-200">
                    <div class="flex items-center space-x-3">
                        <div class="avatar online">
                            <div class="w-12 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="{{ asset(e($user->profile_image)) }}" alt="Admin Avatar">
                            </div>
                        </div>
                        <div>
                            <h2 class="font-bold">{{ $user->username }}</h2>
                            <p class="text-xs opacity-70">{{ $user->role->name }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <ul class="menu p-4 text-base-content">
                    <li class="menu-title">
                        <span>Main Navigation</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="ri-dashboard-line text-lg"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    <li class="menu-title mt-4">
                        <span>Content Management</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.blogs.list') }}" class="{{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                            <i class="ri-article-line text-lg"></i>
                            Manage Blogs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="ri-price-tag-3-line text-lg"></i>
                            Manage Categories
                        </a>
                    </li>
                    
                    <li class="menu-title mt-4">
                        <span>User Management</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                            <i class="ri-user-line text-lg"></i>
                            Manage Users
                        </a>
                    </li>
                    
                    <li class="menu-title mt-4">
                        <span>System</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.setting') }}" class="{{ request()->routeIs('admin.setting') ? 'active' : '' }}">
                            <i class="ri-settings-3-line text-lg"></i>
                            Settings
                        </a>
                    </li>
                    <li>
                        <form action="{{route('logout')}}" method="POST" class="w-full" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                            @csrf
                            <button type="submit" class="flex items-center text-error w-full">
                                <i class="ri-logout-box-r-line text-lg"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
                
              
            </aside>
        </div>
    </div>

    @yield('scripts')
</body>
</html>