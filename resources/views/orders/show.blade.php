@extends('layouts.app')

@section('title', 'Detail Order')
@section('page-title', 'Detail Order')

@section('content')
@php
use Illuminate\Support\Facades\Storage;
@endphp

<div class="container-fluid">
    <style>
.detail-box {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 10px 12px;
    background: #fafafa;
}

.detail-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 2px;
}

.detail-value {
    font-weight: 500;
    word-break: break-word;
}

@media (max-width: 768px) {
    .detail-box {
        padding: 8px 10px;
    }
}
</style>

{{-- ================= HEADER ================= --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold">
        Order {{ $order->invoice_number }}
    </h5>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">
        ← Kembali
    </a>
</div>

<div class="row">
    {{-- ================= CUSTOMER ================= --}}
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Data Customer</h6>

                <div class="detail-box mb-2">
                    <div class="detail-label">Nama</div>
                    <div class="detail-value">{{ $order->customer->nama }}</div>
                </div>

                <div class="detail-box mb-2">
                <div class="detail-label">Alamat</div>
                <div class="detail-value">{{ $order->customer->alamat }}</div>
            </div>

                <div class="detail-box">
                    <div class="detail-label">Telepon</div>
                    <div class="detail-value">{{ $order->customer->telepon }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= ORDER ================= --}}
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Informasi Order</h6>

                <div class="col-12 col-md-6">
    <div class="detail-box">
        <div class="detail-label">Tanggal Pemesanan</div>
        <div class="detail-value">
            {{ $order->tanggal_pemesanan->format('d M Y') }}
        </div>
    </div>
</div>
                    <div class="col-12 col-md-6">
    <div class="detail-box">
        <div class="detail-label">Deadline</div>
        <div class="detail-value">
            {{ $order->deadline ? $order->deadline->format('d M Y') : '-' }}
        </div>
    </div>
</div>

                <div class="detail-box mb-2">
            <div class="detail-label">Status Pembayaran</div>
            <div class="detail-value">
                <span class="badge bg-warning text-dark">
                    {{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}
                </span>
            </div>
</div>

                <div class="detail-box mb-2">
                <div class="detail-label">Tipe Order</div>
                <div class="detail-value">
                    <span class="badge bg-secondary">
                        {{ strtoupper($order->tipe_order) }}
                    </span>
                </div>
            </div>


                <div class="detail-box mb-3">
                <div class="detail-label">Status Order</div>
                <div class="detail-value">
                    <span class="badge bg-info">
                        {{ strtoupper($order->status) }}
                    </span>
                </div>
            </div>>
                </div>

                <hr>

                {{-- ================= DESAIN ================= --}}
                <div class="mb-3">
                    <label class="text-muted small">Jasa Desain</label>

                    <div class="fw-semibold">
                        {{ $order->design ? 'Ya' : 'Tidak' }}
                    </div>

                    @if($order->design)
                        <div class="mt-2">
                            @if($order->design->file_awal)
                                <a href="{{ Storage::url($order->design->file_awal) }}"
                                target="_blank"
                                class="btn btn-outline-primary btn-sm me-2">
                                👁 Lihat File
                                </a>

                                <a href="{{ Storage::url($order->design->file_awal) }}"
                                download
                                class="btn btn-outline-success btn-sm">
                                ⬇ Download
                                </a>

                                @if(Str::endsWith($order->design->file_awal, ['jpg','jpeg','png','gif','webp']))
                                    <div class="mt-3">
                                        <img src="{{ Storage::url($order->design->file_awal) }}"
                                            class="img-fluid rounded"
                                            style="max-height:300px; max-width:100%;">
                                    </div>
                                @endif

                            @else
                                <span class="text-muted fst-italic">
                                    File desain belum diupload
                                </span>
                            @endif
                        </div>
                    @endif
                </div>


                <hr>

                {{-- ================= JASA TAMBAHAN ================= --}}
                <div class="row g-2">
                    <div class="col-12 col-md-6">
                    <div class="detail-box">
                        <div class="detail-label">Antar Barang</div>
                        <div class="detail-value">
                            {{ $order->antar_barang ? 'Ya' : 'Tidak' }}
                            @if($order->antar_barang)
                                <br>
                                <small>Biaya: Rp{{ number_format($order->biaya_pengiriman,0,',','.') }}</small>
                            @endif
                        </div>
                    </div>
                </div>

                    <div class="col">
                        <label class="text-muted small">Jasa Pemasangan</label>
                        <div>
                            {{ $order->jasa_pemasangan ? 'Ya' : 'Tidak' }}
                        </div>
                        @if($order->jasa_pemasangan)
                            <small>Biaya: Rp{{ number_format($order->biaya_pemasangan,0,',','.') }}</small>
                        @endif
                    </div>
                </div>

                @if(!empty($order->catatan))
                    <hr>
                    <div class="detail-box">
                        <div class="detail-label">Catatan</div>
                        <div class="detail-value">{{ $order->catatan }}</div>
                    </div>
                    @endif

            </div>
        </div>
    </div>
</div>

{{-- ================= ITEM ================= --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold">Item Order</h6>

        <div class="table-responsive">
            <div class="table-responsive rounded border">
            <table class="table table-sm table-bordered align-middle">
                <thead class="text-center">
                    <tr>
                        <th>Produk</th>
                        <th>Merk</th>
                        <th>Ketebalan</th>
                        <th>Warna</th>
                        <th>Panjang</th>
                        <th>Lebar</th>
                        <th>Luas (m²)</th>
                        <th>Keterangan</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    @php
                        $luas  = ($item->panjang_cm * $item->lebar_cm) / 10000;
                        $total = $item->harga * $item->qty;
                    @endphp
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->merk }}</td>
                            <td>{{ $item->ketebalan ?? '-' }}</td>
                            <td>{{ $item->warna ?? '-' }}</td>
                            <td class="text-end">{{ $item->panjang_cm }}</td>
                            <td class="text-end">{{ $item->lebar_cm }}</td>
                            <td class="text-end">{{ number_format($luas,2) }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-end">
                    Rp{{ number_format($item->harga,0,',','.') }}
                    </td>
                    <td class="text-end">
                        Rp{{ number_format($total,0,',','.') }}
                    </td>
            </tr>
            @endforeach
            </tbody>

            </table>
        </div>
    </div>
</div>

{{-- ================= TOTAL ================= --}}
<div class="text-md-end text-start mb-5">
    <div class="detail-box d-inline-block">
        Grand Total :
        <strong class="text-success">
            Rp{{ number_format($order->total_harga,0,',','.') }}
        </strong>
    </div>
</div>

</div>

</div>
@endsection
