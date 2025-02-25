@extends('layout.app') 


@section('title_page', 'Home Page') <!-- Mengisi bagian @yield('title_page') -->

@section('content') <!-- Mengisi bagian @yield('content') -->
<section class="relative min-h-screen flex items-center justify-center bg-cover"
    style="background-image: url('https://c4.wallpaperflare.com/wallpaper/709/1004/1003/manhwa-solo-leveling-sung-jin-woo-op-hd-wallpaper-preview.jpg'); background-position: center 40%;">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-purple-600 bg-opacity-70"></div>

    <!-- Content -->
    <div class="container mx-auto px-6 text-center z-10" data-aos="fade-up">
        <h1 class="text-5xl md:text-6xl font-bold mb-8 animate-pulse text-white">Welcome to Go Blog ^_^</h1>
        <p class="text-xl md:text-2xl mb-12 text-gray-200">Discover amazing stories and insights</p>
        <a href="blog"
            class="bg-white text-indigo-600 px-8 py-3 rounded-full font-semibold text-lg hover:bg-gray-100 transition duration-300 transform hover:scale-105 inline-block">
            Explore Blog
        </a>
    </div>
</section>
@endsection
