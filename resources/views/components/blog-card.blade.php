<!-- resources/views/components/blog-card.blade.php -->
<div class="bg-white rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105" data-aos="fade-up">
    <img src="{{ $post->landscape_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
    <div class="p-6">
        <h3 class="text-xl font-semibold mb-2">{{ $post->title }}</h3>
        <p class="text-gray-600 mb-4">{{ $post->description }}</p>
        <!-- Menggunakan route() dengan parameter model -->
        <a href="{{ route('profile.blog.show', $post) }}"
            class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition duration-300">
            Read More 
        </a>
    </div>
</div>
