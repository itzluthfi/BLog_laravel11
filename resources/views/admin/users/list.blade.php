@extends('layout.dashboardAdmin')

@section('title', 'Daftar Pengguna')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Pengguna</h2>
        <a href="{{ route('admin.users.add') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition flex items-center shadow-md">
            <i class="ri-add-line mr-2"></i> Tambah User
        </a>
    </div>

    <!-- 🔍 Search Bar -->
    <form method="GET" action="{{ route('admin.users') }}" class="mb-6">
        <div class="flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengguna..." 
                class="w-[400px] p-3 border rounded-l-lg focus:ring-2 focus:ring-indigo-300 focus:outline-none transition">
            <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-r-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-md">
                <i class="ri-search-line"></i>
            </button>
        </div>
    </form>

    <!-- 📜 Tabel Pengguna -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white rounded-lg shadow-sm">
            <thead>
                <tr class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Role</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b hover:bg-gray-50 transition duration-200">
                    <td class="p-4">{{ $user->id }}</td>
                    <td class="p-4">{{ $user->username }}</td>
                    <td class="p-4">{{ $user->email }}</td>
                    <td class="p-4">{{ $user->role->name }}</td>
                    <td class="p-4 flex flex-col items-center space-y-2">
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700 transition duration-200">
                                <i class="ri-edit-line text-xl"></i>
                            </a>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition duration-200">
                                    <i class="ri-delete-bin-line text-xl"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Tidak ada pengguna ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- 📌 Pagination -->
    <div class="mt-6">
       {{ $users->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection