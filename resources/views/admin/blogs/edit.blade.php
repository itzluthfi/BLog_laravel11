@extends('layout.dashboardAdmin')

@section('title', 'Edit Blog')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Blog</h2>

    <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">Judul Blog</label>
            <input type="text" name="title" class="w-full p-2 border rounded-lg" value="{{ $blog->title }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Gambar Saat Ini</label>
            <img src="{{ asset('storage/' . $blog->image) }}" alt="Gambar" class="w-32 h-32 object-cover rounded-lg">
            <input type="file" name="image" class="w-full p-2 border rounded-lg mt-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="description" class="w-full p-2 border rounded-lg">{{ $blog->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Konten Lengkap</label>
            <textarea name="full_content" class="w-full p-2 border rounded-lg">{{ $blog->full_content }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Tanggal Publikasi</label>
            <input type="date" name="published_at" class="w-full p-2 border rounded-lg" value="{{ $blog->published_at }}">
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Perbarui</button>
    </form>
</div>
@endsection
