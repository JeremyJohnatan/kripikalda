@extends('layouts.app')

@section('content')
<div class="ml-1 mb-4">
    <h1 class="fw-bold">Promo</h1>
</div>

<div class="d-flex flex-wrap card shadow-sm px-4" style="border-radius: 35px;">
    <div class="m-0 ms-2 me-4">
        <div class="d-flex justify-content-end">
            <a href="{{ route('promo.create') }}" class="btn-success d-flex align-items-center p-2 gap-2">
                <img src="{{ asset('assets\img\icons\mdi_box-plus.svg') }}" alt="">  Tambah Promo
            </a>
        </div>
    </div>

    <div class="sub-title mt-0">
        <h2>Promo</h2>
    </div>

    <div class="table mt-4">
        <table class="table mb-4">
            <thead class="border-top border-bottom border-dark">
                <tr>
                    <th class="fw-semibold py-1 text-start">Kode Promo</th>
                    <th class="fw-semibold py-1 text-start">Nama Promo</th>
                    <th class="fw-semibold py-1 text-center">Tipe</th>
                    <th class="fw-semibold py-1 text-center">Nilai</th>
                    <th class="fw-semibold py-1 text-center">Minimal Belanja</th>
                    <th class="fw-semibold py-1 text-center">Periode</th>
                    <th class="fw-semibold py-1 text-center">Status</th>
                    <th class="fw-semibold py-1 text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($promos as $promo)
                <tr>
                    <td class="fw-semibold text-start">{{ $promo->kode_promo }}</td>
                    <td class="text-start">{{ $promo->nama_promo }}</td>

                    <td class="text-center">
                        <span class="badge {{ $promo->tipe === 'persen' ? 'bg-info' : 'bg-warning' }}">
                            {{ ucfirst($promo->tipe) }}
                        </span>
                    </td>

                    <td class="text-center">
                        @if ($promo->tipe === 'persen')
                            {{ $promo->nilai }}%
                            @if($promo->maksimal_diskon)
                                <br>
                                <small class="text-muted">
                                    Max Rp {{ number_format($promo->maksimal_diskon, 0, ',', '.') }}
                                </small>
                            @endif
                        @else
                            Rp {{ number_format($promo->nilai, 0, ',', '.') }}
                        @endif
                    </td>

                    <td class="text-center">
                        {{ $promo->minimal_belanja
                            ? 'Rp ' . number_format($promo->minimal_belanja, 0, ',', '.')
                            : '-' }}
                    </td>

                    <td class="text-center">
                        {{ $promo->mulai->format('d M Y') }} <br>
                        <small class="text-muted">s/d</small><br>
                        {{ $promo->berakhir->format('d M Y') }}
                    </td>

                    <td class="text-center">
                        <span class="badge {{ $promo->status ? 'bg-success' : 'bg-secondary' }}">
                            {{ $promo->status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>

                    <td class="text-end">
                        <a href="{{ route('promo.edit', $promo->id) }}" class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('promo.destroy', $promo->id) }}"
                            method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin hapus promo?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
