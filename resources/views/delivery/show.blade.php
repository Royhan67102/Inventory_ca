@extends('layouts.app')

@section('title', 'Detail Delivery')
@section('page-title', 'Detail Delivery')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Delivery - Invoice {{ $delivery->order->invoice_number }}</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Customer</th>
                <td>{{ $delivery->order->customer->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Driver</th>
                <td>{{ $delivery->driver ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Kirim</th>
                <td>{{ optional($delivery->tanggal_kirim)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($delivery->status) }}</td>
            </tr>
            <tr>
                <th>Bukti Foto</th>
                <td>
                    @if($delivery->bukti_foto)
                        <a href="{{ asset('storage/'.$delivery->bukti_foto) }}"
                           target="_blank">Lihat</a>
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>

        <a href="{{ route('delivery.index') }}"
           class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
