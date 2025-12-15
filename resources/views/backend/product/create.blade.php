@extends('layouts.app')

@section('content')
<div class="content">

    <div class="mb-4">
        <h1 class="fw-bold">Tambah Produk</h1>
    </div>

    <div class="card shadow-sm p-4 rounded-4">
        <h3 class="fw-semibold mb-3">Data Produk</h3>
        <hr>

        <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label for="nama_produk" class="form-label fw-semibold">Nama Produk</label>
                    <input type="text" class="form-control rounded-3" id="nama_produk" name="nama_produk" required>
                </div>

                <div class="col-md-6">
                    <label for="berat" class="form-label fw-semibold">Berat (gram)</label>
                    <input type="number" class="form-control rounded-3" id="berat" name="berat" placeholder="Contoh: 1000" required>
                </div>

                <div class="col-md-6">
                    <label for="harga" class="form-label fw-semibold">Harga</label>
                    <input type="number" class="form-control rounded-3" id="harga" name="harga" required>
                </div>

                <div class="col-md-6">
                    <label for="stok" class="form-label fw-semibold">Stok</label>
                    <input type="number" min="0" class="form-control rounded-3" id="stok" name="stok" required>
                </div>

                <div class="col-md-6">
                    <label for="kategori" class="form-label fw-semibold">Kategori</label>

                    <select name="kategori" id="kategori"
                        class="form-control rounded-3 shadow-sm border-1 @error('kategori') is-invalid @enderror">

                        <option value="" {{ old('kategori') == '' ? 'selected' : '' }}>Tidak ada</option>
                        <option value="Original" {{ old('kategori') == 'Original' ? 'selected' : '' }}>Original</option>
                        <option value="BBQ" {{ old('kategori') == 'BBQ' ? 'selected' : '' }}>BBQ</option>
                        <option value="Pedas" {{ old('kategori') == 'Pedas' ? 'selected' : '' }}>Pedas</option>
                        <option value="Ayam Panggang" {{ old('kategori') == 'Ayam Panggang' ? 'selected' : '' }}>Ayam Panggang</option>
                        <option value="Balado" {{ old('kategori') == 'Balado' ? 'selected' : '' }}>Balado</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="gambar" class="form-label fw-semibold">Gambar Produk</label>
                    <input type="file" class="form-control rounded-3" id="gambar" name="gambar"
                            accept=".jpg,.jpeg,.png,.webp,.gif,.pdf,.doc,.docx"
                            class="form-control @error('homebase') is-invalid @enderror">
                </div>

            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn px-4 py-2 rounded-3">
                    Tambah Produk
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
        $('#kategori').select2({
            theme: 'bootstrap-5',
            placeholder: "Pilih kategori",
            allowClear: true
        });
    });
</script>
@endpush
