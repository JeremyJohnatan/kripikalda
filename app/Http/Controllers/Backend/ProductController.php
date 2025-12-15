<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');

        $products = Product::when($kategori, function ($query) use ($kategori) {
            return $query->where('item_produk', $kategori);
        })->get();

        return view('backend.product.index', compact('products', 'kategori'));
    }


    public function create()
    {
        return view('backend.product.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'nama_produk'  => 'required|string',
                'berat'        => 'required|numeric',
                'harga'        => 'required|numeric',
                'stok'         => 'required|integer',
                'kategori'     => 'nullable',
                'gambar'       => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf'
            ]);

            $storedPath = null;
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                $filename = Str::slug($validated['nama_produk']) . '_' . now()->timestamp;
                $ext = $file->getClientOriginalExtension();

                $storedPath = $file->storeAs(
                    "products/gambar_produk",
                    "{$filename}.{$ext}",
                    "public"
                );
            }

            Product::create([
                'nama_produk' => $validated['nama_produk'],
                'deskripsi'   => $validated['berat'],
                'harga'       => $validated['harga'],
                'stok'        => $validated['stok'],
                'item_produk' => $validated['kategori'],
                'gambar'      => $storedPath,
            ]);

            DB::commit();

            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.');

        } catch (\Throwable $e) {

            DB::rollBack();
            \Log::error('Product error: '.$e->getMessage());

            return redirect()
                ->route('product.index')
                ->with('error', 'Gagal membuat produk');
        }
    }

    public function edit($id)
    {
        $product = Product::where('id_produk', $id)->firstOrFail();
        return view('backend.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {

        $product = Product::where('id_produk', $id)->firstOrFail();

        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'nama_produk'  => 'required|string',
                'berat'        => 'required|numeric',
                'harga'        => 'required|numeric',
                'stok'         => 'required|integer',
                'kategori'     => 'nullable|string',
                'gambar'       => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf'
            ]);

            if ($request->hasFile('gambar')) {

                if (!empty($product->gambar) && Storage::disk('public')->exists($product->gambar)) {
                    Storage::disk('public')->delete($product->gambar);
                }

                $file = $request->file('gambar');
                $filename = Str::slug($validated['nama_produk']) . '_' . now()->timestamp;
                $ext = $file->getClientOriginalExtension();

                $storedPath = $file->storeAs(
                    "products/gambar_produk",
                    "{$filename}.{$ext}",
                    "public"
                );

                $product->gambar = $storedPath;
            }

            $product->nama_produk = $validated['nama_produk'];
            $product->deskripsi   = $validated['berat'];
            $product->harga       = $validated['harga'];
            $product->stok        = $validated['stok'];
            $product->item_produk = $validated['kategori'];

            $product->save();

            DB::commit();

            return redirect()
                ->route('product.index')
                ->with('success', 'Produk berhasil diupdate.');

        } catch (\Throwable $e) {

            DB::rollBack();
            \Log::error('Product error: '.$e->getMessage());

            return redirect()
                ->route('product.index')
                ->with('error', 'Gagal mengupdate produk');
        }
    }

    public function massDelete(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Tidak ada produk yang dipilih untuk dihapus.');
        }

        Product::whereIn('id_produk', $ids)->delete();

        return redirect()->back()->with('success', 'Produk yang dipilih berhasil dihapus!');
    }
}
