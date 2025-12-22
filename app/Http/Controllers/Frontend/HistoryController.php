<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $histories = Transaksi::where('id_user', $user->id)
            // Mengambil data detail produk sekaligus (Eager Loading)
            ->with(['detail.produk']) 
            ->orderBy('created_at', 'desc')
            ->get();

        // Pastikan file view ini ada di: resources/views/frontend/history/index.blade.php
        return view('frontend.history.index', compact('histories'));
    }

    public function sendEmail($id)
    {
        // 1. Cari data transaksi (pastikan 'id_transaksi' sesuai kolom di DB)
        $transaksi = Transaksi::with(['user', 'detail.produk'])
            ->where('id_transaksi', $id) 
            ->where('id_user', auth()->id())
            ->firstOrFail();

        try {
            // 2. Cek validasi email user
            if (!$transaksi->user || !$transaksi->user->email) {
                // Debugging: Akan mati di sini jika email kosong
                dd("Email user kosong atau user tidak ditemukan");
            }

            // 3. Proses Kirim Email
            Mail::to($transaksi->user->email)->send(new InvoiceMail($transaksi));
            
            // 4. Jika sukses, kembali dengan pesan sukses
            return back()->with('success', 'Invoice berhasil dikirim ke email Anda.');

        } catch (\Exception $e) {
            // 5. TAMPILKAN ERROR DI LAYAR (Debugging)
            // Jika layar putih dengan tulisan hitam muncul, copy pesan itu ke saya.
            dd($e->getMessage()); 
        }
    }
}