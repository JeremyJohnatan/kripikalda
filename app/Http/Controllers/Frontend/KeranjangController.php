<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $kategori = $request->query('kategori');
        $cari = $request->query('cari');

        $products = Product::when($kategori, function ($query) use ($kategori) {
                return $query->where('item_produk', $kategori);
            })
            ->when($cari, function ($query) use ($cari) {
                return $query->where('nama_produk', 'like', '%' . $cari . '%');
            })
            ->get();

        $keranjang = Keranjang::where('id_user', $user->id)->with('produk')->get();

        return view('keranjang.index', compact('user', 'products', 'kategori', 'keranjang', 'cari'));
    }

    public function deleteAll()
    {
        $userId = Auth::id();

        Keranjang::where('id_user', $userId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Semua pesanan berhasil dihapus.'
        ]);
    }

    public function add($id_produk)
    {
        $userId = Auth::id();

        $item = Keranjang::where('id_user', $userId)
                        ->where('id_produk', $id_produk)
                        ->first();

        if ($item) {
            $item->jumlah += 1;
            $item->save();
        } else {
            Keranjang::create([
                'id_user' => $userId,
                'id_produk' => $id_produk,
                'jumlah' => 1
            ]);
        }

        $keranjang = Keranjang::where('id_user', $userId)->with('produk')->get();
        $html = view('keranjang.keranjang-list', compact('keranjang'))->render();

        $totalPesanan = 0;
        foreach ($keranjang as $item) {
            $totalPesanan += $item->produk->harga * $item->jumlah;
        }

        return response()->json([
            'status' => 'success',
            'html' => $html,
            'total' => $totalPesanan,
            'potongan' => 0,
            'pembayaran' => $totalPesanan
        ]);
    }

    public function updateQty(Request $request, $id)
    {
        $item = Keranjang::findOrFail($id);

        if ($request->action === 'plus') {
            $item->jumlah += 1;
        } else if ($request->action === 'minus' && $item->jumlah > 1) {
            $item->jumlah -= 1;
        }

        $item->save();

        $keranjang = Keranjang::where('id_user', Auth::id())->with('produk')->get();
        $html = view('keranjang.keranjang-list', compact('keranjang'))->render();

        $totalPesanan = 0;
        foreach ($keranjang as $item) {
            $totalPesanan += $item->produk->harga * $item->jumlah;
        }

        return response()->json([
            'status' => 'success',
            'html' => $html,
            'total' => $totalPesanan,
            'potongan' => 0,
            'pembayaran' => $totalPesanan
        ]);
    }

    public function deleteItem($id)
    {
        Keranjang::find($id)->delete();

        $keranjang = Keranjang::where('id_user', Auth::id())->with('produk')->get();
        $html = view('keranjang.keranjang-list', compact('keranjang'))->render();

        $totalPesanan = 0;
        foreach ($keranjang as $item) {
            $totalPesanan += $item->produk->harga * $item->jumlah;
        }

        return response()->json([
            'status' => 'success',
            'html' => $html,
            'total' => $totalPesanan,
            'potongan' => 0,
            'pembayaran' => $totalPesanan
        ]);
    }
}
