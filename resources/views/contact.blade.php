@extends('components.layout') 

@section('title_page', 'Contact Page')

@section('content')
<section id="contact" class="max-w-4xl mx-auto py-20 bg-gray-50" data-aos="fade-up">
    <h1 class="text-4xl font-bold text-center mb-12 text-indigo-600" data-aos="fade-up">Contact Us</h1>
    
    <div class="bg-white rounded-lg shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
        <div class="p-8">
            <form id="contactForm" action="#" method="GET">
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" id="name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Your name" required>
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Your email" required>
                </div>
                <div class="mb-6">
                    <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message</label>
                    <textarea id="message" rows="4"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Your message" required></textarea>
                </div>

                <!-- Tombol Kirim -->
                <div class="flex items-center justify-between">
                    <button type="button"
                        id="sendMessageBtn"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Script untuk mengirim pesan ke WhatsApp
    document.getElementById('sendMessageBtn').addEventListener('click', function() {
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var message = document.getElementById('message').value;

        var whatsappMessage = `Halo, saya ${name} (${email}). Berikut pesan saya: ${message}`;
        var encodedMessage = encodeURIComponent(whatsappMessage);
        var whatsappLink = `https://wa.me/6289507370805?text=${encodedMessage}`;
        window.open(whatsappLink, '_blank');

    });
</script>
@endsection
