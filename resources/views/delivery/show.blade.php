@extends('layouts.app')

@section('title', 'Detail Pengiriman')
@section('page-title', 'Detail Pengiriman')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Surat Jalan</h5>
        <a href="{{ route('delivery_notes.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card-body">
        <p><strong>Customer:</strong> {{ $deliveryNote->customerName() }}</p>
        <p><strong>No Invoice:</strong> {{ $deliveryNote->invoiceNumber() }}</p>
        <p><strong>Pengirim:</strong> {{ $deliveryNote->nama_pengirim ?? '-' }}</p>
        <p><strong>Driver:</strong> {{ $deliveryNote->driver ?? '-' }}</p>
        <p><strong>Tanggal Kirim:</strong> {{ $deliveryNote->tanggal_kirim?->format('d M Y') ?? '-' }}</p>

        <hr>

        <p><strong>TTD Admin:</strong><br>{{ $deliveryNote->ttd_admin ?? '-' }}</p>
        <p><strong>TTD Penerima:</strong><br>{{ $deliveryNote->ttd_penerima ?? '-' }}</p>
    </div>
</div>
@endsection
