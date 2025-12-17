@extends('layouts.app')

@section('content')
<div class="ml-1 mb-4">
    <h1 class="fw-bold">Riwayat Pembelian</h1>
</div>

<div class="d-flex flex-wrap card shadow-sm px-4" style="border-radius: 35px;">
    <div class="sub-title mt-4">
        <h2>Riwayat Pembelian</h2>
    </div>

    <div class="table mt-4">
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
                    <td class="fw-semibold py-1 text-start">{{ $t->tanggal->translatedFormat('d F Y') }}</td>
                    <td class="fw-semibold py-1 text-center">{{ $t->alamat }}</td>
                    <td class="fw-semibold py-1 text-center">{{ $t->status_pembayaran }}</td>
                    <td class="fw-semibold py-1 text-center">{{ $t->status_pengiriman }}</td>
                    <td class="fw-semibold py-1 text-center">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td class="fw-semibold py-1 text-end">
                        <a href="#" class="btn-success-subtle"
                        data-bs-toggle="modal"
                        data-bs-target="#detailModal-{{ $t->id_transaksi }}">
                        Detail Pesanan {{ $t->id_transaksi }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal detail pesanan -->
        @foreach($histories as $t)
        <div class="modal fade" id="detailModal-{{ $t->id_transaksi }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="background-color: #fff !important;">

                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">
                            Detail Pesanan #{{ $t->id_transaksi }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <p><strong>Tanggal:</strong>
                                {{ $t->tanggal->translatedFormat('d F Y H:i') }}
                            </p>
                            <p><strong>Alamat:</strong> {{ $t->alamat }}</p>
                            <p><strong>Status Pembayaran:</strong> {{ $t->status_pembayaran }}</p>
                            <p><strong>Status Pengiriman:</strong> {{ $t->status_pengiriman }}</p>
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
                                    <td>{{ $d->product->nama_produk }}</td>
                                    <td>Rp {{ number_format($d->product->harga, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $d->jumlah }}</td>
                                    <td class="text-end">
                                        Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">

                            <div class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <strong>Rp {{ number_format($t->subtotal, 0, ',', '.') }}</strong>
                            </div>

                            @if($t->diskon > 0)
                            <div class="d-flex justify-content-between text-success">
                                <span>
                                    Diskon
                                    @if($t->kode_promo)
                                        ({{ $t->kode_promo }})
                                    @endif
                                </span>
                                <strong>- Rp {{ number_format($t->diskon, 0, ',', '.') }}</strong>
                            </div>
                            @endif

                            <hr>

                            <div class="d-flex justify-content-between fs-5">
                                <strong>Total Pembayaran</strong>
                                <strong>
                                    Rp {{ number_format($t->total, 0, ',', '.') }}
                                </strong>
                            </div>
                        </div>

                        <div class="mt-3">
                            <p><strong>Catatan:</strong>
                                {{ $t->note ?? 'Tidak ada catatan' }}
                            </p>
                        </div>

                    </div>

                    <div class="modal-footer border-0">
                        <button class="btn btn-light" data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

@endsection
