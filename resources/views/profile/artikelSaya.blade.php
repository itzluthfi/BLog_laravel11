@extends('layout.dashboardUser')

@section('title', 'Artikel Saya')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-4"><i class="fas fa-newspaper"></i> Artikel Saya</h2>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-4 flex items-center">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Input pencarian --}}
        <div class="mb-4">
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Cari artikel..." 
                    class="w-full p-3 pl-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>

        {{-- Jika tidak ada artikel --}}
        @if ($blogs->isEmpty())
            <p class="text-gray-500 text-center"><i class="fas fa-info-circle"></i> Anda belum memiliki artikel.</p>
        @else
            {{-- Header menggunakan landscape_image --}}
            @if ($blogs->first()->landscape_image)
                <div class="mb-6">
                    <img src="{{ asset($blogs->first()->landscape_image) }}" 
                        alt="Header Artikel" 
                        class="w-full h-64 object-cover rounded-lg shadow-md">
                </div>
            @endif

            {{-- Daftar Artikel --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="blogContainer">
                @foreach ($blogs as $blog)
                    <div class="bg-white border border-gray-200 p-5 rounded-lg shadow-md hover:shadow-lg transition">
                        {{-- Gambar artikel --}}
                        @if ($blog->landscape_image)
                            <img src="{{ asset($blog->landscape_image) }}" 
                                alt="{{ $blog->title }}" 
                                class="w-full h-48 object-cover rounded-lg">
                        @endif

                        <div class="mt-4">
                            {{-- Judul Artikel --}}
                            <h3 class="text-lg font-semibold text-gray-800"><i class="fas fa-book-open"></i> {{ $blog->title }}</h3>
                            
                            {{-- Informasi author dan tanggal --}}
                            <div class="text-sm text-gray-500 flex items-center gap-2 mt-2">
                                <i class="fas fa-user"></i> {{ $blog->author->username }} |
                                <i class="fas fa-calendar-alt"></i> {{ date('d M Y', strtotime($blog->published_at)) }}
                            </div>

                            {{-- Terakhir diperbarui --}}
                            <p class="text-xs text-gray-400 mt-1"><i class="fas fa-clock"></i> Diperbarui: {{ date('d M Y', strtotime($blog->updated_at)) }}</p>

                            {{-- Deskripsi singkat --}}
                            <p class="text-gray-600 text-sm mt-2">{{ Str::limit($blog->description, 100) }}</p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-4 flex justify-between items-center">
                            <a href="{{ route('profile.blog.show', $blog->id) }}" 
                                class="text-indigo-600 hover:underline text-sm">
                                <i class="fas fa-eye"></i> Baca selengkapnya
                            </a>

                            <div class="flex gap-3">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('profile.blog.edit', $blog->id) }}" 
                                    class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 transition">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('profile.blog.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Script untuk fitur pencarian --}}
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let blogs = document.querySelectorAll('#blogContainer div');

            blogs.forEach(blog => {
                let title = blog.querySelector('h3').innerText.toLowerCase();
                if (title.includes(searchText)) {
                    blog.style.display = 'block';
                } else {
                    blog.style.display = 'none';
                }
            });
        });
    </script>

    {{-- Font Awesome untuk ikon --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
@endsection
