<?php

namespace App\Http\Controllers\Frontend;

use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController
{

    public function checkout(Request $request)
    {
        $userId = Auth::id();

        $keranjang = Keranjang::where('id_user', $userId)
            ->with('produk')
            ->get();

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        $subtotal = 0;
        foreach ($keranjang as $item) {
            $subtotal += $item->produk->harga * $item->jumlah;
        }

        $promoSession = session('promo');

        $diskon = 0;
        $kodePromo = null;

        if ($promoSession) {
            $diskon = $promoSession['diskon'];
            $kodePromo = $promoSession['kode'];
        }

        $totalBayar = max(0, $subtotal - $diskon);

        $transaksi = Transaksi::create([
            'id_user'            => $userId,
            'tanggal'            => now(),
            'alamat'             => $request->alamat,
            'status_pembayaran'  => 'Lunas',
            'status_pengiriman'  => 'Belum Dikirim',
            'subtotal'           => $subtotal,
            'diskon'             => $diskon,
            'kode_promo'         => $kodePromo,
            'total'              => $totalBayar,
            'note'               => $request->note
        ]);

        foreach ($keranjang as $item) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_produk'    => $item->id_produk,
                'jumlah'       => $item->jumlah,
                'subtotal'     => $item->produk->harga * $item->jumlah
            ]);
        }

        Keranjang::where('id_user', $userId)->delete();
        session()->forget('promo');

        return redirect()
            ->route('keranjang')
            ->with('success', 'Pembayaran berhasil');
    }

}
