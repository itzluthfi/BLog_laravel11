@extends('layout.admin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Pengguna</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700">Nama</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full border p-2 rounded-lg">
            @error('username') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border p-2 rounded-lg">
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700">Password (Opsional)</label>
            <input type="password" name="password" class="w-full border p-2 rounded-lg">
            <p class="text-sm text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700">Role</label>
            <select name="role_id" class="w-full border p-2 rounded-lg">
                <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Pengguna</option>
            </select>
            @error('role_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
