@extends('layouts.app')

@section('title', 'Update Status Produksi')
@section('page-title', 'Update Status Produksi')

@section('content')
<form method="POST" action="{{ route('productions.update', $production) }}">
@csrf
@method('PUT')

<div class="card shadow-sm">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Update Status Produksi</h6>

        {{-- INFO ORDER --}}
        <div class="mb-3">
            <label class="form-label">Order</label>
            <input type="text" class="form-control" disabled
                value="{{ $production->order->customer->nama ?? '-' }} | {{ $production->order->tanggal_pemesanan?->format('d M Y') }}">
        </div>

        {{-- STATUS --}}
        <div class="mb-3">
            <label class="form-label">Status Produksi</label>
            <select name="status" class="form-select" required>
                <option value="menunggu" @selected($production->status=='menunggu')>Menunggu</option>
                <option value="proses" @selected($production->status=='proses')>Proses</option>
                <option value="selesai" @selected($production->status=='selesai')>Selesai</option>
            </select>
        </div>

        {{-- CATATAN --}}
        <div class="mb-3">
            <label class="form-label">Catatan Produksi</label>
            <textarea name="catatan" class="form-control" rows="3">{{ $production->catatan }}</textarea>
        </div>

        <div class="text-end">
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('productions.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </div>
</div>
</form>
@endsection
