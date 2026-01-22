<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->invoice_number ?? 'INV-'.$order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #f5f5f5;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<table width="100%" style="border:none;">
    <tr>
        <td style="border:none;">
            <p><strong>Nama Pemesan</strong> : {{ $order->customer->nama }}</p>
            <p><strong>Nama Penerima</strong> : Cahaya Akrilik</p>
            <p><strong>Tanggal Pemesanan</strong> : {{ $order->tanggal_pemesanan->format('d F Y') }}</p>
            <p><strong>No Rekening</strong> : BCA A/N Mahmud</p>
        </td>
        <td style="border:none; text-align:right;">
            <h3>INVOICE</h3>
            <p>{{ $order->invoice_number }}</p>
        </td>
    </tr>
</table>

<br>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Keterangan</th>
            <th width="10%">QTY</th>
            <th width="15%">Harga</th>
            <th width="15%">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $i => $item)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>
                {{ strtoupper($item->product_name) }}
                {{ $item->panjang_cm }} x {{ $item->lebar_cm }} CM
            </td>
            <td class="text-center">{{ $item->qty }} SET</td>
            <td class="text-right">
                Rp {{ number_format($item->harga_per_m2,0,',','.') }}
            </td>
            <td class="text-right">
                Rp {{ number_format($item->subtotal,0,',','.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<table width="100%" style="border:none;">
    <tr>
        <td style="border:none;">
            <strong>TOTAL SISA PEMBAYARAN</strong>
        </td>
        <td style="border:none;" class="text-right">
            <p><strong>TOTAL :</strong> Rp {{ number_format($order->total_harga,0,',','.') }}</p>
            <p><strong>DP :</strong> Rp 0</p>
            <p><strong>SISA :</strong> Rp {{ number_format($order->total_harga,0,',','.') }}</p>
        </td>
    </tr>
</table>

<br>

<p>
Kami tidak menerima selain pembayaran atau transaksi ke No rekening yang tertera.
</p>

<br><br>

<table width="100%" style="border:none;">
    <tr>
        <td style="border:none;"></td>
        <td style="border:none; text-align:center;">
            Penerima<br><br><br>
            <strong>Mahmud</strong>
        </td>
    </tr>
</table>

</body>
</html>
