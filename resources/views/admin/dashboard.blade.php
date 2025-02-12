@extends('layout.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dashboard Admin</h2>
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-indigo-100 p-4 rounded-lg flex items-center">
            <i class="ri-user-line text-4xl text-indigo-600 mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold">Total Pengguna</h3>
                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            </div>
        </div>
        <div class="bg-green-100 p-4 rounded-lg flex items-center">
            <i class="ri-article-line text-4xl text-green-600 mr-4"></i>
            <div>
                <h3 class="text-lg font-semibold">Total Artikel</h3>
                <p class="text-2xl font-bold">{{ $totalBlogs }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
