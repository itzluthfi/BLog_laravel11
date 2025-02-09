@extends('components.layoutProfile')

@section('title', 'Artikel Saya')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Artikel Saya</h2>

        @if ($blogs->isEmpty())
            <p class="text-gray-500">Anda belum memiliki artikel.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($blogs as $blog)
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                        @if ($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="w-full h-40 object-cover rounded">
                        @endif
                        <h3 class="text-lg font-semibold text-gray-800 mt-2">{{ $blog->title }}</h3>
                        <p class="text-gray-600 text-sm">{{ Str::limit($blog->description, 100) }}</p>
                        <a href="{{ route('blog.show', $blog->id) }}" class="text-indigo-600 hover:underline text-sm">Baca selengkapnya</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
