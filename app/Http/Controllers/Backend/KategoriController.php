<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
{
    $kategoris = Kategori::withSum('products as total_stok', 'stok')
        ->latest()
        ->get();

    return view('backend.kategori.index', compact('kategoris'));
}


    public function create()
    {
        return view('backend.kategori.create');
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
        'deskripsi'     => 'nullable|string',
    ]);

    Kategori::create($validated);

    return redirect()
        ->route('kategori.index')
        ->with('success', 'Kategori berhasil ditambahkan');
}
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('backend.kategori.edit', compact('kategori'));
    }

public function update(Request $request, $id)
{
    $kategori = Kategori::findOrFail($id);

    $validated = $request->validate([
        'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $kategori->id,
        'deskripsi'     => 'nullable|string',
    ]);

    $kategori->update($validated);

    return redirect()
        ->route('kategori.index')
        ->with('success', 'Kategori berhasil diperbarui');
}
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->products()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Kategori masih digunakan oleh produk');
        }

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
