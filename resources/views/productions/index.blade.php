@extends('layouts.app')

@section('title', 'Daftar Production')
@section('page-title', 'Daftar Production')


<style>
    /* =========================
   CARD
========================= */
.card {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.card-header {
    background: #f8f9fa;
    padding: 16px 20px;
    font-weight: 600;
    border-bottom: 1px solid #e5e7eb;
}

.card-body {
    padding: 24px;
}

/* =========================
   TABLE STYLE
========================= */

.table {
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 0;
}

.table thead th {
    background: #f1f3f5;
    font-weight: 600;
    font-size: 14px;
    text-align: center;
    vertical-align: middle;
}

.table tbody td {
    vertical-align: middle;
    font-size: 14px;
    padding: 12px;
}

/* Zebra lebih soft */
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #fafafa;
}

/* Hover effect */
.table tbody tr:hover {
    background: #f5f7fa;
    transition: 0.2s ease;
}

/* =========================
   BADGE
========================= */

.badge {
    padding: 6px 10px;
    font-size: 12px;
    border-radius: 6px;
}

/* =========================
   BUTTON
========================= */

.btn-sm {
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 12px;
    margin: 2px;
}

/* =========================
   ALERT
========================= */

.alert {
    border-radius: 10px;
}

/* =========================
   MOBILE RESPONSIVE
========================= */

@media (max-width: 768px) {

    .card-body {
        padding: 18px;
    }

    .table thead {
        display: none;
    }

    .table tbody tr {
        display: block;
        background: #fff;
        margin-bottom: 14px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px;
    }

    .table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: right;
        padding: 8px 10px;
        border: none;
        border-bottom: 1px dashed #eee;
        font-size: 13px;
    }

    .table tbody td:last-child {
        border-bottom: none;
    }

    /* Label otomatis */
    .table tbody td:nth-child(1)::before { content: "#"; }
    .table tbody td:nth-child(2)::before { content: "Invoice"; }
    .table tbody td:nth-child(3)::before { content: "Customer"; }
    .table tbody td:nth-child(4)::before { content: "Tim"; }
    .table tbody td:nth-child(5)::before { content: "Bukti"; }
    .table tbody td:nth-child(6)::before { content: "Deadline"; }
    .table tbody td:nth-child(7)::before { content: "Status"; }
    .table tbody td:nth-child(8)::before { content: "Aksi"; }

    .table tbody td::before {
        font-weight: 600;
        text-align: left;
        color: #555;
    }

    /* Tombol aksi full width */
    .table tbody td:last-child {
        flex-direction: column;
        gap: 6px;
        align-items: stretch;
    }

    .table tbody td:last-child .btn {
        width: 100%;
    }
}

/* EXTRA SMALL DEVICE */
@media (max-width: 480px) {

    .btn-sm {
        font-size: 11px;
        padding: 5px 8px;
    }

    .badge {
        font-size: 11px;
    }

}
</style>
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Daftar Production</h5>
    </div>

    <div class="card-body">

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Tim</th>
                        <th>Bukti</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($productions as $production)

                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        {{-- INVOICE --}}
                        <td>
                            {{ $production->order->invoice_number ?? '-' }}
                        </td>

                        {{-- CUSTOMER --}}
                        <td>
                            {{ $production->order->customer->nama ?? '-' }}
                        </td>

                        {{-- TIM --}}
                        <td>
                            {{ $production->tim_produksi ?? '-' }}
                        </td>

                        {{-- BUKTI PRODUKSI --}}
                        <td class="text-center">
                            @if($production->bukti)
                                <a href="{{ asset('storage/'.$production->bukti) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">
                                   Lihat
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        {{-- DEADLINE --}}
                        <td class="text-center">
                            {{ optional($production->order->deadline)->format('d/m/Y') ?? '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td class="text-center">
                            <span class="badge
                                @if($production->status == 'menunggu') bg-warning text-dark
                                @elseif($production->status == 'proses') bg-info
                                @elseif($production->status == 'selesai') bg-success
                                @endif">
                                {{ ucfirst($production->status) }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td class="text-center">

                            <a href="{{ route('productions.show',$production->id) }}"
                                class="btn btn-primary btn-sm">
                                Detail
                            </a>

                            {{-- UPDATE --}}
                            @if($production->status !== 'selesai')
                                <a href="{{ route('productions.edit',$production->id) }}"
                                   class="btn btn-warning btn-sm">
                                   Update
                                </a>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    Locked
                                </button>
                            @endif

                            {{-- LIHAT ORDER --}}
                            <a href="{{ route('orders.show',$production->order_id) }}"
                               class="btn btn-info btn-sm">
                               Order
                            </a>

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            Belum ada data production
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $productions->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
