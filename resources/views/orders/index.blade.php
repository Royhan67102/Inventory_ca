@extends('layouts.app')

@section('title', 'Daftar Order')
@section('page-title', 'Daftar Order')

@section('content')

<style>

/* CARD */
.order-card {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
}

/* TABLE */
.table {
    border: 1px solid #dee2e6;
}

.table th,
.table td {
    border: 1px solid #dee2e6 !important;
    vertical-align: middle;
    white-space: nowrap;
}

/* HEADER */
.table thead th {
    background: #f8f9fa;
    font-weight: 600;
}

/* BADGE */
.badge {
    font-size: 12px;
    padding: 6px 10px;
}

/* AKSI BUTTON WRAP */
.aksi-btn {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    justify-content: center;
}

/* MOBILE */
@media (max-width: 768px) {

    .card-body {
        padding: 14px;
    }

    .table {
        font-size: 13px;
    }

    .aksi-btn {
        flex-direction: column;
    }

    .table td {
        white-space: normal;
    }

}

</style>


<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>Apakah kamu yakin ingin menghapus order ini?</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Tidak
        </button>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                Ya, Hapus
            </button>
        </form>
      </div>

    </div>
  </div>
</div>

<div class="card shadow-sm order-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Daftar Order</h6>
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">+ Order Baru</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th style="min-width:100px">Kode</th>
                    <th style="min-width:110px">Tanggal</th>
                    <th style="min-width:150px">Customer</th>
                    <th style="min-width:120px">Tipe order</th>
                    <th style="min-width:120px">Total</th>
                    <th style="min-width:120px">Pembayaran</th>
                    <th style="min-width:120px">Status</th>
                    <th style="min-width:150px">Catatan</th>
                    <th style="min-width:170px">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($orders as $order)
                <tr>
                    {{-- KODE --}}
                    <td class="text-center fw-bold">
                        838{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                    </td>

                    {{-- TANGGAL --}}
                    <td>
                        {{ $order->tanggal_pemesanan->format('d M Y') }}
                    </td>

                    {{-- CUSTOMER --}}
                    <td>
                        {{ optional($order->customer)->nama ?? '-' }}
                    </td>

                    {{-- TIPE --}}
                    <td class="text-center">
                        {{ ucfirst($order->tipe_order ?? '-') }}
                    </td>

                    {{-- TOTAL --}}
                    <td>
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </td>

                    {{-- PEMBAYARAN --}}
                    <td class="text-center">
                        <div class="aksi-btn">
                        <span class="badge bg-{{
                            $order->payment_status == 'lunas' ? 'success' :
                            ($order->payment_status == 'dp' ? 'warning' : 'secondary')
                        }}">
                            {{ strtoupper(str_replace('_',' ', $order->payment_status)) }}
                        </span>
                    </td>

                    {{-- STATUS ORDER --}}
                    <td class="text-center">
                        <span class="badge bg-info text-dark">
                            {{ ucfirst($order->status ?? 'desain') }}
                        </span>
                    </td>

                    {{-- CATATAN --}}
                    <td>
                        {{ $order->catatan ?? '-' }}
                    </td>

                    {{-- AKSI --}}
                    <td class="text-center">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm">
                            Detail
                        </a>

                        <a href="{{ route('orders.invoice', $order) }}" class="btn btn-secondary btn-sm">
                            Invoice
                        </a>

                        @if(in_array($order->status, ['desain', 'produksi']))
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary btn-sm">
                                Edit
                            </a>
                        @else
                            <button type="button" class="btn btn-primary btn-sm" disabled>
                                Edit
                            </button>
                        @endif

                        <button
                            type="button"
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-id="{{ $order->id }}">
                            Hapus
                        </button>
                    </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        Belum ada order
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>

        <div class="mt-3">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const orderId = button.getAttribute('data-id');

        document.getElementById('deleteForm').action = `/orders/${orderId}`;
    });
});
</script>
@endpush
