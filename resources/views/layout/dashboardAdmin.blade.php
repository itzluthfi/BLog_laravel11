<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogSpace - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <i class="ri-admin-line text-2xl text-indigo-600 mr-2"></i>
                <span class="text-2xl font-bold text-gray-800">Go Blogs^_^</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 transition">
                    <i class="ri-home-line mr-1"></i>Beranda
                </a>
                <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition flex items-center">
                    <i class="ri-dashboard-line mr-2"></i>Dashboard
                </a>
            </div>
        </div>
    </nav>

    <!-- Layout dengan Sidebar -->
    <div class="flex h-screen pt-16">
        <!-- Sidebar -->
        @php
            $user = Auth::user();
        @endphp
        <aside class="w-64 bg-white border-r shadow-lg overflow-y-auto">
            <div class="p-4">
                <div class="flex items-center mb-6">
                    <img src="{{ asset(e($user->profile_image)) }}" alt="Admin Avatar" class="w-16 h-16 rounded-full mr-4 border-4 border-indigo-100">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">{{ $user->username }}</h2>
                        <p class="text-sm text-gray-500">{{ $user->role->name }}</p>
                    </div>
                </div>

                <nav>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="ri-dashboard-line"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users') }}" class="sidebar-menu {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                <i class="ri-group-line"></i>
                                <span>Manage Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.blogs.list') }}" class="sidebar-menu {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                <i class="ri-group-line"></i>
                                <span>Manage Blogs</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="sidebar-menu {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                <i class="ri-group-line"></i>
                                <span>Manage Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.setting') }}" class="sidebar-menu {{ request()->routeIs('admin.setting') ? 'active' : '' }}">
                                <i class="ri-settings-3-line"></i>
                                <span>Setting</span>
                            </a>
                        </li>
                        
                        <li>
                            <form action="{{route('logout')}}" method="POST" class="sidebar-menu text-red-500 hover:bg-red-50" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                                @csrf
                                <i class="ri-logout-box-r-line"></i>
                                <button type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Konten Utama -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            <!-- Pesan Notifikasi -->
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses! </strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove();">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            @endif

            @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error! </strong>
                <span class="block sm:inline">{{ session('error') }}</span>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove();">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            @endif

            <!-- Menampilkan Error Validasi -->
            @if ($errors->any())
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Terjadi Kesalahan:</strong>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove();">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            @endif

            @yield('content')  
        </main>
    </div>

    <style>
        .sidebar-menu {
            @apply flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition;
        }
        .sidebar-menu i {
            @apply mr-3 text-lg;
        }
        .sidebar-menu.active {
            @apply bg-indigo-50 text-indigo-600 font-semibold;
        }
    </style>
    @yield('scripts')

</body>
</html>
