@extends('layout.app') 


@section('title_page', 'Beranda')

@section('content')
            
            <!-- Blog Content -->
            <main class="flex-grow pt-24 pb-16">
                <div class="container mx-auto px-4">
                    <!-- Hero Section -->
                    <div class="hero bg-gray-300 rounded-box mb-12" data-aos="fade-up">
                        <div class="hero-content flex-col lg:flex-row-reverse py-12">
                            <img src="https://picsum.photos/id/325/800/600" class="max-w-sm rounded-lg shadow-2xl" alt="Blog Hero" />
                            <div>
                                <h1 class="text-5xl font-bold">Explore Our Blog</h1>
                                <p class="py-6">Discover insightful articles, tutorials, and stories from our community of writers. Stay updated with the latest trends and learn something new every day.</p>
                               <!-- Form Pencarian -->
                                <form action="{{ route('home') }}" method="GET" class="join">
                                    <input type="text" name="search" value="{{ request('search') }}" class="input input-bordered join-item" placeholder="Search articles..." />
                                    <button type="submit" class="btn btn-primary join-item">Search</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
               


                    
                    <!-- Featured Posts -->
                    <div class="mb-12" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="text-2xl font-bold mb-6">Featured Posts</h2>
                        <div class="carousel w-full rounded-box">
                            <div id="slide1" class="carousel-item relative w-full">
                                <div class="hero min-h-[400px]" style="background-image: url(https://picsum.photos/id/1011/1200/600);">
                                    <div class="hero-overlay bg-opacity-60"></div>
                                    <div class="hero-content text-center text-neutral-content">
                                        <div class="max-w-md">
                                            <h1 class="mb-5 text-4xl font-bold">10 Tips for Better Productivity</h1>
                                            <p class="mb-5">Discover how to maximize your daily productivity with these proven strategies.</p>
                                            <button class="btn btn-primary">Read More</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    <a href="#slide3" class="btn btn-circle">❮</a> 
                                    <a href="#slide2" class="btn btn-circle">❯</a>
                                </div>
                            </div> 
                            <div id="slide2" class="carousel-item relative w-full">
                                <div class="hero min-h-[400px]" style="background-image: url(https://picsum.photos/id/1015/1200/600);">
                                    <div class="hero-overlay bg-opacity-60"></div>
                                    <div class="hero-content text-center text-neutral-content">
                                        <div class="max-w-md">
                                            <h1 class="mb-5 text-4xl font-bold">The Future of AI in 2023</h1>
                                            <p class="mb-5">Explore how artificial intelligence is transforming industries and our daily lives.</p>
                                            <button class="btn btn-primary">Read More</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    <a href="#slide1" class="btn btn-circle">❮</a> 
                                    <a href="#slide3" class="btn btn-circle">❯</a>
                                </div>
                            </div> 
                            <div id="slide3" class="carousel-item relative w-full">
                                <div class="hero min-h-[400px]" style="background-image: url(https://picsum.photos/id/1019/1200/600);">
                                    <div class="hero-overlay bg-opacity-60"></div>
                                    <div class="hero-content text-center text-neutral-content">
                                        <div class="max-w-md">
                                            <h1 class="mb-5 text-4xl font-bold">Sustainable Living Guide</h1>
                                            <p class="mb-5">Learn practical ways to reduce your carbon footprint and live more sustainably.</p>
                                            <button class="btn btn-primary">Read More</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    <a href="#slide2" class="btn btn-circle">❮</a> 
                                    <a href="#slide1" class="btn btn-circle">❯</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                 <!-- Categories Dropdown -->
                <div class="mb-8" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-2xl font-bold mb-4">Categories</h2>
                    <div x-data="{ selectedCategory: '{{ request('category') ?? '' }}' }">
                        <select x-model="selectedCategory" @change="window.location.href = selectedCategory ? '{{ route('home') }}?category=' + selectedCategory : '{{ route('home') }}'"
                            class="select select-bordered w-full max-w-xs">
                            <option value="" :selected="selectedCategory === ''">All</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}" :selected="selectedCategory === '{{ $category->name }}'">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                    <!-- Latest Posts -->
                    <div class="mb-12" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="text-2xl font-bold mb-6">Latest Posts</h2>

                        @if ($blogs->isEmpty())
                            <p class="text-center text-gray-500">Tidak ada postingan tersedia.</p>
                        @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($blogs as $blog)
                            <div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-delay="100">
                                <figure class="h-56 w-full overflow-hidden">
                                    <img src="{{ asset(e($blog->landscape_image)) }}" 
                                         alt="Blog-{{ $blog->title }}" 
                                         class="w-full h-full object-cover" />
                                </figure>
                                
                                <div class="card-body">
                                    <div class="badge badge-primary mb-2">{{$blog->category->name}}</div>
                              
                                    <a href="{{ route('profile.blog.show', $blog) }}" class=" hover:underline">

                                    <h2 class="card-title">{{$blog->title}}</h2>
                                </a>
                                    <p>{{$blog->description}}</p>
                                    <div class="flex items-center mt-2">
                                        <div class="avatar">
                                            <div class="w-10 rounded-full">
                                                <img src="{{ asset(e($blog->author->profile_image)) }}" alt="Author-{{ $blog->author->username }}" />
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium">{{$blog->author->username}}</p>
                                            <p class="text-xs opacity-70">{{$blog->created_at->format('d M Y')}}</p>
                                            <p class="text-xs opacity-70 mt-1 italic">{{$blog->updated_at->diffForHumans()}}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between mt-3">
                                        <a href="javascript:void(0)" class="flex items-center space-x-2 like-btn" 
                                        data-id="{{ $blog->id }}" 
                                        data-route="{{ route('profile.blog.like', $blog) }}">
                                        <i class="fa-solid fa-heart 
                                            {{ auth()->check() && $blog->isLikedBy(auth()->user()) ? 'text-red-500' : 'text-gray-400' }} 
                                            {{ auth()->check() ? '' : 'cursor-not-allowed opacity-50' }}" 
                                            title="{{ auth()->check() ? '' : 'Please login to like this post.' }}">
                                        </i>
                                         <span class="like-count">{{ $blog->likes()->count() }}</span>    
                                     </a>
                                     
                                     <button class="flex items-center space-x-2 favorite-btn" 
                                             data-id="{{ $blog->id }}" 
                                             data-route="{{ route('profile.blog.favorite', $blog) }}">
                                            <i class="fa-solid fa-star {{ auth()->check() && $blog->isFavoritedBy(auth()->user()) ? 'text-yellow-500' : 'text-gray-400' }}"></i>
                                         <span class="favorite-count">{{ $blog->favorites()->count() }}</span>
                                     </button>
                                     
                                    </div>
                                    
                                    <div class="card-actions justify-end ">
                                        <a href="{{ route('profile.blog.show', $blog) }}" class="btn btn-primary btn-sm">Read More</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        
                        </div>
                        @endif  
                    </div>
        
                    <!-- Pagination -->
                    @if ($blogs->hasPages())
                    <div class="flex justify-center my-10" data-aos="fade-up">
                        {{ $blogs->links('pagination::tailwind') }}
                    </div>
                    @endif
      
                    
                    <!-- Newsletter -->
                    <div class="card bg-primary text-primary-content shadow-xl" data-aos="fade-up">
                        <div class="card-body text-center">
                            <h2 class="card-title text-2xl font-bold mx-auto mb-2">Subscribe to Our Newsletter</h2>
                            <p class="mb-6">Get the latest articles, tutorials, and updates delivered straight to your inbox.</p>
                            <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                                <input type="email" placeholder="your-email@example.com" class="input input-bordered w-full" />
                                <button class="btn bg-white text-primary hover:bg-gray-200">Subscribe</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            
          
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