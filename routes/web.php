<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;



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
    
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::resource('blog', BlogController::class)->except(['index']);
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

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Manajemen Pengguna
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::post('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/users/add', [AdminController::class, 'createUser'])->name('users.add');
    Route::post('/user/store', [AdminController::class, 'storeUser'])->name('users.store');

    // Manajemen Kategori (dengan nama prefix admin.categories)
    Route::resource('categories', CategoryController::class)->names('categories');
    
    // Menampilkan kategori berdasarkan slug
    Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

    // Pengaturan
    Route::get('/setting', [AdminController::class, 'setting'])->name('setting'); 
    Route::put('/setting', [AdminController::class, 'updateSetting'])->name('setting.update');
});


    Route::middleware(['auth', 'admin'])->prefix('admin/blogs')->name('admin.blogs.')->group(function () {
        Route::get('/', [AdminController::class, 'blogs'])->name('list');
        Route::get('/create', [AdminController::class, 'createBlog'])->name('create');
        Route::post('/', [AdminController::class, 'storeBlog'])->name('store');
        Route::get('/edit/{id}', [AdminController::class, 'editBlog'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'updateBlog'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'deleteBlog'])->name('destroy');
    });
    