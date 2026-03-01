@extends('layouts.app')

@section('title','Pickup')
@section('page-title','Pickup')

<style>
    /* =========================
   TABLE RESPONSIVE WRAPPER
========================= */
.card-body {
    overflow-x: auto;
}

/* =========================
   TABLE IMPROVEMENT
========================= */
.table {
    min-width: 600px;
}

/* Supaya isi tabel tetap enak dilihat */
.table td,
.table th {
    white-space: nowrap;
    vertical-align: middle;
}

/* =========================
   BUTTON RESPONSIVE
========================= */
.table .btn {
    margin: 2px;
}

/* =========================
   MOBILE VIEW
========================= */
@media (max-width: 768px) {

    .table {
        font-size: 14px;
    }

    .table td,
    .table th {
        padding: 10px 6px;
    }

    /* Tombol jadi stack */
    .table td .btn {
        display: block;
        width: 100%;
        margin-bottom: 4px;
    }

    /* Badge tetap center */
    .table .badge {
        display: inline-block;
        width: 100%;
    }

}
</style>
@section('content')
<div class="card">
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered align-middle">
            <thead class="text-center">
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($pickups as $pickup)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pickup->order->invoice_number ?? '-' }}</td>
                    <td>{{ $pickup->order->customer->nama ?? '-' }}</td>
                    <td class="text-center">
                        <span class="badge
                            {{ $pickup->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ ucfirst($pickup->status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('pickup.show',$pickup->id) }}"
                            class="btn btn-primary btn-sm">
                            Detail
                        </a>

                        {{-- UPDATE --}}
                        @if($pickup->status !== 'selesai')
                            <a href="{{ route('pickup.edit',$pickup->id) }}"
                               class="btn btn-warning btn-sm">
                               Update
                            </a>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>
                                Locked
                            </button>
                        @endif

                        {{-- LIHAT ORDER --}}
                        <a href="{{ route('orders.show',$pickup->order_id) }}"
                           class="btn btn-info btn-sm">
                           Order
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada pickup
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

    <div class="mt-3">
            {{ $pickups->appends(request()->query())->links() }}
    </div>
</div>
@endsection
