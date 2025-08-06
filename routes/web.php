<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Models\User;

// ============================
// Public Routes (Hanya untuk Guest)
// ============================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// ============================
// Halaman Utama dan Informasi Umum
// ============================
Route::get('/', [AuthController::class,'beranda'])->name('home');




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





// ============================
// Protected Routes (Hanya untuk User yang sudah Login)
// ============================
Route::middleware('auth')->group(function () {
    
    // ============================
    // Profil dan Manajemen Artikel Pengguna
    // ============================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::resource('blog', BlogController::class)->except(['index']);
        Route::post('/upload-image-content', [BlogController::class, 'storeImageContent'])->name('upload.image.content');
        Route::get('/', [UserController::class, 'dashboard'])->name('dashboard');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::post('/update-password', [UserController::class, 'updatePassword'])->name('updatePassword');
        Route::get('/artikel-saya', [UserController::class, 'myArticles'])->name('artikelSaya');
        Route::get('/disukai', [UserController::class, 'likedArticles'])->name('artikelDisukai');
        Route::get('/setting', [UserController::class, 'setting'])->name('setting');
        Route::put('/setting', [UserController::class, 'updateSetting'])->name('setting.update');
        Route::post('/blog/{blog}/favorite', [BlogController::class, 'favorite'])->name('blog.favorite');
        Route::post('/blog/{blog}/like', [BlogController::class, 'like'])->name('blog.like');
    });


    // Logout User
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ============================
    // Manajemen Favorit
    // ============================
    // Route::post('/blog/{id}/favorite', [BlogController::class, 'favorite'])->name('blog.favorite');

    // ============================
    // Manajemen Komentar
    // ============================
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::post('/{blog}', [CommentController::class, 'store'])->name('store');
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit');
        Route::get('/mycomments', [UserController::class, 'myComments'])->name('index');
        Route::put('/{comment}', [CommentController::class, 'update'])->name('update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
    });
});


// ============================
// Admin Routes (Hanya untuk Admin)
// ============================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ============================
    // Manajemen Pengguna oleh Admin
    // ============================
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::post('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/users/add', [AdminController::class, 'createUser'])->name('users.add');
    Route::post('/user/store', [AdminController::class, 'storeUser'])->name('users.store');

    // ============================
    // Manajemen Komentar
    // ============================
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::post('/{blog}', [CommentController::class, 'store'])->name('store');
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit');
        Route::get('/index', [AdminController::class, 'comments'])->name('index');
        Route::put('/{comment}', [CommentController::class, 'update'])->name('update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
    });

    // ============================
    // Pengaturan Admin
    // ============================
    Route::get('/setting', [AdminController::class, 'setting'])->name('setting'); 
    Route::put('/setting', [AdminController::class, 'updateSetting'])->name('setting.update');
});


// ============================
// Manajemen Kategori oleh Admin
// ============================
Route::prefix('admin/categories')->name('admin.categories.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index'); 
    Route::get('/create', [CategoryController::class, 'create'])->name('create'); 
    Route::post('/', [CategoryController::class, 'store'])->name('store'); 
    Route::get('/{slug}/edit', [CategoryController::class, 'edit'])->name('edit'); 
    Route::put('/{slug}', [CategoryController::class, 'update'])->name('update'); 
    Route::delete('/{slug}', [CategoryController::class, 'destroy'])->name('destroy'); 
});


// ============================
// Manajemen Blog oleh Admin
// ============================
Route::middleware(['auth', 'admin'])->prefix('admin/blogs')->name('admin.blogs.')->group(function () {
    Route::get('/', [AdminController::class, 'blogs'])->name('list');
    Route::get('/create', [AdminController::class, 'createBlog'])->name('create');
    Route::post('/', [AdminController::class, 'storeBlog'])->name('store');
    Route::get('/edit/{slug}', [AdminController::class, 'editBlog'])->name('edit');
    Route::put('/{slug}', [AdminController::class, 'updateBlog'])->name('update');
    Route::delete('/{slug}', [AdminController::class, 'deleteBlog'])->name('destroy');
});