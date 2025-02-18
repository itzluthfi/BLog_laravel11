@extends('layout.dashboardAdmin')

@section('title', 'Daftar Pengguna')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Daftar Pengguna</h2>
        <a href="{{ route('admin.users.add') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition flex items-center">
            <i class="ri-add-line mr-2"></i> Tambah User
        </a>
    </div>

    <!-- 🔍 Search Bar -->
    <form method="GET" action="{{ route('admin.users') }}" class="mb-4">
        <div class="flex">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengguna..." 
                class="w-[400px] p-2 border rounded-l-lg focus:ring focus:ring-indigo-300">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-lg hover:bg-indigo-700">
                <i class="ri-search-line"></i>
            </button>
        </div>
    </form>

    <!-- 📜 Tabel Pengguna -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse bg-white rounded-lg shadow-sm">
            <thead>
                <tr class="bg-indigo-100 text-gray-700">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Role</th>
                    

                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $user->id }}</td>
                    <td class="p-3">{{ $user->username }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->role->name }}</td>
                   
                    <td class="p-3 flex flex-col items-center space-y-2">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:underline">
                                <i class="ri-edit-line"></i>
                            </a>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    
                        {{-- Terakhir diperbarui --}}
                        {{-- @if($user->updated_at)
                            <span class="text-gray-500 text-xs italic">Terakhir diperbarui {{ \Carbon\Carbon::parse($user->updated_at)->diffForHumans() }}</span>
                        @endif --}}
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-3 text-center text-gray-500">Tidak ada pengguna ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- 📌 Pagination -->
    <div class="mt-4">
       {{ $users->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection
