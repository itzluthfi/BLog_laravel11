<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
    <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <form action="{{ route('register') }}" method="POST" class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            @csrf  <!-- CSRF Protection -->
            <div>
                <img src="https://storage.googleapis.com/devitary-image-host.appspot.com/15846435184459982716-LogoMakr_7POjrN.png"
                    class="w-32 mx-auto" />
            </div>
            <div class="mt-12 flex flex-col items-center">
                <h1 class="text-2xl xl:text-3xl font-extrabold">
                    Registrasi
                </h1>
                <div class="w-full flex-1 mt-8">
                    <div class="my-12 border-b text-center">
                        <div class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                            Registrasi dengan Email
                        </div>
                    </div>

                    <div class="mx-auto max-w-xs">
                        <!-- Pesan error -->
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5">
                                <strong>Error:</strong> Periksa kembali input Anda.
                                <ul class="mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>- {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Input Username -->
                        <input 
                            name="username"
                            type="text" 
                            placeholder="Username"
                            class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mb-4"
                            value="{{ old('username') }}" required
                        />

                        <!-- Input Email -->
                        <input 
                            name="email"
                            type="email" 
                            placeholder="Email"
                            class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mb-4"
                            value="{{ old('email') }}" required
                        />

                        <!-- Input Password -->
                        <input 
                            name="password"
                            type="password"
                            placeholder="Password"
                            class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mb-4"
                            required
                        />

                        <!-- Input Password Confirmation -->
                        <input 
                            name="password_confirmation"
                            type="password"
                            placeholder="Konfirmasi Password"
                            class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mb-4"
                            required
                        />

                        <!-- Tombol Register -->
                        <button 
                            type="submit"
                            class="mt-5 tracking-wide font-semibold bg-indigo-500 text-gray-100 w-full py-4 rounded-lg hover:bg-indigo-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none"
                        >
                            <span class="ml-3">
                                Daftar
                            </span>
                        </button>

                        <!-- Link ke halaman Login -->
                        <p class="mt-4 text-sm text-center text-gray-600">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-indigo-500 hover:underline">Login di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="flex-1 bg-indigo-100 text-center hidden lg:flex">
            <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat" 
                 style="background-image: url('https://storage.googleapis.com/devitary-image-host.appspot.com/15848031292911696601-undraw_designer_life_w96d.svg');">
            </div>
        </div>
    </div>
</div>
</body>
</html>
