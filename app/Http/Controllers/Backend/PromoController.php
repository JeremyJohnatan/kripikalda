<?php

namespace App\Http\Controllers\Backend;

use App\Models\Promo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PromoController
{
    public function index()
    {
        $promos = Promo::orderBy('created_at', 'desc')->get();
        return view('backend.promo.index', compact('promos'));
    }

    public function create()
    {
        return view('backend.promo.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'kode_promo'        => 'required|string',
                'nama_promo'        => 'required|string',
                'tipe'              => 'required|in:persen,nominal',
                'nilai'             => 'required|numeric|min:0',
                'minimal_belanja'   => 'nullable|numeric|min:0',
                'maksimal_diskon'   => 'nullable|numeric|min:0',
                'mulai'             => 'required|date',
                'berakhir'          => 'required|date|after:mulai',
            ]);

            Promo::create([
                'kode_promo'      => strtoupper($validated['kode_promo']),
                'nama_promo'      => $validated['nama_promo'],
                'tipe'            => $validated['tipe'],
                'nilai'           => $validated['nilai'],
                'minimal_belanja' => $validated['minimal_belanja'],
                'maksimal_diskon' => $validated['maksimal_diskon'],
                'mulai'           => $validated['mulai'],
                'berakhir'        => $validated['berakhir'],
                'status'          => now()->between(
                                        $validated['mulai'],
                                        $validated['berakhir']
                                    ),
            ]);

            DB::commit();

            return redirect()
                ->route('promo.index')
                ->with('success', 'Promo berhasil ditambahkan');

        } catch (\Throwable $e) {

            DB::rollBack();
            \Log::error('Promo error: ' . $e->getMessage());

            return redirect()
                ->route('promo.index')
                ->with('error', 'Gagal menambahkan promo');
        }
    }

     public function edit($id)
    {
        $promo = Promo::where('id', $id)->firstOrFail();
        return view('backend.promo.edit', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'kode_promo'        => 'required|string',
                'nama_promo'        => 'required|string',
                'tipe'              => 'required|in:persen,nominal',
                'nilai'             => 'required|numeric|min:0',
                'minimal_belanja'   => 'nullable|numeric|min:0',
                'maksimal_diskon'   => 'nullable|numeric|min:0',
                'mulai'             => 'required|date',
                'berakhir'          => 'required|date|after:mulai',
            ]);



            $promo->update([
                'kode_promo'      => strtoupper($validated['kode_promo']),
                'nama_promo'      => $validated['nama_promo'],
                'tipe'            => $validated['tipe'],
                'nilai'           => $validated['nilai'],
                'minimal_belanja' => $validated['minimal_belanja'],
                'maksimal_diskon' => $validated['maksimal_diskon'],
                'mulai'           => $validated['mulai'],
                'berakhir'        => $validated['berakhir'],
                'status'          => now()->between(
                                        $validated['mulai'],
                                        $validated['berakhir']
                                    ),
            ]);

            DB::commit();

            return redirect()
                ->route('promo.index')
                ->with('success', 'Promo berhasil diperbarui');

        } catch (\Throwable $e) {

            DB::rollBack();
            \Log::error('Promo update error: ' . $e->getMessage());

            return redirect()
                ->route('promo.index')
                ->with('error', 'Gagal memperbarui promo');
        }
    }

    public function destroy($id)
    {
        $promo = Promo::findOrFail($id);

        try {
            $promo->delete();

            return redirect()
                ->route('promo.index')
                ->with('success', 'Promo berhasil dihapus');

        } catch (\Throwable $e) {
            \Log::error('Promo delete error: ' . $e->getMessage());

            return redirect()
                ->route('promo.index')
                ->with('error', 'Gagal menghapus promo');
        }
    }
}
