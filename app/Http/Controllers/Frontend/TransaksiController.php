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
        $keranjang = Keranjang::where('id_user', $userId)->with('produk')->get();

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        $total = 0;
        foreach ($keranjang as $item) {
            $total += $item->produk->harga * $item->jumlah;
        }

        $transaksi = Transaksi::create([
            'id_user' => $userId,
            'total' => $total,
            'tanggal' => now(),
            'status_pembayaran' => 'Lunas',
            'status_pengiriman' => 'Belum Dikirim',
            'alamat' => $request->alamat,
            'note' => $request->note
        ]);

        foreach ($keranjang as $item) {
            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_produk' => $item->id_produk,
                'jumlah' => $item->jumlah,
                'subtotal' => $item->produk->harga
            ]);
        }

        Keranjang::where('id_user', $userId)->delete();

        return redirect()->route('keranjang')->with('success', 'Pembayaran berhasil!');
    }
}
