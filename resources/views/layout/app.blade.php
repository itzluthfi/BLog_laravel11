<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title_page', 'Go Blog ^_^')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-text {
            background: linear-gradient(90deg, #4f46e5, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: linear-gradient(90deg, #4f46e5, #8b5cf6);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .active-link::after {
            width: 100%;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-base-100 text-base-content min-h-screen flex flex-col">
    @php
        $user = Auth::user();
    @endphp
    <!-- Navbar -->
    <div class="drawer">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" /> 
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-base-100 bg-opacity-90 backdrop-blur-lg shadow-md fixed top-0 z-50">
                <div class="container mx-auto px-4">
                    <div class="flex-none lg:hidden">
                        <label for="my-drawer-3" class="btn btn-square btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </label>
                    </div> 
                    <div class="flex-1">
                        <a href="/" class="text-2xl font-bold gradient-text">Go Blog ^_^</a>
                    </div>
                    <div class="flex-none hidden lg:block">
                        <ul class="menu menu-horizontal gap-2">
                            <li><a href="/" class="nav-link text-base font-medium hover:text-primary">Beranda</a></li>
                            <li><a href="{{ route('blog.index') }}" class="nav-link text-base font-medium hover:text-primary">Blog</a></li>
                            <li><a href="/about" class="nav-link text-base font-medium hover:text-primary">About</a></li>
                            <li><a href="/contact" class="nav-link text-base font-medium hover:text-primary">Contact</a></li>
                            
                            @auth
                                @if($user->role->name == 'Admin')
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-base font-medium hover:text-primary">
                                            Dashboard Admin
                                        </a>
                                    </li>
                                @elseif($user->role->name == 'User')
                                    <li>
                                        <a href="{{ route('profile.dashboard') }}" class="nav-link text-base font-medium hover:text-primary">
                                            My Profile
                                        </a>
                                    </li>
                                @endif
                            @endauth
                        </ul>
                    </div>
                    <div class="ml-4 hidden lg:block">
                        @auth
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                                <div class="w-10 rounded-full">
                                    <img src="{{ asset(e($user->profile_image)) }}" alt="{{ $user->username }}" />
                                </div>
                            </div>
                            <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                                <li class="font-medium p-2 text-center border-b border-base-200">
                                    <span>{{ $user->username }}</span>
                                    <span class="text-xs text-base-content/70">{{ $user->role->name }}</span>
                                </li>
                                <li><a href="{{ route('profile.dashboard') }}"><i class="ri-user-settings-line mr-2"></i>My Profile</a></li>
                                <li><a href="{{ route('profile.setting') }}"><i class="ri-settings-3-line mr-2"></i>Settings</a></li>
                                <li>
                                    <form action="{{route('logout')}}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                                        @csrf
                                        <button type="submit" class="text-error"><i class="ri-logout-box-r-line mr-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <main class="flex-grow pt-24 pb-16">
                <div class="container mx-auto px-4">
                    @yield('content')
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="footer footer-center p-10 bg-base-200 text-base-content rounded">
                <div class="grid grid-flow-col gap-4">
                    <a href="/" class="link link-hover">Home</a>
                    <a href="{{ route('blog.index') }}" class="link link-hover">Blog</a>
                    <a href="/about" class="link link-hover">About</a>
                    <a href="/contact" class="link link-hover">Contact</a>
                </div> 
                <div>
                    <div class="grid grid-flow-col gap-4">
                        <a class="btn btn-ghost btn-square">
                            <i class="fab fa-twitter text-xl"></i>
                        </a> 
                        <a class="btn btn-ghost btn-square">
                            <i class="fab fa-youtube text-xl"></i>
                        </a> 
                        <a class="btn btn-ghost btn-square">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a class="btn btn-ghost btn-square">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div> 
                <div>
                    <p>Copyright © {{ date('Y') }} - All rights reserved by Go Blog</p>
                </div>
            </footer>
        </div> 
        
        <!-- Mobile Drawer -->
        <div class="drawer-side z-50">
            <label for="my-drawer-3" class="drawer-overlay"></label> 
            <ul class="menu p-4 w-80 h-full bg-base-100 pt-8">
                <li class="mb-2">
                    <a href="/" class="text-lg font-medium">Beranda</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('blog.index') }}" class="text-lg font-medium">Blog</a>
                </li>
                <li class="mb-2">
                    <a href="/about" class="text-lg font-medium">About</a>
                </li>
                <li class="mb-2">
                    <a href="/contact" class="text-lg font-medium">Contact</a>
                </li>
                
                @auth
                    <li class="mb-2">
                        <a href="{{ route('profile.dashboard') }}" class="text-lg font-medium">My Profile</a>
                    </li>
                    <li class="divider my-2"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="w-full" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                            @csrf
                            <button type="submit" class="text-lg font-medium w-full text-left">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="mt-4">
                        <a href="{{ route('login') }}" class="btn btn-primary w-full">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>

    <script>
        AOS.init({
            duration: 700,
            once: true,
        });
        
        // Add active class to current page link
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPath || (currentPath.includes('/blog') && href.includes('/blog'))) {
                    link.classList.add('active-link');
                    link.classList.add('text-primary');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>