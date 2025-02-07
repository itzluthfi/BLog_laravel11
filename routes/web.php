<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;




Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);


Route::get('/', function () {
    return view('home');
});


Route::get('/about', function () {
    return view('about', [
        'nama' => 'Sir L',
        'umur' => 20,
        'pekerjaan' => 'Mahasiswa IT'

    ]);
});



Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');


Route::get('/contact', function () {
    return view('contact');
});





// Halaman setelah login (Protected Route)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');



    Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blog.detail');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/dashboardUser', function () {
        return view('home');
    })->name('dashboard.user');
    
    Route::get('/profil', function () {
        return view('profile.index');
    })->name('profil');
    
    Route::get('/artikel', function () {
        return view('profile.artikelSaya');
    })->name('artikel');
    
    Route::get('/disukai', function () {
        return view('profile.artikelDisukai');
    })->name('disukai');
    
    Route::get('/pengaturan', function () {
        return view('profile.pengaturan');
    })->name('pengaturan');
});