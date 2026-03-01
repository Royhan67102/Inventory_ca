@extends('layouts.app')

@section('title','Delivery')
@section('page-title','Delivery')

<style>
.delivery-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* Table */
.delivery-table {
    white-space: nowrap;
    font-size: 14px;
}

.delivery-table thead th {
    background: #f9fafb;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
}

.delivery-table tbody td {
    vertical-align: middle;
}

/* Status */
.status-badge {
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 12px;
}

/* Responsive font */
@media (max-width: 768px) {
    .delivery-table {
        font-size: 13px;
    }
}
</style>

@section('content')
<div class="delivery-card">

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle delivery-table">
    <thead>
        <tr>
            <th width="50">#</th>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Driver</th>
            <th>Status</th>
            <th width="120">Detail</th>
            <th width="80">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($deliveries as $delivery)
        <tr>
            <td class="text-center">
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $delivery->order->invoice_number ?? '-' }}
            </td>

            <td>
                {{ $delivery->order->customer->nama ?? '-' }}
            </td>

            <td>
                {{ $delivery->driver ?? '-' }}
            </td>

            <td class="text-center">
                <span class="badge status-badge bg-info">
                    {{ ucfirst($delivery->status) }}
                </span>
            </td>

            {{-- DETAIL BUTTON (PRIMARY ACTION) --}}
            <td class="text-center">
                <a href="{{ route('delivery.show',$delivery->id) }}"
                   class="btn btn-primary btn-sm">
                   Detail
                </a>
            </td>

            {{-- DROPDOWN ACTION --}}
            <td class="text-center">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown">
                        Aksi
                    </button>

                    <ul class="dropdown-menu">

                        @if($delivery->status !== 'selesai')
                        <li>
                            <a class="dropdown-item"
                               href="{{ route('delivery.edit',$delivery->id) }}">
                               Update
                            </a>
                        </li>
                        @endif

                        <li>
                            <a class="dropdown-item"
                               href="{{ route('delivery.suratjln.preview',$delivery->id) }}">
                               Surat Jalan
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="{{ route('orders.show',$delivery->order_id) }}">
                               Lihat Order
                            </a>
                        </li>

                    </ul>
                </div>
            </td>

        </tr>

        @empty
        <tr>
            <td colspan="7" class="text-center">
                Belum ada delivery
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>

<div class="mt-3">
    {{ $deliveries->appends(request()->query())->links() }}
</div>

</div>
@endsection
