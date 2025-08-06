@extends('layout.dashboardAdmin')

@section('title', 'Daftar Komentar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-700">Daftar Semua Komentar</h2>
    <div class="flex justify-between items-center my-4">

        <!-- Kolom Pencarian di Sebelah Kiri -->
        <input type="text" id="searchInput" placeholder="Cari Komentar..." class="px-4 py-2 border rounded-lg w-1/3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        
        {{-- <a href="{{ route('admin.comments.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            <i class="ri-add-line"></i> Tambah Komentar
        </a> --}}
    </div>

    

    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-200 p-3">No</th>
                <th class="border border-gray-200 p-3">komentar</th>
                <th class="border border-gray-200 p-3">Blog</th>
                <th class="border border-gray-200 p-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody id="commentTable">
            @foreach ($comments as $index => $comment)

                <tr class="bg-white border-b hover:bg-gray-100 transition">
                    <td class="p-3 border border-gray-200">{{ $index + 1 }}</td>
                    <td class="p-3 border border-gray-200">{{ $comment->content }}</td>
                    <td class="p-3 border border-gray-200">
                        <a href="{{ route('profile.blog.show', $comment->blog->slug) }}" class="text-blue-600 hover:underline">
                            {{ $comment->blog->slug }}
                        </a>
                    </td>
                    
                    <td class="p-3 border border-gray-200 text-center">
                        <a href="{{ route('admin.comments.edit', $comment) }}" class="text-blue-500 hover:underline"><i class="ri-edit-line"></i> Edit</a>
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Hapus Komentar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline"><i class="ri-delete-bin-line"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
@push('scripts')
    
<!-- Script Pencarian -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#commentTable tr');

        rows.forEach(row => {
            let commentName = row.cells[1].textContent.toLowerCase();
            row.style.display = commentName.includes(filter) ? '' : 'none';
        });
    });
</script>
@endpush

