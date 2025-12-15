<?php

namespace App\Http\Controllers\Backend;

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PesananController
{
    public function index()
    {
        $transaksi = Transaksi::with([
                'detail' => function ($q) {
                    $q->select(
                        'id_transaksi',
                        'id_produk',
                        DB::raw('SUM(jumlah) as total_jumlah'),
                        DB::raw('SUM(subtotal) as subtotal')
                    )
                    ->groupBy('id_transaksi', 'id_produk');
                },
                'detail.product'
            ])->get();

        return view('backend.pesanan.index', compact('transaksi'));
    }

    public function updateStatusPengiriman(Request $request, $id)
    {
        $request->validate([
            'status_pengiriman' => 'required|in:Belum Dikirim,Dalam Perjalanan,Telah Diterima',
        ]);

        $pesanan = Transaksi::findOrFail($id);
        $pesanan->status_pengiriman = $request->status_pengiriman;
        $pesanan->save();

        return back()->with('success', 'Status pengiriman berhasil diperbarui');
    }

    public function cetakPdf()
    {
        $transaksi = Transaksi::with([
            'detail' => function ($q) {
                $q->select(
                    'id_transaksi',
                    'id_produk',
                    DB::raw('SUM(jumlah) as total_jumlah'),
                    DB::raw('SUM(subtotal) as subtotal')
                )->groupBy('id_transaksi', 'id_produk');
            },
            'detail.product'
        ])->get();

        $pdf = Pdf::loadView('backend.pesanan.cetak-pdf', compact('transaksi'));
        return $pdf->download('laporan_pesanan.pdf');
    }
}
