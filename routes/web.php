<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProfilController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/katalog', [ProductController::class, 'index'])->name('katalog');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/produk/{product}/ulasan', [ReviewController::class, 'store'])->name('review.store');
Route::get('/profil', [ProfileController::class, 'index'])->name('profile');

// Helper login (local only)
Route::get('/__screenshot-login', function (\Illuminate\Http\Request $request) {
    abort_unless(app()->environment('local'), 404);
    $user = \App\Models\User::query()->first();
    abort_unless($user, 404);
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect($request->query('to', route('admin.dashboard')));
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Produk
        Route::resource('produk', AdminProductController::class);
        Route::delete('/produk-image/{image}', [AdminProductController::class, 'destroyImage'])->name('produk.image.destroy');

        // Kategori
        Route::resource('kategori', AdminCategoryController::class);

        // Ulasan
        Route::get('/ulasan', [AdminReviewController::class, 'index'])->name('ulasan.index');
        Route::patch('/ulasan/{ulasan}/approve', [AdminReviewController::class, 'approve'])->name('ulasan.approve');
        Route::patch('/ulasan/{ulasan}/reject', [AdminReviewController::class, 'reject'])->name('ulasan.reject');
        Route::delete('/ulasan/{ulasan}', [AdminReviewController::class, 'destroy'])->name('ulasan.destroy');

        // Banner
        Route::resource('banner', BannerController::class);
        Route::get('/profil',                 [ProfilController::class, 'index'])->name('profil.index');
Route::put('/profil/info',            [ProfilController::class, 'updateInfo'])->name('profil.update-info');
Route::put('/profil/password',        [ProfilController::class, 'updatePassword'])->name('profil.update-password');
Route::post('/profil/admin',          [ProfilController::class, 'storeAdmin'])->name('profil.store-admin');
Route::delete('/profil/admin/{user}', [ProfilController::class, 'destroyAdmin'])->name('profil.destroy-admin');
    });
});
