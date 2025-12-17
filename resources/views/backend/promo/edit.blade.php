@extends('layouts.app')

@section('content')
<div class="content">

    <div class="mb-4">
        <h1 class="fw-bold">Edit Promo</h1>
    </div>

    <div class="card shadow-sm p-4 rounded-4">
        <h3 class="fw-semibold mb-3">Data Promo</h3>
        <hr>

        <form method="POST" action="{{ route('promo.update', $promo->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kode Promo</label>
                    <input type="text"
                           name="kode_promo"
                           class="form-control rounded-3"
                           value="{{ old('kode_promo', $promo->kode_promo) }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Promo</label>
                    <input type="text"
                           name="nama_promo"
                           class="form-control rounded-3"
                           value="{{ old('nama_promo', $promo->nama_promo) }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipe Diskon</label>
                    <select name="tipe"
                            class="form-control rounded-3"
                            required>
                        <option value="">Pilih Tipe</option>
                        <option value="persen"
                            {{ old('tipe', $promo->tipe) === 'persen' ? 'selected' : '' }}>
                            Persentase (%)
                        </option>
                        <option value="nominal"
                            {{ old('tipe', $promo->tipe) === 'nominal' ? 'selected' : '' }}>
                            Nominal (Rp)
                        </option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nilai Diskon</label>
                    <input type="number"
                           step="0.01"
                           name="nilai"
                           class="form-control rounded-3"
                           value="{{ old('nilai', $promo->nilai) }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Minimal Belanja</label>
                    <input type="number"
                           step="0.01"
                           name="minimal_belanja"
                           class="form-control rounded-3"
                           value="{{ old('minimal_belanja', $promo->minimal_belanja) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Maksimal Diskon</label>
                    <input type="number"
                           step="0.01"
                           name="maksimal_diskon"
                           class="form-control rounded-3"
                           value="{{ old('maksimal_diskon', $promo->maksimal_diskon) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="datetime-local"
                           name="mulai"
                           class="form-control rounded-3"
                           value="{{ old('mulai', $promo->mulai->format('Y-m-d\TH:i')) }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Berakhir</label>
                    <input type="datetime-local"
                           name="berakhir"
                           class="form-control rounded-3"
                           value="{{ old('berakhir', $promo->berakhir->format('Y-m-d\TH:i')) }}"
                           required>
                </div>

            </div>

            <div class="d-flex gap-3 mt-4">
                <button type="submit" class="btn px-4 py-2 rounded-3">
                    Update Promo
                </button>

                <a href="{{ route('promo.index') }}"
                   class="btn-back px-4 py-2 rounded-3">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
