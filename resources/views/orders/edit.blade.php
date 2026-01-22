@extends('layouts.app')

@section('title', 'Edit Order')
@section('page-title', 'Edit Order')

@section('content')
<form action="{{ route('orders.update', $order) }}" method="POST">
@csrf
@method('PUT')

<div class="card shadow-sm">
    <div class="card-body">
        <h6 class="fw-bold">Update Order</h6>

        <div class="mb-3">
            <label class="form-label">Status Pembayaran</label>
            <select name="payment_status" class="form-select">
                <option value="belum_bayar" @selected($order->payment_status=='belum_bayar')>Belum Bayar</option>
                <option value="dp" @selected($order->payment_status=='dp')>DP</option>
                <option value="lunas" @selected($order->payment_status=='lunas')>Lunas</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" value="{{ $order->deadline?->format('Y-m-d') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="catatan" class="form-control" rows="3">{{ $order->catatan }}</textarea>
        </div>

        <div class="text-end">
            <button class="btn btn-success">Update</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </div>
</div>
</form>
@endsection
