@extends('layout.dashboardUser')

@section('title', 'Tulis Artikel Baru')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Tulis Artikel Baru</h2>
    
    <form action="{{ route('profile.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="author_id" value="{{ auth()->id() }}">

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Judul</label>
            <input type="text" name="title" class="w-full border rounded-lg p-2" placeholder="Masukkan judul..." required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Landscape (header)</label>
            <input type="file" name="landscape_image" class="w-full border rounded-lg p-2" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Potrait</label>
            <input type="file" name="portrait_image" class="w-full border rounded-lg p-2" required>
        </div>
        

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Deskripsi Singkat</label>
            <textarea name="description" class="w-full border rounded-lg p-2" rows="3" placeholder="Tulis deskripsi singkat..." required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Konten Lengkap</label>
            <textarea name="full_content" class="w-full border rounded-lg p-2" rows="6" placeholder="Tulis konten lengkap..." required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Tanggal Publikasi</label>
            <input type="date" name="published_at" class="w-full border rounded-lg p-2" required>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Simpan Artikel</button>
    </form>
</div>
@endsection
