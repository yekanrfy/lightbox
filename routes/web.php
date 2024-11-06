<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk halaman beranda
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route untuk LoginRegisterController
Route::controller(LoginRegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
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
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy'); // Menghapus pengguna
});

// Route resource untuk UserController
Route::get('/users', [UserController::class, 'index'])->name('user.index');

// Route untuk pengguna biasa dengan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
});

// Route untuk halaman terbatas (restricted) dengan middleware checkage
Route::get('restricted', function() {
    return "Anda berusia lebih dari 18 tahun!";
})->middleware('checkage');