@extends('layout.dashboardUser')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>
    
    <!-- Statistik User -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Jumlah Artikel Saya</h2>
            <p class="text-2xl font-bold text-indigo-600">{{ $totalBlogs }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Artikel Disukai</h2>
            <p class="text-2xl font-bold text-indigo-600">6</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-semibold text-gray-700">Total Pengunjung</h2>
            <p class="text-2xl font-bold text-indigo-600">106</p>
        </div>
    </div>

    <!-- Daftar Artikel Terbaru -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Artikel Terbaru</h2>
        @if ($lastestBlogs->isEmpty())
            <p class="text-gray-500">Belum ada artikel yang dipublikasikan.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach ($lastestBlogs as $blog)
                    <li class="py-4 flex justify-between items-center">
                        <div>
                            <a href="{{ route('profile.blog.show', $blog) }}" class="text-lg font-semibold text-indigo-600 hover:underline">{{ $blog->title }}</a>
                            <p class="text-sm text-gray-500">Dipublikasikan pada {{ $blog->created_at->format('d M Y') }}</p>
                        </div>
                        <a href="{{ route('profile.artikelSaya') }}" class="text-gray-500 hover:text-indigo-600 transition">
                            <i class="ri-arrow-right-line text-xl"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
