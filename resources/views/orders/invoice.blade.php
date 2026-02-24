@extends('layouts.app')

@section('title', 'Invoice')
@section('page-title', 'Invoice')

<style>
    @media (max-width: 576px) {

    h4 {
        font-size: 18px;
    }

    table th, 
    table td {
        font-size: 12px;
        padding: 6px;
    }

    .card-body {
        padding: 15px;
    }

    p {
        margin-bottom: 6px;
    }

}
</style>

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        {{-- HEADER --}}
        <div class="d-flex flex-column flex-md-row justify-content-between mb-4 gap-3">
            <div>
                <p><strong>Nama Pemesan</strong> : {{ $order->customer->nama }}</p>
                <p><strong>Nama Penerima</strong> : Cahaya Akrilik</p>
                <p><strong>Tanggal Pemesanan</strong> : {{ $order->tanggal_pemesanan->format('d F Y') }}</p>
                <p><strong>No Rekening</strong> : BCA A/N Mahmud</p>
            </div>
            <div class="text-end">
                <h4 class="fw-bold">INVOICE</h4>
                <p><strong>No Invoice</strong><br>{{ $order->invoice_number }}</p>
            </div>
        </div>

        {{-- TABLE ITEM --}}
        <div class="table-responsive">
            <table class="table table-bordered">
            <thead class="table-light text-center">
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
                        {{ strtoupper($item->product_name) }}<br>
                        {{ $item->panjang_cm }} x {{ $item->lebar_cm }} CM
                    </td>
                    <td class="text-center">{{ $item->qty }} SET</td>

                {{-- HARGA SATUAN --}}
                <td class="text-end">
                Rp {{
                number_format(
                $item->jenis_order === 'custom'
                    ? $item->harga_per_cm2
                    : $item->harga_per_lembar,
                0, ',', '.'
            )
        }}
    </td>

    {{-- TOTAL / SUBTOTAL --}}
    <td class="text-end">
        Rp {{ number_format($item->subtotal,0,',','.') }}
    </td>
</tr>
@endforeach
</tbody>

        </table>
        </div>

        {{-- TOTAL --}}
        <div class="row mt-3 align-items-start">
    <div class="col-12 col-md-6 mb-2 mb-md-0">
        <p class="fw-bold">TOTAL SISA PEMBAYARAN</p>
    </div>
    <div class="col-12 col-md-6 text-md-end text-start">
            <div class="col-md-6 text-end">
                <p><strong>TOTAL :</strong> Rp {{ number_format($order->total_harga,0,',','.') }}</p>
                <p><strong>DP :</strong> Rp 0</p>
                <p><strong>SISA :</strong> Rp {{ number_format($order->total_harga,0,',','.') }}</p>
            </div>
        </div>

        {{-- CATATAN --}}
        <p class="mt-3">
            Kami tidak menerima selain pembayaran atau transaksi ke No rekening yang tertera.
        </p>

        {{-- TTD --}}
       <div class="row mt-5">
            <div class="col-12 text-md-end text-start">
                <p>Penerima</p>
                <br><br>
                <p><strong>Mahmud</strong></p>
            </div>
        </div>

        {{-- ACTION --}}
        <div class="mt-4 d-flex flex-column flex-md-row gap-2">
            <a href="{{ route('orders.invoice.download', $order) }}" class="btn btn-success w-100 w-md-auto" class="btn btn-success">
                Download PDF
            </a>
            <button onclick="window.print()" class="btn btn-secondary w-100 w-md-auto">
                Print
            </button>
        </div>

    </div>
</div>
@endsection
