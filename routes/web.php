<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes — HIMA Informatika
|--------------------------------------------------------------------------
*/

// Theme Toggle (session-based, no JS required)
Route::post('/theme/toggle', function () {
    $current = session('theme', 'dark');
    session(['theme' => $current === 'dark' ? 'light' : 'dark']);
    return back();
})->name('theme.toggle');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/visi-misi', [HomeController::class, 'visiMisi'])->name('visi-misi');
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/{kegiatan:slug}', [KegiatanController::class, 'show'])->name('kegiatan.show');
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
Route::get('/marketplace/{produk:slug}', [MarketplaceController::class, 'show'])->name('marketplace.show');
Route::post('/marketplace/cart/add', [MarketplaceController::class, 'addToCart'])->name('cart.add');
Route::post('/marketplace/cart/remove', [MarketplaceController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/marketplace/cart/checkout', [MarketplaceController::class, 'checkout'])->name('cart.checkout');
Route::get('/struktur', [StrukturController::class, 'index'])->name('struktur.index');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Settings (sosmed, info)
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'saveSettings'])->name('settings.save');

        // Kegiatan CRUD
        Route::resource('kegiatan', KegiatanController::class)->except(['index', 'show']);

        // Marketplace CRUD
        Route::resource('produk', MarketplaceController::class)->except(['index', 'show']);

        // Galeri CRUD
        Route::resource('galeri', GaleriController::class)->except(['index']);

        // Struktur CRUD
        Route::resource('struktur', StrukturController::class)->except(['index']);

        // Pengumuman CRUD
        Route::resource('pengumuman', PengumumanController::class)->except(['index', 'show']);
    });
});
