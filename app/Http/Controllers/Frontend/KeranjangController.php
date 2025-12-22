<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Keranjang;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController
{
    private function ringkasanKeranjang($userId)
    {
        $keranjang = Keranjang::where('id_user', $userId)
            ->with('produk')
            ->get();

        $total = $keranjang->sum(fn ($item) =>
            $item->produk->harga * $item->jumlah
        );

        $potongan = session('promo.diskon', 0);
        $pembayaran = $total - $potongan;

        return [
            'keranjang' => $keranjang,
            'total' => $total,
            'potongan' => $potongan,
            'pembayaran' => $pembayaran
        ];
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $kategori = $request->query('kategori');
        $cari = $request->query('cari');

        $products = Product::when($kategori, fn ($q) =>
                $q->where('item_produk', $kategori)
            )
            ->when($cari, fn ($q) =>
                $q->where('nama_produk', 'like', "%$cari%")
            )
            ->get();

        $promos = Promo::where('status', true)
            ->where('mulai', '<=', now())
            ->where('berakhir', '>=', now())
            ->get();

        $ringkasan = $this->ringkasanKeranjang($user->id);

        return view('frontend.keranjang.index', [
            'user' => $user,
            'products' => $products,
            'kategori' => $kategori,
            'cari' => $cari,
            'promos' => $promos,
            ...$ringkasan
        ]);
    }

    public function deleteAll()
    {
        Keranjang::where('id_user', Auth::id())->delete();
        session()->forget('promo');

        return response()->json([
            'status' => 'success',
            'message' => 'Semua pesanan berhasil dihapus.'
        ]);
    }

    public function add($id_produk)
    {
        $userId = Auth::id();

        $item = Keranjang::firstOrCreate(
            ['id_user' => $userId, 'id_produk' => $id_produk],
            ['jumlah' => 0]
        );

        $item->increment('jumlah');

        $data = $this->ringkasanKeranjang($userId);

        return response()->json([
            'status' => 'success',
            'html' => view(
                'frontend.keranjang.keranjang-list',
                ['keranjang' => $data['keranjang']]
            )->render(),
            'total' => $data['total'],
            'potongan' => $data['potongan'],
            'pembayaran' => $data['pembayaran']
        ]);
    }

    public function updateQty(Request $request, $id)
    {
        $item = Keranjang::findOrFail($id);

        if ($request->action === 'plus') {
            $item->increment('jumlah');
        } elseif ($request->action === 'minus' && $item->jumlah > 1) {
            $item->decrement('jumlah');
        }

        $data = $this->ringkasanKeranjang(Auth::id());

        return response()->json([
            'status' => 'success',
            'html' => view(
                'frontend.keranjang.keranjang-list',
                ['keranjang' => $data['keranjang']]
            )->render(),
            'total' => $data['total'],
            'potongan' => $data['potongan'],
            'pembayaran' => $data['pembayaran']
        ]);
    }

    public function deleteItem($id)
    {
        Keranjang::where('id_keranjang', $id)
            ->where('id_user', Auth::id())
            ->delete();

        if (Keranjang::where('id_user', Auth::id())->count() === 0) {
            session()->forget('promo');
        }

        $data = $this->ringkasanKeranjang(Auth::id());

        return response()->json([
            'status' => 'success',
            'html' => view(
                'frontend.keranjang.keranjang-list',
                ['keranjang' => $data['keranjang']]
            )->render(),
            'total' => $data['total'],
            'potongan' => $data['potongan'],
            'pembayaran' => $data['pembayaran']
        ]);
    }

    public function applyPromo(Request $request)
    {
        $userId = Auth::id();

        $promo = Promo::where('kode_promo', $request->kode_promo)
            ->where('status', true)
            ->where('mulai', '<=', now())
            ->where('berakhir', '>=', now())
            ->first();

        if (!$promo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Promo tidak valid'
            ]);
        }

        $keranjang = Keranjang::where('id_user', $userId)
            ->with('produk')
            ->get();

        if ($keranjang->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Keranjang masih kosong'
            ]);
        }

        $subtotal = $keranjang->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        if ($promo->minimal_belanja && $subtotal < $promo->minimal_belanja) {
            return response()->json([
                'status' => 'error',
                'message' => 'Minimal belanja Rp ' . number_format($promo->minimal_belanja, 0, ',', '.')
            ]);
        }

        if ($promo->tipe === 'persen') {
            $diskon = ($promo->nilai / 100) * $subtotal;

            if ($promo->maksimal_diskon) {
                $diskon = min($diskon, $promo->maksimal_diskon);
            }
        } else {
            $diskon = $promo->nilai;
        }

        session([
            'promo' => [
                'kode' => $promo->kode_promo,
                'diskon' => $diskon
            ]
        ]);

        $data = $this->ringkasanKeranjang($userId);

        return response()->json([
            'status' => 'success',
            'total' => $data['total'],
            'potongan' => $data['potongan'],
            'pembayaran' => $data['pembayaran']
        ]);
    }
}
