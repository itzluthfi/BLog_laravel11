@extends('layout.dashboardAdmin')

@section('title', 'Edit Artikel')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Artikel</h2>
    
    <form id="artikelForm" action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="author_id" value="{{ $blog->author_id }}">
        <input type="hidden" name="old_landscape_image" value="{{ $blog->landscape_image }}">
        <input type="hidden" name="old_portrait_image" value="{{ $blog->portrait_image }}">

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Judul</label>
            <input type="text" name="title" class="w-full border rounded-lg p-2" value="{{ old('title', $blog->title) }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
            <select name="category_id" class="w-full border rounded-lg p-2" required>
                <option value="" disabled>Pilih kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Header</label>
            <input type="file" name="landscape_image" class="w-full border rounded-lg p-2" id="headerImageInput">
            <div class="mt-2">
                <p class="text-sm text-gray-500 mb-2">Preview:</p>
                <img id="headerImagePreview" src="{{ $blog->landscape_image ? asset($blog->landscape_image) : '#' }}" 
                     class="w-32 rounded-lg {{ $blog->landscape_image ? '' : 'hidden' }}">
            </div>
        </div>

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
            <div id="editor" class="w-full border rounded-lg p-2"></div>
            <textarea name="full_content" id="full_content" class="hidden">{{ old('full_content', $blog->full_content) }}</textarea>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });
    
        quill.root.innerHTML = `{!! addslashes($blog->full_content) !!}`;
    
        quill.on('text-change', function() {
            document.getElementById('full_content').value = quill.root.innerHTML;
        });
    
        // Upload gambar baru di editor
        quill.getModule('toolbar').addHandler('image', function() {
            let input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();
    
            input.onchange = function() {
                let file = input.files[0];
                let formData = new FormData();
                formData.append("image", file);
    
                fetch("{{ route('profile.upload.image.content') }}", {
                    method: "POST",
                    body: formData,
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        let range = quill.getSelection();
                        quill.insertEmbed(range.index, "image", data.url);
                    }
                })
                .catch(error => console.error("Upload error:", error));
            };
        });
    });
    </script>
    
    
    
@endpush
