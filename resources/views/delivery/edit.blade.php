@extends('layouts.app')

@section('title', 'Update Pengiriman')
@section('page-title', 'Update Pengiriman')

@section('content')
<form action="{{ route('delivery_notes.update', $deliveryNote) }}" method="POST">
@csrf
@method('PUT')

<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="mb-4">Update Status Pengiriman</h5>

        {{-- INFO ORDER (READ ONLY) --}}
        <div class="mb-3">
            <label>Customer</label>
            <input type="text" class="form-control" value="{{ $deliveryNote->customerName() }}" readonly>
        </div>

        <div class="mb-3">
            <label>No Invoice</label>
            <input type="text" class="form-control" value="{{ $deliveryNote->invoiceNumber() }}" readonly>
        </div>

        <hr>

        {{-- DATA PENGIRIMAN --}}
        <div class="mb-3">
            <label>Nama Pengirim</label>
            <input type="text" name="nama_pengirim" class="form-control"
                   value="{{ old('nama_pengirim', $deliveryNote->nama_pengirim) }}">
        </div>

        <div class="mb-3">
            <label>Driver</label>
            <input type="text" name="driver" class="form-control"
                   value="{{ old('driver', $deliveryNote->driver) }}">
        </div>

        <div class="mb-3">
            <label>Tanggal Kirim</label>
            <input type="date" name="tanggal_kirim" class="form-control"
                   value="{{ old('tanggal_kirim', $deliveryNote->tanggal_kirim?->format('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label>TTD Admin</label>
            <textarea name="ttd_admin" class="form-control" rows="3">{{ old('ttd_admin', $deliveryNote->ttd_admin) }}</textarea>
        </div>

        <div class="mb-3">
            <label>TTD Penerima</label>
            <textarea name="ttd_penerima" class="form-control" rows="3">{{ old('ttd_penerima', $deliveryNote->ttd_penerima) }}</textarea>
        </div>

        <div class="text-end">
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('delivery_notes.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </div>
</div>
</form>
@endsection
