<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SendEmailController;

use App\Http\Controllers\Api\GalleryApiController;
use App\Http\Controllers\MyGalleryController;

Route::get('/gallery', [GalleryApiController::class, 'showGalleryPage'])->name('gallery.index');

/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will be
| assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk halaman beranda
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route untuk LoginRegisterController
Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store')->name('store');

    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/users','users')->name('users');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});

// Route untuk halaman admin dengan middleware auth dan admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin'); // Menampilkan dashboard admin
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create'); // Form untuk menambah pengguna
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store'); // Menyimpan pengguna baru
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit'); // Form untuk mengedit pengguna
    Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update'); // Memperbarui data pengguna

});

// Route resource untuk UserController
Route::get('/users', [UserController::class, 'index'])->name('user.index');

Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit'); // Edit route
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update'); // Update route


Route::resource('gallery', GalleryController::class);
Route::prefix('gallery')->group(function() {
    Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/{id}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/{id}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/{id}/delete', [GalleryController::class, 'delete'])->name('gallery.delete');  // Route delete
});



// Route untuk SendEmailController
Route::get('/send-email', [SendEmailController::class, 'index'])->name('kirim-email');
Route::post('/send-email', [SendEmailController::class, 'store'])->name('post-email');


// Route untuk pengguna biasa dengan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
});

// Route untuk halaman terbatas (restricted) dengan middleware checkage
Route::get('restricted', function() {
    return "Anda berusia lebih dari 18 tahun!";
})->middleware('checkage');

// Route untuk MyGalleryController
Route::get('/mygallery', [MyGalleryController::class, 'index'])->name('mygallery.index');
Route::get('/mygallery/create', [MyGalleryController::class, 'create'])->name('mygallery.create');
Route::post('/mygallery', [MyGalleryController::class, 'store'])->name('mygallery.store');
Route::get('/mygallery/edit/{id}', [MyGalleryController::class, 'edit'])->name('mygallery.edit');
Route::put('/mygallery/{id}', [MyGalleryController::class, 'update'])->name('mygallery.update');
Route::delete('/mygallery/{id}', [MyGalleryController::class, 'destroy'])->name('mygallery.destroy');
