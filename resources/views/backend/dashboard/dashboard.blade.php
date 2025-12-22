@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
<div class="ml-1 mb-4">
    <h1 class="fw-bold">Rincian Penjualan</h1>
</div>

<div class="d-flex flex-column-reverse justify-content-between mb-4 gap-3">

    <!-- Filter -->
    <div class="d-flex gap-2">
        <a href="{{ route('dashboard', ['filter' => 'Harian']) }}"
        class="btn-sm btn-success-subtle {{ $filter == 'Harian' ? 'active' : '' }}">
        Harian
        </a>

        <a href="{{ route('dashboard', ['filter' => 'Mingguan']) }}"
        class="btn-sm btn-success-subtle {{ $filter == 'Mingguan' ? 'active' : '' }}">
        Mingguan
        </a>

        <a href="{{ route('dashboard', ['filter' => 'Bulanan']) }}"
        class="btn-sm btn-success-subtle {{ $filter == 'Bulanan' ? 'active' : '' }}">
        Bulanan
        </a>

        <a href="{{ route('dashboard', ['filter' => 'Tahunan']) }}"
        class="btn-sm btn-success-subtle {{ $filter == 'Tahunan' ? 'active' : '' }}">
        Tahunan
        </a>

        <form id="rangeForm" action="{{ route('dashboard') }}" method="GET" class="d-flex gap-2 align-items-center">
            <input type="hidden" name="filter" value="Range">

            <input
                type="text"
                id="dateRange"
                name="range"
                class="form-control form-control-sm"
                placeholder="Pilih Rentang Tanggal"
                value="{{ request('range') }}"
                style="min-width: 240px;"
            >
        </form>
    </div>

    <!-- Action -->
    <div class="d-flex align-self-end gap-2">
        <a href="{{ route('dashboard.cetak.pdf') }}" class="btn-success d-flex align-items-center p-2 gap-2">
            Cetak Laporan
        </a>

        <a href="#"
        id="geminiBtn"
        class="btn-success d-flex align-items-center p-2 gap-2">
        Lihat Perkembangan Penjualan
        </a>

        <!-- Modal untuk menampilkan hasil AI -->
        <div class="modal fade" id="geminiModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content p-4">
                <div class="modal-header">
                    <h5 class="modal-title">Insight Penjualan dari Gemini AI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="geminiContent">Memuat insight...</div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row px-2 mb-4">
    <div class="col-lg-3 px-1">
        <div class="card shadow-sm p-3 d-flex align-items-center gap-3" style="border-radius: 25px;">
            <h5>Produk Yang Terjual</h5>
            <div class="d-flex flex-column align-items-center">
                <h2 style="color: var(--tg-body-font-color);" class="fw-bold">{{ $product_sold ?? 0 }}</h2>
                <label for="">Produk</label>
            </div>
        </div>
    </div>

    <div class="col-lg-3 px-1">
        <div class="card shadow-sm  p-3 d-flex align-items-center gap-3" style="border-radius: 25px;">
            <h5>Produk Terlaris</h5>
            <div class="d-flex flex-column">
                <h2 style="color: var(--tg-body-font-color);" class="align-self-center fw-bold">{{ $product_fav->total_jumlah ?? 0 }}</h2>
                <label for="">{{ $product_fav->product->nama_produk ?? '-'}}</label>
            </div>
        </div>
    </div>

    <div class="col-lg-3 px-1">
        <div class="card shadow-sm  p-3 d-flex align-items-center gap-3" style="border-radius: 25px;">
            <h5>Produk Kurang Laku</h5>
            <div class="d-flex flex-column">
                <h2 style="color: var(--tg-body-font-color);" class="align-self-center fw-bold">{{ $product_least->total_jumlah ?? 0 }}</h2>
                <label for="">{{ $product_least->product->nama_produk ?? '-' }}</label>
            </div>
        </div>
    </div>

    <div class="col-lg-3 px-1">
        <div class="card shadow-sm p-3 d-flex align-items-center gap-3" style="border-radius: 25px;">
            <h5>Total Pendapatan</h5>
            <div class="d-flex flex-column">
                <h2 style="color: var(--tg-body-font-color);" class="fw-bold">Rp {{ number_format($revenue, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row px-2 mb-4 ">

    <!-- Donut Chart -->
    <div class="col-lg-4 ps-1">
        <div class="card shadow-sm p-3 d-flex gap-3" style="border-radius: 25px;">
            <h5>Produk Terlaris</h5>
            <canvas id="donutChart"></canvas>
        </div>
    </div>

    <!-- Bar Chart -->
    <div class="col-lg-8 px-1">
        <div class="card shadow-sm p-3 d-flex gap-3" style="border-radius: 25px;">
            <h5>Pertumbuhan Bisnis</h5>
            <canvas id="barChart"></canvas>
        </div>
    </div>
</div>

<div class="d-flex flex-wrap card shadow-sm px-4 mt-4" style="border-radius: 35px;">
    <div class="sub-title mt-4">
        <h2>Pesanan</h2>
    </div>

    <div class="table mt-4">
        <table class="table mb-4">
            <thead class="border-top border-bottom border-dark">
                <tr>
                    <th class="fw-semibold py-3 text-start">Tanggal Pesanan</th>
                    <th class="fw-semibold py-3 text-center">Alamat</th>
                    <th class="fw-semibold py-3 text-center">Status Pembayaran</th>
                    <th class="fw-semibold py-3 text-center">Status Pengiriman</th>
                    <th class="fw-semibold py-3 text-end">Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach($transaksi as $t)
                <tr>
                    <td class="fw-semibold py-3 text-start">{{ $t->tanggal }}</td>
                    <td class="fw-semibold py-3 text-start">{{ $t->alamat}}</td>
                    <td class="fw-semibold py-3 text-center">{{ $t->status_pembayaran }}</td>
                    <td class="fw-semibold py-3 text-center">{{ $t->status_pengiriman }}</td>
                    <td class="fw-semibold py-3 text-end">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
   document.getElementById("geminiBtn").addEventListener("click", function (e) {
        e.preventDefault();

        document.getElementById("geminiContent").innerHTML = "Memuat insight...";

        const modalEl = document.getElementById("geminiModal");
        const modal = new bootstrap.Modal(modalEl);
        modal.show();

        let url = "{{ route('get.insight') }}?data=" +
            encodeURIComponent(JSON.stringify(@json($aiData)));

        fetch(url)
            .then(res => res.json())
            .then(data => {
                let raw = data.candidates[0].content.parts[0].text;

                let formatted = raw
                    .replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>")
                    .replace(/(### )(.+)/g, "<h4>$2</h4>")
                    .replace(/(## )(.+)/g, "<h3>$2</h3>")
                    .replace(/(# )(.+)/g, "<h2>$2</h2>")
                    .replace(/\n[-•]\s*(.+)/g, "<li>$1</li>")
                    .replace(/\n\n/g, "</p><p>")
                    .replace(/\n/g, "<br>");

                formatted = formatted.replace(
                    /(<li>[\s\S]*?<\/li>)/g,
                    "<ul>$1</ul>"
                );

                document.getElementById("geminiContent").innerHTML = `
                    <div class="gemini-box">
                        <p>${formatted}</p>
                    </div>
                `;
            })
            .catch(err => {
                document.getElementById("geminiContent").innerHTML =
                    "<p>Error memuat insight.</p>";
            });
    });
</script>

<script>
    flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "Y-m-d",
        locale: {
            rangeSeparator: " - "
        },
        onClose: function(selectedDates, dateStr) {
            if (selectedDates.length === 2) {
                document.getElementById('rangeForm').submit();
            }
        }
    });
</script>

<script>
    // chart produk terlaris
    const donut = document.getElementById('donutChart');

    const donutLabels = @json($donut->pluck('product.nama_produk'));
    const donutValues = @json($donut->pluck('total_jumlah'));

    const donutData = {
        labels: donutLabels,
        datasets: [{
            label: 'Jumlah Terjual',
            data: donutValues,
            backgroundColor: [
                'rgb(75, 127, 82)',
                'rgb(125, 209, 129)',
                'rgb(150, 232, 188)',
                'rgb(182, 249, 201)',
                'rgb(201, 255, 226)'
            ],
            hoverOffset: 4
        }]
    };

    const configDonut = (donut, {
        type: 'doughnut',
        data: donutData,
        options: {
            responsive: true,
            plugins: {
            legend: {
                display: false,
            }
            }
        },
    });

    new Chart(donut, configDonut);

    /// chart pertumbuhan bisnis
    const bar = document.getElementById('barChart');

    let barLabels = @json($bar->pluck('period'));
    const barValues = @json($bar->pluck('total_jumlah'));

    const barData = {
        labels: barLabels,
        datasets: [{
            data: barValues,
            backgroundColor: ['rgb(19, 50, 35)'],
            hoverOffset: 4
        }]
    };

    const barConfig = {
        type: 'bar',
        data: barData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                }
            }
        }
    };

    new Chart(bar, barConfig);
</script>
@endpush
