@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Keranjang -->
    <div class="col-lg-7">

        <!-- Header -->
        <form method="GET" action="{{ route('keranjang') }}">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3 me-2">
                <h2 class="fw-bolder">Halo, {{ $user->name }}</h2>

                <input type="text" name="cari" value="{{ $cari ?? '' }}" class="search" placeholder="Cari...">

                {{-- biar kategori tetap ke-submit kalau sudah difilter --}}
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
            </div>
        </form>

        <!-- Voucher -->
         <div class="d-flex mb-4">
            <img src="{{ asset('assets/img/alda/diskon.png')}}" alt="">
         </div>

         <!-- Category -->
         <div class="d-flex gap-2 mb-4 align-items-center">
            <a href="{{ route('keranjang') }}"
            class="btn-sm btn-success-subtle {{ !$kategori ? 'active' : '' }}">
            Semua
            </a>

            <a href="{{ route('keranjang', ['kategori' => 'Original']) }}"
            class="btn-sm btn-success-subtle {{ $kategori == 'Original' ? 'active' : '' }}">
            Original
            </a>

            <a href="{{ route('keranjang', ['kategori' => 'BBQ']) }}"
            class="btn-sm btn-success-subtle {{ $kategori == 'BBQ' ? 'active' : '' }}">
            BBQ
            </a>

            <a href="{{ route('keranjang', ['kategori' => 'Ayam Panggang']) }}"
            class="btn-sm btn-success-subtle {{ $kategori == 'Ayam Panggang' ? 'active' : '' }}">
            Ayam Panggang
            </a>

            <a href="{{ route('keranjang', ['kategori' => 'Pedas']) }}"
            class="btn-sm btn-success-subtle {{ $kategori == 'Pedas' ? 'active' : '' }}">
            Pedas
            </a>

            <a href="{{ route('keranjang', ['kategori' => 'Balado']) }}"
            class="btn-sm btn-success-subtle {{ $kategori == 'Balado' ? 'active' : '' }}">
            Balado
            </a>
         </div>

         <!-- Product -->
         <div class="row mb-4">
            @foreach($products as $product)
            <div class="col-6 col-md-6 col-lg-4 mb-4 px-2">
                <div class="card shadow-sm p-3 d-flex flex-column align-items-stretch gap-3" style="border-radius: 25px;">
                    @php
                        $gambar = $product->gambar;
                        $isFullUrl = $gambar && Str::startsWith($gambar, ['http://','https://']);
                        $src = $gambar
                            ? ($isFullUrl ? $gambar : asset('storage/'.$gambar))
                            : 'https://placehold.co/80x80?text=No+Image';
                    @endphp
                    <img src="{{ $src }}" alt="Gambar {{ $product->name }}"
                            class="rounded align-self-center"
                            style="width: 84px; height: 126px; object-fit: cover">

                    <div>
                        <small>{{ $product->nama_produk }}</small> <br>
                        <small>
                            @php
                                $berat = $product->deskripsi;

                                if ($berat < 1000) {
                                    echo $berat . ' Gram';
                                } else {
                                    echo number_format($berat / 1000, 2, ',', '.') . ' KG';
                                }
                            @endphp
                        </small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <h4 class="fw-bold fs-5">Rp {{ number_format($product->harga, 0, ',', '.') }} </h4>
                        <button class="btn btn-sm btn-dark add-to-cart" data-id="{{ $product->id_produk }}">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
         </div>

         <!-- Recommendation -->
         <h4 class="mt-4">Rekomendasi Buat Kamu</h4>
         <div class="row mt-2">
            @foreach($products->take(3) as $product)
            <div class="col-12 col-md-6 col-lg-4 mb-4 px-2">
                <div class="card shadow-sm p-3 d-flex flex-column gap-3" style="border-radius: 25px;">
                    @php
                        $gambar = $product->gambar;
                        $isFullUrl = $gambar && Str::startsWith($gambar, ['http://','https://']);
                        $src = $gambar
                            ? ($isFullUrl ? $gambar : asset('storage/'.$gambar))
                            : 'https://placehold.co/80x80?text=No+Image';
                    @endphp
                    <img src="{{ $src }}" alt="Gambar {{ $product->name }}"
                            class="rounded align-self-center"
                            style="width: 84px; height: 126px; object-fit: cover">

                    <div>
                        <small>{{ $product->nama_produk }}</small> <br>
                        <small>
                            @php
                                $berat = $product->deskripsi;

                                if ($berat < 1000) {
                                    echo $berat . ' Gram';
                                } else {
                                    echo number_format($berat / 1000, 2, ',', '.') . ' KG';
                                }
                            @endphp
                        </small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <h4 class="fw-bold fs-5">Rp {{ number_format($product->harga, 0, ',', '.') }} </h4>
                        <a href="" class="btn btn-sm btn-dark">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
         </div>

    </div>

    <!-- Pesanan -->
    <div class="col-lg-5">
        <div class="card shadow-sm d-flex flex-column" style="border-radius: 25px; height: auto;">

            <!-- Action -->
            <div class="d-flex justify-content-end gap-2 m-4">
                <a href="https://wa.me/6285156416448" class="btn btn-success-subtle p-2"><img src="{{ asset('assets\img\icons\message.svg')}}" alt=""></a>
                <a href="" class="btn btn-success-subtle p-2"><img src="{{ asset('assets\img\icons\cart.svg')}}" alt=""></a>
            </div>

            <!-- Header -->
            <div class="row mx-2">
                <div class="d-flex justify-content-between mb-2">
                    <div class="d-flex flex-row sub-title col-7 align-items-center">
                        <img src="{{ asset('assets\img\icons\bookmark.svg') }}" alt="">
                        <h4 class="fw-light">Rincian Pesanan</h4>
                    </div>

                    <div class="d-flex col-5 align-items-center justify-content-end">
                        <button type="button" id="hapus-semua" class="btn btn-success p-2">Hapus Pesanan</button>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="card shadow-sm d-flex p-2 align-items-center flex-row justify-content-between mt-0 mb-4 mx-4" style="border-radius: 15px;">
                <div class="d-flex flex-column ps-2 gap-2 align-items-start">
                    <h5 style="font-weight: 600;">Alamat :</h5>
                    <div class="d-flex flex-row align-items-center gap-2">
                        <img src="{{ asset('assets\img\icons\maps.svg') }}" alt="">
                        <label style="font-weight: 300;" id="alamat-display">{{ $user->alamat ?? '-' }}</label>
                    </div>
                    <small style="font-weight: 300;" id="note-display">{{ $user->note ?? '-' }}</small>
                </div>

                <div class="d-flex align-self-start me-2 mt-4">
                    <a href="#" class="btn btn-success px-3" data-bs-toggle="modal" data-bs-target="#modalAlamat">
                        Ubah
                    </a>
                </div>
            </div>

            <!-- Modal Ubah Alamat -->
            <div class="modal fade" id="modalAlamat" tabindex="-1" aria-labelledby="modalAlamatLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">

                        <!-- Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAlamatLabel">Ubah Alamat Pengiriman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea id="alamat-input" class="form-control" rows="3">{{ $user->alamat ?? '' }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Catatan (Opsional)</label>
                                <textarea id="note-input" class="form-control" rows="2">{{ $user->note ?? '' }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Batal
                                </button>

                                <button type="button" class="btn btn-success px-3" id="btn-save-alamat">
                                    Simpan di Halaman
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- Produk -->
            <div id="keranjang-container">
                @include('frontend.keranjang.keranjang-list', ['keranjang' => $keranjang])
            </div>

            <!-- Total -->
            <div class="card shadow-sm d-flex flex-column align-items-stretch mt-4 mx-4 mb-4" style="border-radius: 15px;">
                <div class="d-flex flex-column m-4 mb-2">

                    <div class="d-flex flex-row justify-content-between mb-2">
                        <h6 style="font-weight: 500;">Total Pesanan</h6>
                        <h6 id="total-pesanan" style="font-weight: 500;"> Rp {{ number_format($total ?? 0, 0, ',', '.') }}</h6>
                    </div>

                    <div class="d-flex flex-row justify-content-between mb-4">
                        <h6 style="font-weight: 500;">Potongan Harga</h6>
                        <h6 id="potongan-harga" style="font-weight: 500;">Rp {{ number_format($potongan ?? 0, 0, ',', '.') }}</h6>
                    </div>

                    <div class="d-flex flex-row justify-content-between mt-4">
                        <h6 style="font-weight: 500;">Total Pembayaran</h6>
                        <h6 id="total-pembayaran" style="font-weight: 500;">Rp {{ number_format($pembayaran ?? 0, 0, ',', '.') }}</h6>
                    </div>

                </div>

                <a href="#"
                    class="btn btn-success d-flex align-items-stretch justify-content-between p-3"
                    data-bs-toggle="modal"
                    data-bs-target="#modalPromo">
                    Tambah Promo <i class="fa fa-chevron-right"></i>
                </a>
            </div>

        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="alamat" id="alamat-hidden" value="{{ $user->alamat ?? '-' }}">
            <input type="hidden" name="note" id="note-hidden" value="{{ $user->note ?? '-' }}">

            <button class="btn btn-success d-flex justify-content-center w-100 p-3" style="border-radius: 20px;">
                Bayar Sekarang
            </button>
        </form>
        </div>
    </div>

    <div class="modal fade" id="modalPromo" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Pilih Promo</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @forelse($promos as $promo)
                        <button class="btn btn-subtle-success w-100 mb-2 apply-promo"
                                data-kode="{{ $promo->kode_promo }}">
                            <strong>{{ $promo->kode_promo }}</strong><br>
                            <small class="text-white">{{ $promo->nama_promo }}</small>
                        </button>
                    @empty
                        <p class="text-muted text-center">Tidak ada promo aktif</p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const buttons = document.querySelectorAll(".add-to-cart");

        buttons.forEach(btn => {
            btn.addEventListener("click", function () {
                const productId = this.dataset.id;

                fetch(`/keranjang/add/${productId}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        document.getElementById("keranjang-container").innerHTML = data.html;
                        document.getElementById("total-pesanan").innerText = "Rp " + Number(data.total).toLocaleString('id-ID');
                        document.getElementById("potongan-harga").innerText = "Rp " + Number(data.potongan).toLocaleString('id-ID');
                        document.getElementById("total-pembayaran").innerText = "Rp " + Number(data.pembayaran).toLocaleString('id-ID');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => console.error(err));
            });
        });
    });

    $('#hapus-semua').click(function(e) {
        e.preventDefault();

        if (!confirm("Yakin hapus semua pesanan?")) return;

        $.ajax({
            url: '{{ route("keranjang.delete") }}',
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res){
                if(res.status === 'success'){
                    location.reload();
                } else {
                    alert(res.message);
                }
            }
        });
    });

    document.getElementById("btn-save-alamat").addEventListener("click", function() {
        const alamat = document.getElementById("alamat-input").value;
        const note = document.getElementById("note-input").value;

        document.getElementById("alamat-display").innerText = alamat;
        document.getElementById("note-display").innerText = note;

        document.getElementById("alamat-hidden").value = alamat;
        document.getElementById("note-hidden").value = note;

        const modal = bootstrap.Modal.getInstance(document.getElementById("modalAlamat"));
        modal.hide();
    });

    document.addEventListener("click", function(e){
        if (e.target.closest(".update-qty")) {
            const btn = e.target.closest(".update-qty");
            const id = btn.dataset.id;
            const action = btn.dataset.action;

            fetch(`/keranjang/update/${id}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ action })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById("keranjang-container").innerHTML = data.html;
                document.getElementById("total-pesanan").innerText = "Rp " + Number(data.total).toLocaleString('id-ID');
                document.getElementById("potongan-harga").innerText = "Rp " + Number(data.potongan).toLocaleString('id-ID');
                document.getElementById("total-pembayaran").innerText = "Rp " + Number(data.pembayaran).toLocaleString('id-ID');
            });
        }

        if (e.target.closest(".delete-item")) {
            const btn = e.target.closest(".delete-item");
            const id = btn.dataset.id;

            fetch(`/keranjang/delete/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById("keranjang-container").innerHTML = data.html;
                document.getElementById("total-pesanan").innerText = "Rp " + Number(data.total).toLocaleString('id-ID');
                document.getElementById("potongan-harga").innerText = "Rp " + Number(data.potongan).toLocaleString('id-ID');
                document.getElementById("total-pembayaran").innerText = "Rp " + Number(data.pembayaran).toLocaleString('id-ID');
            });
        }
    });

</script>

<script>
    document.addEventListener("click", function(e){
        if (e.target.closest(".apply-promo")) {
            const btn = e.target.closest(".apply-promo");
            const kode = btn.dataset.kode;

            fetch("{{ route('keranjang.apply-promo') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ kode_promo: kode })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById("potongan-harga").innerText =
                        "Rp " + Number(data.potongan).toLocaleString('id-ID');

                    document.getElementById("total-pembayaran").innerText =
                        "Rp " + Number(data.pembayaran).toLocaleString('id-ID');

                    bootstrap.Modal.getInstance(
                        document.getElementById("modalPromo")
                    ).hide();
                } else {
                    alert(data.message);
                }
            });
        }
    });
</script>
@endpush
