@extends('layouts.app')

@section('content')
<div class="content">

    <div class="mb-4">
        <h1 class="fw-bold">Edit Kategori</h1>
    </div>

    <div class="card shadow-sm p-4 rounded-4">
        <h3 class="fw-semibold mb-3">Data Kategori</h3>
        <hr>

        <form method="POST" action="{{ route('kategori.update', $kategori->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Kategori</label>
                    <input type="text"
                           name="nama_kategori"
                           class="form-control rounded-3"
                           value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                           required>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn px-4 py-2 rounded-3">
                    Update Kategori
                </button>

                <a href="{{ route('kategori.index') }}"
                   class="btn-back px-4 py-2 rounded-3">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
