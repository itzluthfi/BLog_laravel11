<div class="bg-white rounded-2xl overflow-hidden shadow-lg transition-transform duration-300 hover:scale-[1.03]" data-aos="fade-up">
    <!-- Gambar dengan efek hover -->
    <div class="relative group">
        <img src="{{ asset($blog->landscape_image) }}" alt="{{ $blog->title }}" class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105">
        <div class="absolute inset-0 bg-black bg-opacity-10 group-hover:bg-opacity-20 transition duration-300"></div>
    </div>

    <div class="p-6">
        <!-- Judul -->
        <h3 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            {{ $blog->title }}
        </h3>

        <!-- Informasi Penulis, Tanggal & Kategori -->
        <div class="text-gray-500 text-sm flex flex-wrap items-center gap-6 mt-3">
            <div class="flex items-center gap-2">
                <i class="far fa-calendar-alt text-indigo-500"></i>
                <span>{{ $blog->published_at->format('d M Y') }}</span> 
                | <span>{{ $blog->created_at->diffForHumans() }}</span>
            </div>
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ $blog->author->name }}</span>
            </div>
            <div class="flex items-center gap-2 bg-indigo-100 text-indigo-600 px-4 py-1 rounded-full text-sm font-medium">
                <i class="fa-solid fa-tag text-indigo-600 text-base"></i>
                <span class="text-sm">{{ $blog->category->name }}</span>
            </div>
            
        </div>

        <!-- Deskripsi -->
        <p class="text-gray-600 mt-4 line-clamp-3">{{ $blog->description }}</p>

        <!-- Tombol Read More -->
        <div class="mt-5">
            <a href="{{ route('profile.blog.show', $blog) }}"
                class="inline-flex items-center bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition duration-300 shadow-md">
                Read More 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>
