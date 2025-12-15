@foreach($keranjang as $item)
<div class="card shadow-sm p-3 d-flex flex-row align-items-stretch gap-3 mx-4 mb-1"
    style="border-radius: 15px;">

    @php
        $gambar = $item->produk->gambar;
        $isFullUrl = $gambar && Str::startsWith($gambar, ['http://','https://']);
        $src = $gambar
            ? ($isFullUrl ? $gambar : asset('storage/'.$gambar))
            : 'https://placehold.co/80x80?text=No+Image';
    @endphp

    <img src="{{ $src }}" class="rounded"
        style="width: 80px; height: 120px; object-fit: cover;">

    <div class="d-flex flex-column justify-content-between w-100">
        <div class="d-flex justify-content-between">
            <div>
                <h6 class="fw-bold">{{ $item->produk->nama_produk }}</h6>
                <small>
                    @php
                        $berat = $item->produk->deskripsi;
                        echo $berat < 1000 ? $berat.' G' : number_format($berat/1000, 2, ',', '.').' KG';
                    @endphp
                </small>
            </div>

            <button class="btn btn-success-subtle delete-item"
                data-id="{{ $item->id_keranjang }}">
                <i class="fas fa-trash fa-lg"></i>
            </button>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <h4 class="fw-bold fs-5">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</h4>

            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-success-subtle update-qty"
                    data-id="{{ $item->id_keranjang }}"
                    data-action="minus">
                    <i class="fas fa-minus"></i>
                </button>

                <span class="px-2 fw-bold jumlah-text" id="jumlah-{{ $item->id_keranjang }}">
                    {{ $item->jumlah }}
                </span>

                <button class="btn btn-sm btn-success-subtle update-qty"
                    data-id="{{ $item->id_keranjang }}"
                    data-action="plus">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach
