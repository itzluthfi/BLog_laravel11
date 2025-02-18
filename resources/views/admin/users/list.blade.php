@extends('layout.dashboardAdmin')


@section('title', 'Daftar Pengguna')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Daftar Pengguna</h2>

    {{-- Tombol Tambah User --}}
    <div class="flex justify-between mb-4">
        <form action="{{ route('admin.users') }}" method="GET" class="flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengguna..."
                class="border p-2 rounded-l focus:outline-none focus:ring focus:ring-blue-300">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r">Cari</button>
        </form>
        <a href="{{ route('admin.users.add') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            + Tambah User
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    {{-- Tabel User --}}
    <table class="w-full border-collapse border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-300 p-2">ID</th>
                <th class="border border-gray-300 p-2">Nama</th>
                <th class="border border-gray-300 p-2">Email</th>
                <th class="border border-gray-300 p-2">Role</th>
                <th class="border border-gray-300 p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="text-center">
                <td class="border border-gray-300 p-2">{{ $user->id }}</td>
                <td class="border border-gray-300 p-2">{{ $user->username }}</td>
                <td class="border border-gray-300 p-2">{{ $user->email }}</td>
                <td class="border border-gray-300 p-2">{{ $user->role->name }}</td>
                <td class="border border-gray-300 p-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus pengguna ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-gray-500 p-4">Tidak ada pengguna ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $users->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection
