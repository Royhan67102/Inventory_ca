<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $order->invoice->invoice_number ?? 'INV-'.$order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<h3 style="text-align:center;">INVOICE</h3>

<p><strong>Nama Pemesan:</strong> {{ $order->customer->nama }}</p>
<p><strong>Tanggal:</strong> {{ $order->tanggal_pemesanan?->format('d M Y') }}</p>

<table>
    <thead>
        <tr>
            <th>Produk</th>
            <th>Ukuran (cm)</th>
            <th>Qty</th>
            <th>Harga / m²</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->panjang_cm }} x {{ $item->lebar_cm }}</td>
            <td>{{ $item->qty }}</td>
            <td>Rp {{ number_format($item->harga_per_m2,0,',','.') }}</td>
            <td>Rp {{ number_format($item->subtotal,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<p><strong>Total:</strong> Rp {{ number_format($order->invoice->total_harga ?? $order->total_harga,0,',','.') }}</p>
<p><strong>DP:</strong> Rp {{ number_format($order->invoice->dp ?? 0,0,',','.') }}</p>
<p><strong>Sisa Pembayaran:</strong> Rp {{ number_format($order->invoice->sisa_pembayaran ?? ($order->total_harga - ($order->invoice->dp ?? 0)),0,',','.') }}</p>

<br>

<p><strong>Catatan:</strong></p>
<p>
Kami tidak menerima pembayaran selain melalui rekening resmi.
Segala bentuk kesalahan transfer bukan tanggung jawab kami.
</p>

<br><br>

<table width="100%">
<tr>
    <td align="center">
        Admin<br><br><br>____________________
    </td>
    <td align="center">
        Penerima<br><br><br>____________________
    </td>
</tr>
</table>

</body>
</html>
