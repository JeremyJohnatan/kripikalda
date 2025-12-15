<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pesanan</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 30px;
            font-size: 14px;
        }
        h1 {
            margin-bottom: 5px;
            font-size: 22px;
        }
        h3 {
            margin-bottom: 0;
            margin-top: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
        }

        th {
            background: #e9e9e9;
            font-weight: bold;
        }

        .info {
            margin-top: 5px;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .total {
            text-align: right;
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .separator {
            margin-top: 25px;
            margin-bottom: 25px;
            height: 1px;
            background: #ccc;
        }
    </style>
</head>
<body>

<h1>Laporan Pesanan</h1>

@foreach($transaksi as $t)

    <h3>Pesanan #{{ $t->id_transaksi }}</h3>

    <div class="info">
        <strong>Tanggal:</strong> {{ $t->tanggal }} <br>
        <strong>Alamat:</strong> {{ $t->alamat }} <br>
        <strong>Status Pembayaran:</strong> {{ $t->status_pembayaran }} <br>
        <strong>Status Pengiriman:</strong> {{ $t->status_pengiriman }} <br>
        <strong>Catatan:</strong> {{ $t->note ?? 'Tidak ada catatan' }}
    </div>

    <table>
        <thead>
        <tr>
            <th style="width: 40%;">Nama Produk</th>
            <th style="width: 15%;">Harga</th>
            <th style="width: 15%;">Jumlah</th>
            <th style="width: 20%;">Subtotal</th>
        </tr>
        </thead>

        <tbody>
        @foreach($t->detail as $d)
            <tr>
                <td>{{ $d->product->nama_produk }}</td>
                <td>Rp {{ number_format($d->product->harga, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ $d->total_jumlah }}</td>
                <td style="text-align: right;">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="total">
        Total: Rp {{ number_format($t->total, 0, ',', '.') }}
    </div>

    <div class="separator"></div>

@endforeach

<script>
    window.print();
</script>

</body>
</html>
