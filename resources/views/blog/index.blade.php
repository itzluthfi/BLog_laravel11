@extends('layout.app') 



@section('title_page', 'Blog Page') <!-- Mengisi bagian @yield('title_page') -->

@section('content') <!-- Mengisi bagian @yield('content') -->

    <!-- blog section -->
    <x-blog-header :header="'Latest Blog Posts'" />

    <div class="container mx-auto px-6 ">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <!-- Menggunakan komponen blog-card untuk setiap blog -->
            @foreach ($blogs as $blog)
                <x-blog-card :blog="$blog" />
            @endforeach
        </div>
    </div>

    <x-blog-header :header="'Popular Blog Posts'" />

    {{-- <div class="container mx-auto px-6 mb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <!-- Menggunakan komponen blog-card untuk setiap post -->
            @foreach ($posts as $post)
                <x-blog-card :post="$post" />
            @endforeach
        </div>
    </div> --}}



@endsection
@push('scripts')
<script>
    console.log("Script loaded successfully!");
    document.addEventListener("DOMContentLoaded", function () {
    // Like Button
    document.querySelectorAll(".like-btn").forEach(button => {
        button.addEventListener("click", function () {
            let route = this.dataset.route;
            fetch(route, { 
                method: "POST",
                headers: { 
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json"
                }
            })
            .then(response => {
                if (response.status === 401) {
                    return response.json().then(data => {
                        throw new Error(data.error || "You need to login to perform this action.");
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log("Response:", data);
                let icon = this.querySelector(".fa-heart");
                if (icon) {
                    icon.classList.toggle("text-red-500");
                    icon.classList.toggle("text-gray-400");
                }
                let likeCount = this.querySelector(".like-count");
                if (likeCount) {
                    likeCount.textContent = data.likes;
                }
            })
            .catch(error => {
                alert(error.message);
            });
        });
    });

    // Favorite Button
    document.querySelectorAll(".favorite-btn").forEach(button => {
        button.addEventListener("click", function () {
            let route = this.dataset.route;
            fetch(route, { 
                method: "POST", 
                headers: { 
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log("Response:", data);
                let icon = this.querySelector(".fa-star");
                if (icon) {
                    icon.classList.toggle("text-yellow-500");
                    icon.classList.toggle("text-gray-400");
                }
                let favoriteCount = this.querySelector(".favorite-count");
                if (favoriteCount) {
                    favoriteCount.textContent = data.favorites;
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});

    </script>
@endpush    