@extends('layout.dashboardUser')


@section('title', 'Edit Artikel')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Artikel</h2>
    
    <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Judul</label>
            <input type="text" name="title" class="w-full border rounded-lg p-2" value="{{ $blog->title }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Header</label>
            <input type="file" name="image" class="w-full border rounded-lg p-2">
            @if ($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" class="w-32 mt-2">
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Potrait</label>
            <input type="file" name="portrait_image" class="w-full border rounded-lg p-2">
            @if ($blog->portrait_image)
                <img src="{{ asset('storage/' . $blog->portrait_image) }}" class="w-32 mt-2">
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Deskripsi Singkat</label>
            <textarea name="description" class="w-full border rounded-lg p-2" rows="3" required>{{ $blog->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Konten Lengkap</label>
            <textarea name="full_content" class="w-full border rounded-lg p-2" rows="6" required>{{ $blog->full_content }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Penulis</label>
            <select name="author_id" class="w-full border rounded-lg p-2" required>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ $blog->author_id == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Tanggal Publikasi</label>
            <input type="date" name="published_at" class="w-full border rounded-lg p-2" value="{{ $blog->published_at->format('Y-m-d') }}" required>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Perbarui Artikel</button>
    </form>
</div>
@endsection
