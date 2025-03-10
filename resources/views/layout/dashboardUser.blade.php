<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Go Blogs ^_^ - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
 
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        
        /* Smooth transitions */
        .sidebar-transition {
            transition: all 0.3s ease;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        'primary-focus': '#4f46e5',
                    }
                }
            }
        }
    </script>
    @php
        $user = Auth::user();
    @endphp
</head>
<body class="bg-base-200 min-h-screen">
    <div class="drawer lg:drawer-open">
        <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />
        
        <!-- Sidebar - Left Side -->
        <div class="drawer-side z-20">
            <label for="drawer-toggle" aria-label="close sidebar" class="drawer-overlay"></label>
            <aside class="w-80 min-h-screen bg-base-100 shadow-lg">
                <!-- Logo and Brand -->
                <div class="px-6 py-4 border-b border-base-200">
                    <div class="flex items-center gap-2">
                        <i class="ri-book-2-line text-2xl text-primary"></i>
                        <span class="text-xl font-bold">Go Blogs ^_^</span>
                    </div>
                </div>
                
                <!-- User Profile Card -->
                <div class="p-4">
                    <div class="flex flex-col items-center p-4 bg-base-200 rounded-box">
                        <div class="avatar online mb-3">
                            <div class="w-20 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <img src="{{ asset($user->profile_image) }}" alt="Avatar-{{$user->username}}" />
                            </div>
                        </div>
                        <div class="text-center">
                            <h2 class="text-lg font-bold">{{$user->username}}</h2>
                            <p class="text-sm opacity-70">{{$user->email}}</p>
                            <div class="badge badge-primary mt-2">Blogger</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="px-4 py-2">
                    <ul class="menu bg-base-100 rounded-box w-full">
                        <li class="menu-title"><span>Menu Utama</span></li>
                        <li>
                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <i class="ri-home-line"></i>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.dashboard') }}" class="{{ request()->routeIs('profile.dashboard') ? 'active' : '' }}">
                                <i class="ri-user-line"></i>
                                <span>Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.artikelSaya') }}" class="{{ request()->routeIs('profile.artikelSaya') ? 'active' : '' }}">
                                <i class="ri-article-line"></i>
                                <span>Artikel Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.artikelDisukai') }}" class="{{ request()->routeIs('profile.artikelDisukai') ? 'active' : '' }}">
                                <i class="ri-heart-line"></i>
                                <span>Artikel Disukai</span>
                            </a>
                        </li>
                        
                        <li class="menu-title mt-4"><span>Pengaturan</span></li>
                        <li>
                            <a href="{{ route('profile.setting') }}" class="{{ request()->routeIs('profile.setting') ? 'active' : '' }}">
                                <i class="ri-settings-3-line"></i>
                                <span>Pengaturan Akun</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Quick Actions -->
                <div class="px-4 py-4 mt-2">
                    <a href="{{ route('profile.blog.create') }}" class="btn btn-primary w-full gap-2">
                        <i class="ri-pen-nib-line"></i>Tulis Artikel
                    </a>
                </div>

                <!-- Logout Button -->
                <div class="px-4 py-2 mt-auto border-t border-base-200">
                    <form action="{{ route('logout') }}" method="POST" class="w-full"
                        onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-error w-full gap-2">
                            <i class="ri-logout-box-r-line"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </aside>
        </div>
        
        <!-- Main Content -->
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-base-100 shadow-md z-10">
                <div class="navbar-start">
                    <label for="drawer-toggle" class="btn btn-ghost drawer-button lg:hidden">
                        <i class="ri-menu-line text-xl"></i>
                    </label>
                </div>
                
                <!-- Breadcrumb -->
                {{-- <div class="navbar-center">
                    <div class="breadcrumbs text-sm">
                        <ul>
                            <li><a href="{{ route('home') }}">Beranda</a></li>
                            @yield('breadcrumb')
                        </ul>
                    </div>
                </div> --}}
                
                <div class="navbar-end mr-10">
                    <!-- Search -->
                    <div class="form-control mr-2 hidden md:block">
                        <div class="input-group">
                            <input type="text" placeholder="Cari artikel..." class="input input-sm input-bordered" />
                            <button class="btn btn-sm btn-square">
                                <i class="ri-search-line"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Notifications -->
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                            <div class="indicator">
                                <i class="ri-notification-3-line text-xl"></i>
                                <span class="badge badge-sm badge-primary indicator-item">3</span>
                            </div>
                        </div>
                        <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-80 bg-base-100 shadow">
                            <div class="card-body">
                                <h3 class="font-bold text-lg">Notifikasi (3)</h3>
                                <div class="divider my-0"></div>
                                <ul class="menu bg-base-100">
                                    <li>
                                        <a class="flex items-start py-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-primary text-white rounded-full w-8">
                                                    <span>JD</span>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-medium">John Doe menyukai artikel Anda</p>
                                                <p class="text-xs opacity-60">2 menit yang lalu</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="flex items-start py-3">
                                            <div class="avatar placeholder">
                                                <div class="bg-secondary text-white rounded-full w-8">
                                                    <span>AS</span>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-medium">Anna Smith mengomentari artikel Anda</p>
                                                <p class="text-xs opacity-60">1 jam yang lalu</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="flex items-start py-3">
                                            <div class="avatar">
                                                <div class="w-8 rounded-full">
                                                    <img src="https://www.tailwindai.dev/placeholder.svg" />
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-medium">Artikel Anda telah dipublikasikan</p>
                                                <p class="text-xs opacity-60">3 jam yang lalu</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="card-actions">
                                    <button class="btn btn-primary btn-sm btn-block">Lihat Semua</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="dropdown dropdown-end ml-2">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img src="{{ asset($user->profile_image) }}" alt="Avatar-{{$user->username}}" />
                            </div>
                        </div>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                            <li><a href="{{ route('profile.dashboard') }}"><i class="ri-user-line mr-2"></i>Profil Saya</a></li>
                            <li><a href="{{ route('profile.setting') }}"><i class="ri-settings-3-line mr-2"></i>Pengaturan</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="w-full"
                                    onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                                    @csrf
                                    <button type="submit" class="w-full text-left text-error"><i class="ri-logout-box-r-line mr-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <main class="p-4 md:p-6 lg:p-8">
                 <!-- Breadcrumbs -->
                 <div class="text-sm breadcrumbs mb-4">
                    <ul>
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li>@yield('breadcrumb', 'Home')</li>
                    </ul>
                </div>

                <!-- Notifications -->
                @if (session('success'))
                <div class="alert alert-success shadow-lg mb-6">
                    <div>
                        <i class="ri-checkbox-circle-line text-xl"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button class="btn btn-sm btn-circle btn-ghost" onclick="this.parentElement.remove();">✕</button>
                </div>
                @endif
        
                @if (session('error'))
                <div class="alert alert-error shadow-lg mb-6">
                    <div>
                        <i class="ri-error-warning-line text-xl"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button class="btn btn-sm btn-circle btn-ghost" onclick="this.parentElement.remove();">✕</button>
                </div>
                @endif
        
                @if ($errors->any())
                <div class="alert alert-warning shadow-lg mb-6">
                    <div>
                        <i class="ri-alert-line text-xl"></i>
                        <div>
                            <h3 class="font-bold">Terjadi Kesalahan:</h3>
                            <ul class="mt-2 list-disc pl-5">
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
                <div class="bg-base-100 rounded-box shadow-sm p-6">
                    @yield('content')
                </div>
                
                <!-- Footer -->
                <footer class="footer footer-center p-4 bg-base-100 text-base-content rounded-box mt-8">
                    <div>
                        <p>Copyright © {{ date('Y') }} - Go Blogs ^_^ - All rights reserved</p>
                    </div>
                </footer>
            </main>
        </div>
    </div>

    @yield('scripts')
    
    <script>
        // Close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 1s';
                    setTimeout(() => alert.remove(), 1000);
                });
            }, 5000);
        });
    </script>
</body>
</html>