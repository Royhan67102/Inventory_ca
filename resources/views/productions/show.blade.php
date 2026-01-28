@extends('layouts.app')

@section('title', 'Detail Produksi')
@section('page-title', 'Detail Produksi')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Detail Produksi</h6>
        <a href="{{ route('productions.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card-body">
        <p><strong>Customer:</strong> {{ $production->order->customer->nama ?? '-' }}</p>
        <p><strong>Tanggal Order:</strong> {{ $production->order->tanggal_pemesanan?->format('d M Y') }}</p>
        <p><strong>Deadline:</strong> {{ $production->order->deadline?->format('d M Y') ?? '-' }}</p>

        <hr>

        <p><strong>Tim Produksi:</strong> {{ $production->tim_produksi ?? '-' }}</p>
        <p><strong>Status:</strong>
            <span class="badge bg-{{ $production->status=='selesai'?'success':($production->status=='proses'?'warning':'secondary') }}">
                {{ ucfirst($production->status) }}
            </span>
        </p>

        <hr>

        <p><strong>Catatan Produksi:</strong></p>
        <p>{{ $production->catatan ?? '-' }}</p>
    </div>
</div>
@endsection
