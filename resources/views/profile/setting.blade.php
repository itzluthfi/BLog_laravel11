@extends('layout.dashboardUser')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Pengaturan Akun</h2>

   

    <form action="{{ route('profile.setting.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Foto Profil -->
        <div class="flex flex-col items-center">
            <img id="profile-preview" src="{{ asset($user->profile_image) }}" alt="Profile Image" class="w-32 h-32 rounded-full border-4 border-indigo-200 shadow-md mb-3">
            <label for="profile_image" class="cursor-pointer bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Ubah Foto</label>
            <input type="file" name="profile_image" id="profile_image" class="hidden" accept="image/*" onchange="previewImage(event)">
            @error('profile_image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full border p-2 rounded-lg">
            @error('username') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border p-2 rounded-lg">
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-gray-700">Password Baru (Opsional)</label>
            <input type="password" name="password" class="w-full border p-2 rounded-lg">
            <p class="text-sm text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            Simpan Perubahan
        </button>
    </form>
</div>

@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('profile-preview').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
