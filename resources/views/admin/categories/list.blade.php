@extends('layout.dashboardAdmin')

@section('title', 'Daftar Kategori')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Daftar Kategori</h2>
        <a href="{{ route('admin.categories.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            <i class="ri-add-line"></i> Tambah Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-200 p-3">No</th>
                <th class="border border-gray-200 p-3">Nama</th>
                <th class="border border-gray-200 p-3">Slug</th>
                <th class="border border-gray-200 p-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $index => $category)
                <tr class="bg-white border-b">
                    <td class="p-3 border border-gray-200">{{ $index + 1 }}</td>
                    <td class="p-3 border border-gray-200">{{ $category->name }}</td>
                    <td class="p-3 border border-gray-200">{{ $category->slug }}</td>
                    <td class="p-3 border border-gray-200 text-center">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-500 hover:underline"><i class="ri-edit-line"></i> Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Hapus kategori ini?')">
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
