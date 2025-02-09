<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;

// Public Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about', [
        'nama' => 'Sir L',
        'umur' => 20,
        'pekerjaan' => 'Mahasiswa IT'
    ]);
})->name('about');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {
    Route::resource('blog', BlogController::class)->except(['index']);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

   
    
    Route::get('/artikel-saya', [BlogController::class, 'myArticles'])->name('artikel');
    
    Route::get('/disukai', function () {
        return view('profile.artikelDisukai');
    })->name('disukai');
    
    Route::get('/pengaturan', function () {
        return view('profile.pengaturan');
    })->name('pengaturan');
});