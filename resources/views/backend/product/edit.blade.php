@extends('layouts.app')

@section('content')
<div class="content">

    <div class="mb-4">
        <h1 class="fw-bold">Edit Produk</h1>
    </div>

    <div class="card shadow-sm p-4 rounded-4">
        <h3 class="fw-semibold mb-3">Data Produk</h3>
        <hr>

        <form method="POST" action="{{ route('product.update', $product->id_produk) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label for="nama_produk" class="form-label fw-semibold">Nama Produk</label>
                    <input type="text" class="form-control rounded-3" id="nama_produk" name="nama_produk"
                    value="{{ old('nama_produk', $product->nama_produk ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="berat" class="form-label fw-semibold">Berat (gram)</label>
                    <input type="number" class="form-control rounded-3" id="berat" name="berat"
                    value="{{ old('berat', $product->deskripsi ?? '') }}" placeholder="Contoh: 1000" required>
                </div>

                <div class="col-md-6">
                    <label for="harga" class="form-label fw-semibold">Harga</label>
                    <input type="number" class="form-control rounded-3" id="harga" name="harga"
                    value="{{ old('harga', $product->harga ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="stok" class="form-label fw-semibold">Stok</label>
                    <input type="number" min="0" class="form-control rounded-3" id="stok" name="stok"
                    value="{{ old('stok', $product->stok ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="kategori_id" class="form-label fw-semibold">Kategori</label>

                    <select name="kategori_id" id="kategori_id"
                        class="form-control rounded-3 shadow-sm border-1
                        @error('kategori_id') is-invalid @enderror" required>

                        <option value="">Pilih Kategori</option>

                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                {{ old('kategori_id', $product->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    @error('kategori_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="gambar" class="form-label fw-semibold">Gambar Produk</label>
                    @if ($product->gambar)
                        <div class="mb-1">
                            <a href="{{ Storage::url($product->gambar) }}" target="_blank" style="color: blue;">Lihat file saat ini</a>
                        </div>
                    @endif
                    <input type="file" class="form-control rounded-3" id="gambar" name="gambar"
                            accept=".jpg,.jpeg,.png,.webp,.gif,.pdf,.doc,.docx"
                            class="form-control @error('homebase') is-invalid @enderror">
                </div>

            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn px-4 py-2 rounded-3">
                    Edit Produk
                </button>

                <a href="{{ route('product.index') }}" class="btn-back px-4 py-2 rounded-3">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#kategori_id').select2({
            theme: 'bootstrap-5',
            placeholder: "Pilih kategori",
            allowClear: true
        });
    });
</script>
@endpush