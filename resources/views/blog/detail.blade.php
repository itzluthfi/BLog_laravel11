@extends('layout.app')

@section('title_page', 'Post Detail')

@section('content')
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <!-- Title -->
        <h1 class="text-4xl font-bold text-center mb-12 gradient-text" data-aos="fade-up">{{ $blog->title }}</h1>

        <!-- Gambar Landscape untuk Detail Blog -->
        <div class="bg-white rounded-lg overflow-hidden shadow-lg mb-8" data-aos="fade-up">
            <img src="{{ asset($blog->landscape_image) }}" alt="{{ $blog->title }}" class="w-full h-80 object-cover transform hover:scale-105 transition duration-500">
            <div class="p-6">
                <p class="text-gray-600 mb-4">{{ $blog->description }}</p>
                <p class="text-sm text-gray-500 flex items-center gap-2">
                    <i class="fas fa-user text-indigo-500"></i> <span class="font-semibold">{{ $blog->author->username }}</span> | 
                    <i class="far fa-calendar-alt text-indigo-500"></i> {{ $blog->published_at->format('F j, Y') }}
                </p>
            </div>
        </div>

        <!-- Konten Detail -->
        <div class="flex flex-col lg:flex-row bg-white p-8 rounded-lg shadow-lg gap-8 max-h-[600px] overflow-hidden overflow-y-auto" data-aos="fade-up">
            <div class="lg:w-3/5 w-full">
                <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Full Content</h2>
                <p class="text-gray-700 mb-4">{{ $blog->full_content }}</p>
            </div>
            <div class="lg:w-2/5 w-full">
                <img src="{{ asset($blog->portrait_image) }}" alt="{{ $blog->title }} - Portrait" class="w-full h-auto object-cover rounded-lg shadow-lg transform hover:scale-105 transition duration-500">
            </div>
        </div>

        <!-- Section Komentar -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-12" data-aos="fade-up">
            <h3 class="text-2xl font-semibold text-indigo-600 mb-4">Comments</h3>

            <!-- Dummy Comments -->
            <div class="space-y-3">
                @foreach (range(1, 3) as $i)
                <div class="bg-gray-50 p-4 rounded-lg shadow flex flex-col sm:flex-row gap-4">
                    <div class="flex-shrink-0">
                        <img src="https://i.pravatar.cc/50?u={{ $i }}" alt="User Avatar" class="rounded-full w-12 h-12">
                    </div>
                    <div class="flex-grow">
                        <p class="text-gray-800 font-semibold">User {{ $i }}</p>
                        <p class="text-gray-600 text-sm">This is a sample comment. Great blog post!</p>
                        <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                            <button class="flex items-center gap-1 hover:text-indigo-600">
                                <i class="far fa-thumbs-up"></i> Like
                            </button>
                            <button class="flex items-center gap-1 hover:text-indigo-600">
                                <i class="fas fa-reply"></i> Reply
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Form Tambah Komentar -->
            <div class="mt-6">
                <h4 class="text-lg font-semibold text-gray-800">Add a Comment</h4>
                <form action="#" method="POST" class="mt-3">
                    <textarea class="w-full p-3 border rounded-lg focus:ring focus:ring-indigo-300" rows="3" placeholder="Write your comment here..."></textarea>
                    <button type="submit" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300">
                        Post Comment
                    </button>
                </form>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-8 text-center">
            <a href="{{ route('blog.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 transform hover:scale-105">
                Back to Blog
            </a>
        </div>
    </div>
</section>

<!-- FontAwesome for Icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
@endsection
