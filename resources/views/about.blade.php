@extends('layout.app') 


@section('title_page', 'About Us')

@section('content')
<section id="about" class="max-w-4xl mx-auto py-20 bg-gray-50" data-aos="fade-up">
    <h1 class="text-4xl font-bold text-center mb-12 text-indigo-600" data-aos="fade-up">About Us</h1>
    
    <!-- Card container -->
    <div class="bg-white rounded-lg shadow-xl overflow-hidden" data-aos="fade-up" data-aos-delay="200">
        <img src="https://images.alphacoders.com/135/thumbbig-1359819.webp" alt="Our Team" class="w-full h-64 object-cover">
        
        <div class="p-8">
            <p class="text-gray-600 mb-4 text-lg leading-relaxed">
                Halo, nama saya <span class="text-indigo-600 font-bold">{{ $nama }}</span>. Saya berumur
                <span class="text-indigo-600 font-bold">{{ $umur }}</span> tahun, dan saat ini bekerja sebagai
                <span class="text-indigo-600 font-bold">{{ $pekerjaan }}</span>.
            </p>
            <p class="text-gray-600 text-lg leading-relaxed mb-6">
                Selamat datang di blog kami! Kami adalah tim yang bersemangat untuk berbagi pengetahuan dan informasi.
            </p>

            <!-- Social media icons -->
            <div class="flex justify-center space-x-6 mt-8">
                <a href="https://facebook.com" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-3xl" data-aos="fade-up" data-aos-delay="300">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://twitter.com" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-3xl" data-aos="fade-up" data-aos-delay="400">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://instagram.com" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-3xl" data-aos="fade-up" data-aos-delay="500">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection
