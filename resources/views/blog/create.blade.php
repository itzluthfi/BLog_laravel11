@extends('layout.dashboardUser')

@section('title', 'Tulis Artikel Baru')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Tulis Artikel Baru</h2>
    
    <form id="artikelForm" action="{{ route('profile.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Judul</label>
            <input type="text" name="title" class="w-full border rounded-lg p-2" placeholder="Masukkan judul..." required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Kategori</label>
            <select name="category_id" class="w-full border rounded-lg p-2" required>
                <option value="" disabled selected>Pilih kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
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
            <label class="block text-gray-700">Konten Lengkap</label>
            <div id="editor" class="w-full p-2 border rounded-lg"></div>
            <input type="hidden" name="full_content" id="full_content">
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Simpan Artikel</button>
    </form>
</div>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

<script>
document.addEventListener("DOMContentLoaded", function() {
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: {
                container: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ],
                handlers: {
                    image: function () {
                        let input = document.createElement('input');
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');
                        input.click();

                        input.onchange = () => {
                            let file = input.files[0];

                            if (!file) return; // Cegah error jika user batal pilih file

                            let formData = new FormData();
                            formData.append('image', file);

                            fetch("{{ route('profile.upload.image.content') }}", {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.url) { 
                                    let range = quill.getSelection();
                                    quill.insertEmbed(range.index, 'image', result.url);
                                } else {
                                    console.error('Gagal mendapatkan URL gambar:', result);
                                }
                            })
                            .catch(error => console.error('Error uploading image:', error));
                        };
                    }
                }
            }
        }
    });

    document.getElementById('artikelForm').onsubmit = function() {
        document.getElementById('full_content').value = quill.root.innerHTML;
    };
});
</script>
@endsection
