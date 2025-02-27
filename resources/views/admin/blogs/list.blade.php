@extends('layout.dashboardAdmin')

@section('title', 'Kelola Blog')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Daftar Blog</h2>
        <a href="{{ route('admin.blogs.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition flex items-center">
            <i class="ri-add-line mr-2"></i> Tambah Blog
        </a>
    </div>

    <!-- 🔍 Search Bar -->
    <form method="GET" action="{{ route('admin.blogs.list') }}" class="mb-4">
        <div class="flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari blog..." 
                class="w-[400px] p-2 border rounded-l-lg focus:ring focus:ring-indigo-300">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-lg hover:bg-indigo-700">
                <i class="ri-search-line"></i>
            </button>
        </div>
    </form>

    <!-- 📜 Tabel Blog -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white rounded-lg shadow-sm">
            <thead>
                <tr class="bg-indigo-100 text-gray-700">
                    <th class="p-3 text-left">Judul</th>
                    <th class="p-3 text-left">Category</th>
                    <th class="p-3 text-left">Penulis</th>
                    <th class="p-3 text-left">Tanggal Publikasi</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blogs as $blog)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $blog->title }}</td>
                    <td class="p-3">{{ $blog->category->name }}</td>
                    <td class="p-3">
                        {{ $blog->author ? $blog->author->username : 'Tidak Ada Author' }}
                    </td>
                    <td class="p-3">
                        {{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('d M Y') : '-' }} 
                       
                        @if($blog->updated_at )
                          
                           <br><span class="text-gray-500 text-xs italic"> Terakhir diperbarui {{ \Carbon\Carbon::parse($blog->updated_at)->diffForHumans() }}</span>
                        @endif
                    </td>
                    
                    
                    <td class="p-3 flex justify-center space-x-2">
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-blue-500 hover:underline">
                            <i class="ri-edit-line"></i>
                        </a>
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus blog ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-3 text-center text-gray-500">Tidak ada blog ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- 📌 Pagination -->
    <div class="mt-4">
       {{ $blogs->appends(['search' => request('search')])->links() }}

    </div>
</div>
@endsection
