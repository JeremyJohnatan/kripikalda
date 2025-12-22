<!DOCTYPE html>
<html>
<head>
    <title>Invoice Pesanan</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Halo, {{ $transaksi->user->name }}</h2>
    <p>Terima kasih telah memesan di kripik alda. Berikut detail pesanan kamu:</p>

    <p>
        <strong>No. Order:</strong> {{ $transaksi->external_id }} <br>
        <strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y H:i') }} <br>
        <strong>Status:</strong> {{ $transaksi->status_pembayaran }}
    </p>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detail as $item)
            <tr>
                <td>{{ $item->produk->nama_produk ?? 'Produk' }}</td>
                <td style="text-align: center;">{{ $item->jumlah }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total Bayar</strong></td>
                <td style="text-align: right;"><strong>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <p>Terima kasih,<br>Tim kripik alda</p>
</body>
</html>