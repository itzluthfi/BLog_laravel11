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
                <span class="text-2xl font-bold text-gray-800">Admin Panel</span>
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
        <aside class="w-64 bg-white border-r shadow-lg overflow-y-auto">
            <div class="p-4">
                <div class="flex items-center mb-6">
                    <img src="https://via.placeholder.com/100" alt="Admin Avatar" class="w-16 h-16 rounded-full mr-4 border-4 border-indigo-100">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Admin</h2>
                        <p class="text-sm text-gray-500">Administrator</p>
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
                                <span>Kelola Pengguna</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.blogs.list') }}" class="sidebar-menu {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                <i class="ri-group-line"></i>
                                <span>Kelola Blogs</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.setting') }}" class="sidebar-menu {{ request()->routeIs('admin.setting') ? 'active' : '' }}">
                                <i class="ri-settings-3-line"></i>
                                <span>Pengaturan</span>
                            </a>
                        </li>
                        
                        <li>
                            <form action="{{route('logout')}}" method="POST" class="sidebar-menu text-red-500 hover:bg-red-50">
                                @csrf
                                <i class="ri-logout-box-r-line"></i>
                                <button type="submit">Keluar</button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Konten Utama -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
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
</body>
</html>
