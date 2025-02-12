<header x-data="{ isOpen: false }" class="fixed top-0 left-0 right-0 z-50 bg-white bg-opacity-90 backdrop-filter backdrop-blur-lg shadow-md">
    <nav class="container mx-auto px-6 py-3">
        <div class="flex items-center justify-between">
            <a href="/" class="text-2xl font-bold gradient-text">Go Blog ^_^</a>
            <div class="hidden md:flex space-x-8">
                <a href="/" class="text-gray-700 hover:text-indigo-600 transition duration-300">Beranda</a>
                <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-indigo-600 transition duration-300">Blog</a>
                <a href="/about" class="text-gray-700 hover:text-indigo-600 transition duration-300">About</a>
                <a href="/contact" class="text-gray-700 hover:text-indigo-600 transition duration-300">Contact</a>
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-600 transition duration-300">dashboard admin</a>
                
                @auth
                    <!-- Link My Profile (Hanya muncul jika sudah login) -->
                    <a href="{{ route('profile.index') }}" class="text-gray-700 hover:text-indigo-600 transition duration-300">My Profile</a>
                @endauth
            </div>
            
            <div class="hidden md:block">
                @auth
                    <!-- Jika sudah login, tampilkan tombol Logout -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition duration-300">
                            Logout
                        </button>
                    </form>
                @else
                    <!-- Jika belum login, tampilkan tombol Login -->
                    <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition duration-300">
                        Login
                    </a>
                @endauth
            </div>

            <div class="md:hidden">
                <button @click="isOpen = !isOpen" class="text-gray-700 hover:text-indigo-600 focus:outline-none">
                    <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                        <path x-show="!isOpen" fill-rule="evenodd" clip-rule="evenodd" d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h16v2H4v-2z" />
                        <path x-show="isOpen" fill-rule="evenodd" clip-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="isOpen" 
            x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition transform ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="md:hidden mt-4 bg-white shadow-md rounded-lg p-4">
            
            <a href="/" class="block py-2 text-gray-700 hover:text-indigo-600">Home</a>
            <a href="{{ route('blog.index') }}" class="block py-2 text-gray-700 hover:text-indigo-600">Blog</a>
            <a href="/about" class="block py-2 text-gray-700 hover:text-indigo-600">About</a>
            <a href="/contact" class="block py-2 text-gray-700 hover:text-indigo-600">Contact</a>

            @auth
                <!-- Link My Profile (Hanya muncul jika sudah login) -->
                <a href="{{ route('profile.index') }}" class="block py-2 text-gray-700 hover:text-indigo-600">My Profile</a>
                
                <form action="{{ route('logout') }}" method="POST" class="mt-4 w-full">
                    @csrf
                    <button type="submit" class="text-gray-700 hover:text-indigo-600 transition duration-300">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 transition duration-300">
                    Login
                </a>
            @endauth
        </div>
    </nav>
</header>
