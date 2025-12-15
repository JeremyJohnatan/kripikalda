<?php
use App\Http\Controllers\frontend\TransaksiController;
use App\Http\Controllers\frontend\KeranjangController;
use App\Http\Controllers\frontend\WelcomeController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\GeminiController;
use App\Http\Controllers\Backend\PesananController;
use App\Http\Controllers\Backend\UserController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/cetak/pdf', [DashboardController::class, 'cetakPdf'])->name('dashboard.cetak.pdf');

    Route::get('/get-insight', [GeminiController::class, 'getInsight'])->name('get.insight');

    Route::delete('/product/mass-delete', [ProductController::class, 'massDelete'])->name('product.massDelete');
    Route::resource('product', ProductController::class)->names('product');

    Route::resource('pesanan', PesananController::class)->names('pesanan');
    Route::patch('/pesanan/{id}/status-pengiriman', [PesananController::class, 'updateStatusPengiriman'])->name('pesanan.update-status-pengiriman');
    Route::get('/pesanan/cetak/pdf', [PesananController::class, 'cetakPdf'])->name('pesanan.cetak.pdf');

    Route::resource('user', UserController::class)->only(['index', 'destroy']);
});

Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/welcome-page', [WelcomeController::class, 'index'])->name('welcome-page');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/add/{id}', [KeranjangController::class, 'add'])->name('keranjang.add');
    Route::delete('/keranjang/hapus',   [KeranjangController::class, 'deleteAll'])->name('keranjang.delete');
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'updateQty']);
    Route::delete('/keranjang/delete/{id}', [KeranjangController::class, 'deleteItem']);

    Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');
});

require __DIR__.'/auth.php';
