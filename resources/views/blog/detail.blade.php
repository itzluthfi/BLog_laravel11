@extends('layout.app') 


@section('title_page', 'Post Detail')

@section('content')
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <!-- Title -->
        <h1 class="text-4xl font-bold text-center mb-12 gradient-text" data-aos="fade-up">{{ $blog['title'] }}</h1>

        <!-- Gambar Landscape untuk Detail Blog -->
        <div class="bg-white rounded-lg overflow-hidden shadow-lg mb-8" data-aos="fade-up">
            <img src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}" class="w-full h-80 object-cover transform hover:scale-105 transition duration-500">
            <div class="p-6">
                <p class="text-gray-600 mb-4">{{ $blog['description'] }}</p>
                <p class="text-sm text-gray-500">By: <span class="font-semibold">{{ $blog->author->username }}</span> | Published on: {{ \Carbon\Carbon::parse($blog['published_at'])->format('F j, Y') }}</p>
            </div>
        </div>

        <!-- Konten Detail dengan Gambar Potrait di Samping -->
        <div class="flex flex-col lg:flex-row bg-white p-8 rounded-lg shadow-lg gap-8  max-h-[600px] overflow-hidden overflow-y-auto" data-aos="fade-up">
            <!-- Konten Detail -->
            <div class="lg:w-3/5 w-full " >
                <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Full Content</h2>
                <p class="text-gray-700 mb-4">{{ $blog['full_content'] }}</p>
                {{-- <p class="text-gray-500 text-sm">Tags: 
                    @foreach($blog['tags'] as $tag)
                        <span class="inline-block bg-indigo-100 text-indigo-600 rounded-full px-2 py-1 text-xs font-medium mb-2">{{ $tag }}</span>
                    @endforeach
                </p> --}}
            </div>
            <!-- Gambar Potrait -->
            <div class="lg:w-2/5 w-full ">
                <img src="{{ $blog['image'] }}" alt="{{ $blog['title'] }} - Portrait" class="w-full h-auto object-cover rounded-lg shadow-lg transform hover:scale-105 transition duration-500">
            </div>
        </div>

        <!-- Tombol Kembali ke Blog -->
        <div class="mt-8 text-center">
            <a href="/blog" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 transform hover:scale-105">
                Back to Blog
            </a>
        </div>
    </div>
</section>
@endsection
