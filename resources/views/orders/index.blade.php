@extends('layouts.app')

@section('title', 'Daftar Order')
@section('page-title', 'Daftar Order')

@section('content')
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


<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Daftar Order</h6>
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">+ Order Baru</a>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Produksi</th>
                    <th>Aksi</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $order->tanggal_pemesanan->format('d M Y') }}</td>
                    <td>{{ $order->customer->nama }}</td>
                    <td>Rp {{ number_format($order->total_harga,0,',','.') }}</td>
                    <td class="text-center">
                        <span class="badge bg-{{ $order->payment_status=='lunas'?'success':($order->payment_status=='dp'?'warning':'secondary') }}">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-{{ ($order->production?->status ?? '')=='selesai'?'success':'secondary' }}">
                            {{ ucfirst($order->production->status ?? 'menunggu') }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm">
                            Detail
                        </a>

                        <a href="{{ route('orders.invoice', $order) }}" class="btn btn-secondary btn-sm">
                            Invoice
                        </a>

                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary btn-sm">
                            Edit
                        </a>

                        <button
                            type="button"
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-id="{{ $order->id }}"
                            >
                            Hapus
                        </button>
                    </td>

                    <td>{{ $order->catatan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada order</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection



<!-- javascript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteModal');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const orderId = button.getAttribute('data-id');

        const form = document.getElementById('deleteForm');
        form.action = `/orders/${orderId}`;
    });
});
</script>
