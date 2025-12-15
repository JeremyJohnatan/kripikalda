<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 13px;
            color: #222;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 12px;
            margin-bottom: 15px;
            color: #666;
        }

        .summary {
            width: 100%;
            border: 1px solid #444;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .summary th, .summary td {
            border: 1px solid #444;
            padding: 6px;
            text-align: center;
        }

        .summary th {
            background: #eee;
            font-weight: bold;
        }

        table {
            width: 100%;
            border: 1px solid #444;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px;
        }

        th {
            background: #eee;
        }

        .right {
            text-align: right;
        }

        @media print {
            body {
                margin: 10px;
            }
        }
    </style>
</head>
<body>

<h1>Laporan Penjualan</h1>
<div class="subtitle">Tanggal Cetak: {{ date('d/m/Y H:i') }}</div>

<h3>Statistik Penjualan</h3>
<table class="summary">
    <tr>
        <th>Produk Terjual</th>
        <th>Produk Terlaris</th>
        <th>Produk Kurang Laku</th>
        <th>Total Pendapatan</th>
    </tr>
    <tr>
        <td>{{ $product_sold ?? 0 }}</td>
        <td>{{ $product_fav->product->nama_produk ?? '-' }} ({{ $product_fav->total_jumlah ?? 0 }})</td>
        <td>{{ $product_least->product->nama_produk ?? '-' }} ({{ $product_least->total_jumlah ?? 0 }})</td>
        <td class="right">Rp {{ number_format($revenue, 0, ',', '.') }}</td>
    </tr>
</table>

<h3>Data Pesanan</h3>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Alamat</th>
            <th>Status Bayar</th>
            <th>Status Kirim</th>
            <th class="right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaksi as $t)
        <tr>
            <td>{{ $t->tanggal }}</td>
            <td>{{ $t->alamat }}</td>
            <td>{{ $t->status_pembayaran }}</td>
            <td>{{ $t->status_pengiriman }}</td>
            <td class="right">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    window.print();
</script>

</body>
</html>
