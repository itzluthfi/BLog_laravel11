<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;



// Public Routes (Hanya untuk guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Halaman Utama dan Umum
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

// Protected Routes (Hanya untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::resource('blog', BlogController::class)->except(['index']);

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::post('/update-password', [UserController::class, 'updatePassword'])->name('updatePassword');
        Route::get('/artikel-saya', [UserController::class, 'myArticles'])->name('artikelSaya');
        Route::get('/disukai', fn() => view('profile.artikelDisukai'))->name('disukai');
        Route::get('/pengaturan', fn() => view('profile.pengaturan'))->name('pengaturan');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::middleware('superadmin')->group(function () {
//     Route::get('/dashboard', [SuperAdminController::class, 'index']);
// });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::post('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/admin/users/add', [AdminController::class, 'createUser'])->name('admin.users.add');
        Route::post('/admin/user/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/setting', [AdminController::class, 'setting'])->name('admin.setting'); 
        Route::put('/setting', [AdminController::class, 'updateSetting'])->name('admin.setting.update');


    });