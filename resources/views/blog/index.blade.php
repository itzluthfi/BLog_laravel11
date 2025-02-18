@extends('layout.app') 



@section('title_page', 'Blog Page') <!-- Mengisi bagian @yield('title_page') -->

@section('content') <!-- Mengisi bagian @yield('content') -->

    <!-- blog section -->
    <x-blog-header :header="'Latest Blog Posts'" />

    <div class="container mx-auto px-6 ">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <!-- Menggunakan komponen blog-card untuk setiap blog -->
            @foreach ($blogs as $blog)
                <x-blog-card :post="$blog" />
            @endforeach
        </div>
    </div>

    <x-blog-header :header="'Popular Blog Posts'" />

    {{-- <div class="container mx-auto px-6 mb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <!-- Menggunakan komponen blog-card untuk setiap post -->
            @foreach ($posts as $post)
                <x-blog-card :post="$post" />
            @endforeach
        </div>
    </div> --}}



@endsection
