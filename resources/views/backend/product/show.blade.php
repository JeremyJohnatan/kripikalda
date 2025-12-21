@extends('layouts.app')

@section('content')
<div class="mb-4">
    <h1 class="fw-bold">Detail Produk</h1>
</div>

<div class="card shadow-sm p-4 rounded-4">
    <div class="row g-4">

        <div class="col-md-4">
            @php
                $gambar = $product->gambar;
                $src = $gambar
                    ? asset('storage/'.$gambar)
                    : 'https://placehold.co/300x400?text=No+Image';
            @endphp

            <img src="{{ $src }}"
                 class="img-fluid rounded"
                 style="object-fit: cover">
        </div>

        <div class="col-md-8">
            <h3 class="fw-bold">{{ $product->nama_produk }}</h3>

            <p class="text-muted mb-1">
                Kategori: <strong>{{ $product->kategori->nama_kategori ?? '-' }}</strong>
            </p>

            <p class="mb-1">
                Berat:
                <strong>
                    @if($product->deskripsi < 1000)
                        {{ $product->deskripsi }} Gram
                    @else
                        {{ number_format($product->deskripsi / 1000, 2, ',', '.') }} KG
                    @endif
                </strong>
            </p>

            <p class="mb-1">
                Stok: <strong>{{ $product->stok }}</strong>
            </p>

            <h4 class="fw-bold text-success mt-3">
                Rp {{ number_format($product->harga, 0, ',', '.') }}
            </h4>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('product.edit', $product->id_produk) }}"
                   class="btn btn-dark">
                    Edit Produk
                </a>

                <a href="{{ route('product.index') }}"
                   class="btn btn-outline-secondary">
                    Kembali
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
