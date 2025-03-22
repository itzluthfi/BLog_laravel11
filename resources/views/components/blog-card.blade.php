<div class="card bg-base-100 shadow-xl" data-aos="fade-up" data-aos-delay="100">
    <figure class="h-56 w-full overflow-hidden relative group">
          <!-- Gambar dengan efek hover -->
        <img src="{{ asset($blog->landscape_image) }}" alt="{{ $blog->title }}" class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105">
        <div class="absolute inset-0 bg-black bg-opacity-10 group-hover:bg-opacity-20 transition duration-300"></div>
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