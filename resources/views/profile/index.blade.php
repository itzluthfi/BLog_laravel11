@extends('layout.dashboardUser')


@section('title', 'Profil Pengguna')

@section('content')
<section class="bg-white rounded-xl shadow-lg p-6">
    <h1 class="text-3xl font-bold text-gray-800">Profil Pengguna</h1>
    <p class="text-gray-600">Kelola informasi akun Anda</p>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-md mt-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Profil Pengguna -->
    <div class="flex items-center mt-6">
        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://via.placeholder.com/100' }}" 
            class="w-24 h-24 rounded-full border-4 border-indigo-100">
        <div class="ml-4">
            <h2 class="text-lg font-semibold">{{ $user->username }}</h2>
            <p class="text-gray-500">{{ $user->email }}</p>
        </div>
    </div>

    <!-- Form Update Profil -->
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
        @csrf

        <div>
            <label class="text-gray-700 font-semibold">Nama</label>
            <input type="text" name="name" value="{{ $user->username }}" required
                class="w-full p-2 border rounded-md focus:outline-indigo-500">
        </div>

        <div>
            <label class="text-gray-700 font-semibold">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" required
                class="w-full p-2 border rounded-md focus:outline-indigo-500">
        </div>

        <div>
            <label class="text-gray-700 font-semibold">Bio</label>
            <textarea name="bio" rows="3" class="w-full p-2 border rounded-md focus:outline-indigo-500">{{ $user->bio }}</textarea>
        </div>

        <div>
            <label class="text-gray-700 font-semibold">Foto Profil</label>
            <input type="file" name="avatar" class="w-full p-2 border rounded-md">
        </div>

        <button type="submit" 
            class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
            Perbarui Profil
        </button>
    </form>
</section>
@endsection
