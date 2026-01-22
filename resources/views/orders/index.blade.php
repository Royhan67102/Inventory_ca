@extends('layouts.app')

@section('title', 'Daftar Order')
@section('page-title', 'Daftar Order')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Daftar Order</h6>
        <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">+ Order Baru</a>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Produksi</th>
                    <th>Aksi</th>
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

                        {{-- DELETE --}}
                        <form action="{{ route('orders.destroy', $order) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus order ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
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
