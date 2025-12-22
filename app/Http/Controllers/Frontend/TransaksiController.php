<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail; // <--- TAMBAH INI
use App\Mail\InvoiceMail;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class TransaksiController extends Controller
{
    public function __construct()
    {
        // Pastikan API Key di .env sudah benar: XENDIT_API_KEY=xnd_...
        Configuration::setXenditKey(env('XENDIT_API_KEY'));
    }

    public function callback(Request $request)
    {
        $xenditXCallbackToken = env('XENDIT_CALLBACK_TOKEN');
        $reqHeaders = $request->header('x-callback-token');

        if($xenditXCallbackToken && $xenditXCallbackToken != $reqHeaders){
            return response()->json(['message' => 'Token Salah'], 403);
        }

       $externalId = $request->external_id;
    $status = $request->status;
    
    // Pastikan load relasi 'user' dan 'detail.produk' agar view email bisa baca datanya
    $transaksi = Transaksi::with(['user', 'detail.produk'])->where('external_id', $externalId)->first();

    if ($transaksi) {
        if ($status == 'PAID') {
            $transaksi->update([
                'status_pembayaran' => 'Lunas',
                'status_pengiriman' => 'Dikemas'
            ]);

            // === LOGIKA KIRIM EMAIL OTOMATIS ===
            // Pastikan user punya email valid
            if ($transaksi->user && $transaksi->user->email) {
                try {
                    Mail::to($transaksi->user->email)->send(new InvoiceMail($transaksi));
                } catch (\Exception $e) {
                    // Log error jika email gagal, tapi jangan bikin callback gagal
                    \Log::error('Gagal kirim email invoice: ' . $e->getMessage());
                }
            }

        } else if ($status == 'EXPIRED') {
                $transaksi->update([
                    'status_pembayaran' => 'Kadaluarsa',
                    'status_pengiriman' => 'Batal'
                ]);
            }
        } else {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json(['message' => 'Callback sukses diterima'], 200);
    }
    
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        // 1. Ambil Data Keranjang
        $keranjang = Keranjang::where('id_user', $userId)->with('produk')->get();

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang kosong');
        }

        // 2. Hitung Subtotal
        $subtotal = 0;
        foreach ($keranjang as $item) {
            $subtotal += $item->produk->harga * $item->jumlah;
        }

        // 3. Cek Promo
        $promoSession = session('promo');
        $diskon = 0;
        $kodePromo = null;

        if ($promoSession) {
            $diskon = $promoSession['diskon'];
            $kodePromo = $promoSession['kode'];
        }

        $totalBayar = max(0, $subtotal - $diskon);

        if ($totalBayar <= 0) {
             return back()->with('error', 'Total pembayaran tidak valid.');
        }

        // 4. Buat External ID
        $externalId = 'INV-' . time() . '-' . Str::random(5);

        // 5. Simpan Transaksi (Status: Pending)
        try {
            $transaksi = Transaksi::create([
                'id_user'            => $userId,
                'external_id'        => $externalId,
                'tanggal'            => now(),
                'alamat'             => $request->alamat,
                'status_pembayaran'  => 'Pending', 
                'status_pengiriman'  => 'Belum Dikirim',
                'subtotal'           => $subtotal,
                'diskon'             => $diskon,
                'kode_promo'         => $kodePromo,
                'total'              => $totalBayar,
                'note'               => $request->note
            ]);

            // 6. Simpan Detail
            foreach ($keranjang as $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_produk'    => $item->id_produk,
                    'jumlah'       => $item->jumlah,
                    'subtotal'     => $item->produk->harga * $item->jumlah
                ]);
            }

            // 7. Integrasi Xendit
            $apiInstance = new InvoiceApi();
            $createInvoiceRequest = new CreateInvoiceRequest([
                'external_id'      => $externalId,
                'amount'           => $totalBayar,
                'description'      => 'Pembayaran Pesanan #' . $externalId,
                'invoice_duration' => 86400,
                'customer' => [
                    'given_names' => $user->name,
                    'email'       => $user->email,
                    'mobile_number' => $user->no_hp ?? '-' // Pastikan format HP benar (08xxx)
                ],
                'success_redirect_url' => route('history.index'), // Pastikan route ini ada
                'failure_redirect_url' => route('keranjang')
            ]);

            $result = $apiInstance->createInvoice($createInvoiceRequest);

            // Hapus keranjang HANYA JIKA invoice xendit berhasil dibuat
            Keranjang::where('id_user', $userId)->delete();
            session()->forget('promo');

            // 8. Redirect ke Xendit
            return redirect($result['invoice_url']);

        } catch (\Exception $e) {
            // Jika Error, tampilkan pesan errornya agar ketahuan kenapa balik ke keranjang
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
}