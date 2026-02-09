@extends('layouts.app')

@section('title','Delivery')
@section('page-title','Delivery')

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="text-center">
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Driver</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
        @forelse($deliveries as $delivery)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $delivery->order->invoice_number ?? '-' }}</td>
                <td>{{ $delivery->order->customer->nama ?? '-' }}</td>
                <td>{{ $delivery->driver ?? '-' }}</td>
                <td class="text-center">
                    <span class="badge bg-info">
                        {{ ucfirst($delivery->status) }}
                    </span>
                </td>
                {{-- AKSI --}}
                        <td class="text-center">

                            <a href="{{ route('delivery.show',$delivery->id) }}"
                                class="btn btn-primary btn-sm">
                                Detail
                            </a>

                            {{-- UPDATE --}}
                            @if($delivery->status !== 'selesai')
                                <a href="{{ route('delivery.edit',$delivery->id) }}"
                                   class="btn btn-warning btn-sm">
                                   Update
                                </a>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    Locked
                                </button>
                            @endif

                            {{-- LIHAT ORDER --}}
                            <a href="{{ route('orders.show',$delivery->order_id) }}"
                               class="btn btn-info btn-sm">
                               Order
                            </a>

                        </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">
                    Belum ada delivery
                </td>
            </tr>
        @endforelse
        </tbody>

        </table>
    </div>
</div>
@endsection
