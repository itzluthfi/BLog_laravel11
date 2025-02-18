@extends('layout.dashboardAdmin')

@section('title', 'Tambah Blog')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Blog</h2>

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700">Judul Blog</label>
            <input type="text" name="title" class="w-full p-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Gambar</label>
            <input type="file" name="image" class="w-full p-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="description" class="w-full p-2 border rounded-lg"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Konten Lengkap</label>
            <textarea name="full_content" class="w-full p-2 border rounded-lg"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Tanggal Publikasi</label>
            <input type="date" name="published_at" class="w-full p-2 border rounded-lg">
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Simpan</button>
    </form>
</div>
@endsection
