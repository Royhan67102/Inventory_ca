@extends('layouts.app')

@section('title','Detail Pickup')
@section('page-title','Detail Pickup')

@section('content')
<div class="card">
    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th width="200">Invoice</th>
                <td>{{ $pickup->order->invoice_number ?? '-' }}</td>
            </tr>
            <tr>
                <th>Customer</th>
                <td>{{ $pickup->order->customer->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge
                        {{ $pickup->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ ucfirst($pickup->status) }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td>{{ $pickup->catatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Bukti</th>
                <td>
                    @if($pickup->bukti)
                        <a href="{{ asset('storage/'.$pickup->bukti) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                           Lihat Bukti
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>

        <a href="{{ route('pickup.index') }}"
           class="btn btn-secondary mt-3">
           Kembali
        </a>

    </div>
</div>
@endsection
