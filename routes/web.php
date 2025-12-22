<?php

use App\Http\Controllers\frontend\TransaksiController;
use App\Http\Controllers\frontend\KeranjangController;
use App\Http\Controllers\frontend\WelcomeController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Backend\KategoriController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\GeminiController;
use App\Http\Controllers\Backend\PesananController;
use App\Http\Controllers\Backend\PromoController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\HistoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome-page');

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/cetak/pdf', [DashboardController::class, 'cetakPdf'])->name('dashboard.cetak.pdf');

    Route::get('/get-insight', [GeminiController::class, 'getInsight'])->name('get.insight');
    Route::resource('kategori', KategoriController::class);

    Route::delete('/product/mass-delete', [ProductController::class, 'massDelete'])->name('product.massDelete');
    Route::resource('product', ProductController::class)->names('product');

    Route::resource('pesanan', PesananController::class)->names('pesanan');
    Route::patch('/pesanan/{id}/status-pengiriman', [PesananController::class, 'updateStatusPengiriman'])->name('pesanan.update-status-pengiriman');
    Route::get('/pesanan/cetak/pdf', [PesananController::class, 'cetakPdf'])->name('pesanan.cetak.pdf');

    Route::resource('user', UserController::class)->only(['index', 'destroy']);

    Route::resource('promo', PromoController::class)->names('promo');
});

// --- CUSTOMER ROUTES ---
Route::middleware(['auth', 'customer'])->group(function () {

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/add/{id}', [KeranjangController::class, 'add'])->name('keranjang.add');
    Route::delete('/keranjang/hapus',   [KeranjangController::class, 'deleteAll'])->name('keranjang.delete');
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'updateQty']);
    Route::delete('/keranjang/delete/{id}', [KeranjangController::class, 'deleteItem']);
    Route::post('/keranjang/apply-promo', [KeranjangController::class, 'applyPromo'])->name('keranjang.apply-promo');

    Route::post('/checkout', [TransaksiController::class, 'checkout'])->name('checkout');

    Route::post('/riwayat/{id}/send-email', [HistoryController::class, 'sendEmail'])->name('riwayat.send-email');
    Route::resource('history', HistoryController::class)->names('history');
    
    // Route manual untuk riwayat transaksi (Duplikasi nama ini yang menjaga layout kamu tetap jalan)
    Route::get('/riwayat-transaksi', [HistoryController::class, 'index'])->name('riwayat.transaksi');
    Route::get('/riwayat-transaksi', [HistoryController::class, 'index'])->name('history.index');
});

Route::post('/otp/send', [OtpController::class, 'send'])->name('otp.send');
Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify');

require __DIR__.'/auth.php';