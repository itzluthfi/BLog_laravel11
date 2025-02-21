@extends('layout.dashboardUser')

@section('title', 'Edit Artikel')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Artikel</h2>
    
    <form action="{{ route('profile.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="author_id" value="{{ $blog->author_id }}">
        {{-- Gambar Header --}}
        <input type="hidden" name="old_landscape_image" value="{{ $blog->landscape_image }}">

        {{-- Gambar Portrait --}}
        <input type="hidden" name="old_portrait_image" value="{{ $blog->portrait_image }}">


        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Judul</label>
            <input type="text" name="title" class="w-full border rounded-lg p-2" value="{{ old('title', $blog->title) }}" required>
        </div>

        {{-- Gambar Header --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Header</label>
            <input type="file" name="landscape_image" class="w-full border rounded-lg p-2" id="headerImageInput">
            <div class="mt-2">
                <p class="text-sm text-gray-500 mb-2">Preview:</p>
                <img id="headerImagePreview" src="{{ $blog->landscape_image ? asset($blog->landscape_image) : '#' }}" 
                     class="w-32 rounded-lg {{ $blog->landscape_image ? '' : 'hidden' }}">
            </div>
        </div>

        {{-- Gambar Portrait --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Portrait</label>
            <input type="file" name="portrait_image" class="w-full border rounded-lg p-2" id="portraitImageInput">
            <div class="mt-2">
                <p class="text-sm text-gray-500 mb-2">Preview:</p>
                <img id="portraitImagePreview" src="{{ $blog->portrait_image ? asset($blog->portrait_image) : '#' }}" 
                     class="w-32 rounded-lg {{ $blog->portrait_image ? '' : 'hidden' }}">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Deskripsi Singkat</label>
            <textarea name="description" class="w-full border rounded-lg p-2" rows="3" required>{{ old('description', $blog->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Konten Lengkap</label>
            <textarea name="full_content" class="w-full border rounded-lg p-2" rows="6" required>{{ old('full_content', $blog->full_content) }}</textarea>
        </div>

        {{-- Tanggal Publikasi --}}
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Tanggal Publikasi</label>
            <input type="date" name="published_at" class="w-full border rounded-lg p-2" 
                   value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d') : '') }}" required>
        </div>

        <div class="flex flex-wrap gap-3">
            <button type="submit" class="w-full sm:w-auto bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                Perbarui Artikel
            </button>
            <button type="button" onclick="history.back()" class="w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                Batal
            </button>
        </div>
    </form>
</div>

{{-- JavaScript untuk menampilkan preview gambar --}}
<script>
function previewImage(inputId, previewId) {
    document.getElementById(inputId).addEventListener('change', function(event) {
        let file = event.target.files[0];
        let preview = document.getElementById(previewId);

        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
}

previewImage('headerImageInput', 'headerImagePreview');
previewImage('portraitImageInput', 'portraitImagePreview');
</script>

@endsection
