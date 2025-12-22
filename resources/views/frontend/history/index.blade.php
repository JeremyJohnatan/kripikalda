@extends('layouts.app')

@section('content')
<div class="ml-1 mb-4">
    <h1 class="fw-bold">Riwayat Pembelian</h1>
</div>

<div class="d-flex flex-wrap card shadow-sm px-4" style="border-radius: 35px;">
    <div class="sub-title mt-4">
        <h2>Riwayat Pembelian</h2>
    </div>

    {{-- BAGIAN ALERT / PESAN SUKSES & GAGAL --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    {{-- END BAGIAN ALERT --}}

    <div class="table-responsive mt-4">
        <table class="table mb-4">
            <thead class="border-top border-bottom border-dark">
                <tr>
                    <th class="fw-semibold py-1 text-start">Tanggal Pesanan</th>
                    <th class="fw-semibold py-1 text-center">Alamat</th>
                    <th class="fw-semibold py-1 text-center">Pembayaran</th>
                    <th class="fw-semibold py-1 text-center">Pengiriman</th>
                    <th class="fw-semibold py-1 text-center">Total</th>
                    <th class="fw-semibold py-1 text-end">Detail</th>
                </tr>
            </thead>

            <tbody>
                @foreach($histories as $t)
                <tr>
                    <td class="fw-semibold py-1 text-start">{{ $t->created_at->translatedFormat('d F Y') }}</td>
                    <td class="fw-semibold py-1 text-center">{{ $t->alamat }}</td>
                    <td class="fw-semibold py-1 text-center">{{ $t->status_pembayaran }}</td>
                    <td class="fw-semibold py-1 text-center">{{ $t->status_pengiriman }}</td>
                    <td class="fw-semibold py-1 text-center">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td class="fw-semibold py-1 text-end">
                        <button class="btn btn-sm btn-success-subtle text-success fw-bold"
                            data-bs-toggle="modal"
                            data-bs-target="#detailModal-{{ $t->id_transaksi }}">
                            Detail Pesanan
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL DITARUH DI LUAR CARD UTAMA AGAR TIDAK TERTUTUP BACKDROP --}}
@foreach($histories as $t)
<div class="modal fade" id="detailModal-{{ $t->id_transaksi }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    Detail Pesanan #{{ $t->external_id ?? $t->id_transaksi }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <p class="mb-1"><strong>Tanggal:</strong> {{ $t->created_at->translatedFormat('d F Y H:i') }}</p>
                    <p class="mb-1"><strong>Alamat:</strong> {{ $t->alamat }}</p>
                    <p class="mb-1"><strong>Status Pembayaran:</strong> 
                        <span class="badge bg-secondary">{{ $t->status_pembayaran }}</span>
                    </p>
                    <p class="mb-1"><strong>Status Pengiriman:</strong> 
                        <span class="badge bg-info text-dark">{{ $t->status_pengiriman }}</span>
                    </p>
                </div>

                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($t->detail as $d)
                        <tr>
                            {{-- Perhatikan: $d->produk (sesuai controller detail.produk) --}}
                            <td>{{ $d->produk->nama_produk ?? 'Produk dihapus' }}</td>
                            <td>Rp {{ number_format($d->produk->harga ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $d->jumlah }}</td>
                            <td class="text-end">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <strong>Rp {{ number_format($t->subtotal ?? $t->total, 0, ',', '.') }}</strong>
                    </div>
                    @if($t->diskon > 0)
                    <div class="d-flex justify-content-between text-success">
                        <span>Diskon ({{ $t->kode_promo }})</span>
                        <strong>- Rp {{ number_format($t->diskon, 0, ',', '.') }}</strong>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fs-5">
                        <strong>Total Pembayaran</strong>
                        <strong>Rp {{ number_format($t->total, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 justify-content-between">
                {{-- TOMBOL KIRIM EMAIL (FORM POST) --}}
                <form action="{{ route('riwayat.send-email', $t->id_transaksi) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-envelope me-1"></i> Kirim Invoice ke Email
                    </button>
                </form>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection