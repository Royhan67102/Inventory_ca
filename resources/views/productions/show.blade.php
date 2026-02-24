@extends('layouts.app')

@section('title','Detail Production')
@section('page-title','Detail Production')

<style>
    /* =========================
   CARD
========================= */

.card {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}

.card-header {
    background: #f8f9fa;
    font-weight: 600;
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.card-body {
    padding: 24px;
}

/* =========================
   TABLE DETAIL
========================= */

.table-borderless tr {
    border-bottom: 1px solid #f1f3f5;
}

.table-borderless th {
    font-weight: 600;
    color: #6c757d;
    padding: 14px 10px;
    vertical-align: middle;
    white-space: nowrap;
}

.table-borderless td {
    padding: 14px 10px;
    font-weight: 500;
    color: #212529;
}

/* Supaya value tidak terlalu mepet */
.table-borderless td,
.table-borderless th {
    line-height: 1.6;
}

/* =========================
   BADGE
========================= */

.badge {
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 6px;
}

/* =========================
   BUTTON
========================= */

.btn {
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 14px;
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 768px) {

    .card-body {
        padding: 18px;
    }

    .table-borderless,
    .table-borderless tbody,
    .table-borderless tr,
    .table-borderless th,
    .table-borderless td {
        display: block;
        width: 100%;
    }

    .table-borderless tr {
        margin-bottom: 12px;
        background: #fafafa;
        border-radius: 10px;
        padding: 12px;
    }

    .table-borderless th {
        padding: 0;
        margin-bottom: 4px;
        font-size: 13px;
        color: #6c757d;
    }

    .table-borderless td {
        padding: 0;
        margin-bottom: 6px;
        font-size: 14px;
    }

    .btn {
        width: 100%;
        margin-top: 12px;
    }
}

/* EXTRA SMALL */
@media (max-width: 480px) {

    .card-header h5 {
        font-size: 16px;
    }

    .table-borderless td {
        font-size: 13px;
    }

    .badge {
        font-size: 12px;
    }
}
</style>

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Detail Production</h5>
    </div>

    <div class="card-body">

        <table class="table table-borderless">

            {{-- ORDER --}}
            <tr>
                <th width="200">Kode Order</th>
                <td>{{ $production->order->invoice_number ?? '-' }}</td>
            </tr>

            <tr>
                <th>Customer</th>
                <td>{{ $production->order->customer->nama ?? '-' }}</td>
            </tr>

            {{-- STATUS --}}
            <tr>
                <th>Status Production</th>
                <td>
                    <span class="badge
                        @if($production->status == 'menunggu') bg-warning text-dark
                        @elseif($production->status == 'proses') bg-info
                        @elseif($production->status == 'selesai') bg-success
                        @endif">
                        {{ ucfirst($production->status) }}
                    </span>
                </td>
            </tr>

            {{-- TIM --}}
            <tr>
                <th>Tim Produksi</th>
                <td>{{ $production->tim_produksi ?? '-' }}</td>
            </tr>

            {{-- TANGGAL --}}
            <tr>
                <th>Tanggal Mulai</th>
                <td>
                    {{ $production->tanggal_mulai
                        ? \Carbon\Carbon::parse($production->tanggal_mulai)->format('d/m/Y H:i')
                        : '-' }}
                </td>
            </tr>

            <tr>
                <th>Tanggal Selesai</th>
                <td>
                    {{ $production->tanggal_selesai
                        ? \Carbon\Carbon::parse($production->tanggal_selesai)->format('d/m/Y H:i')
                        : '-' }}
                </td>
            </tr>

            {{-- CATATAN DESIGN (TETAP PUNYA DESIGN) --}}
            <tr>
                <th>Catatan Design</th>
                <td>{{ $production->order->design->catatan ?? '-' }}</td>
            </tr>

            {{-- FILE HASIL DESIGN (JANGAN DIUBAH SESUAI REQUEST) --}}
            <tr>
                <th>File Hasil Design</th>
                <td>
                    @if($production->order->design?->file_hasil)
                        <a href="{{ asset('storage/'.$production->order->design->file_hasil) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                           Lihat File
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>

            {{-- BUKTI PRODUKSI --}}
            <tr>
                <th>Bukti Produksi</th>
                <td>
                    @if($production->bukti)
                        <a href="{{ asset('storage/'.$production->bukti) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-success">
                           Lihat Bukti
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>

            {{-- CATATAN PRODUKSI --}}
            <tr>
                <th>Catatan Produksi</th>
                <td>{{ $production->catatan ?? '-' }}</td>
            </tr>

        </table>

        <a href="{{ route('productions.index') }}"
           class="btn btn-secondary">
           Kembali
        </a>

    </div>
</div>
@endsection
