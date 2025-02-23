@extends('layout.DashboardAdmin')

@section('title', 'Edit Kategori')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-md mx-auto">
    <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit Kategori</h2>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nama Kategori</label>
            <input type="text" name="name" id="name" value="{{ $category->name }}" class="w-full border rounded-lg p-2 focus:ring focus:ring-indigo-300" required>
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('categories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
