@extends('layouts.app')

@section('title', 'Detail Stok Acrylic')
@section('page-title', 'Detail Stok Acrylic')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-3">
            {{ $acrylic_stock->merk }}
            {{ $acrylic_stock->warna ? ' - '.$acrylic_stock->warna : '' }}
        </h5>

        <table class="table table-bordered">
            <tr>
                <th>Jenis</th>
                <td>{{ ucfirst($acrylic_stock->jenis) }}</td>
            </tr>
            <tr>
                <th>Ukuran</th>
                <td>{{ $acrylic_stock->panjang }} × {{ $acrylic_stock->lebar }} cm</td>
            </tr>
            <tr>
                <th>Ketebalan</th>
                <td>{{ $acrylic_stock->ketebalan }} mm</td>
            </tr>
            <tr>
                <th>Luas Total</th>
                <td>{{ number_format($acrylic_stock->luas_total / 10000, 4) }} m²</td>
            </tr>
            <tr>
                <th>Luas Tersedia</th>
                <td>{{ number_format($acrylic_stock->luas_tersedia / 10000, 4) }} m²</td>
            </tr>
            <tr>
                <th>Jumlah Lembar</th>
                <td>{{ $acrylic_stock->jumlah_lembar }}</td>
            </tr>
        </table>

        <a href="{{ route('acrylic-stocks.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h6>Riwayat Sisa / Limbah</h6>

        @if($acrylic_stock->wastes->isEmpty())
            <p class="text-muted">Belum ada sisa potongan</p>
        @else
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Luas Sisa (m²)</th>
                    <th>Status</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($acrylic_stock->wastes as $waste)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ number_format($waste->luas_sisa / 10000, 4) }}</td>
                    <td>
                        <span class="badge bg-{{ $waste->terpakai ? 'danger' : 'success' }}">
                            {{ $waste->terpakai ? 'Terpakai' : 'Tersedia' }}
                        </span>
                    </td>
                    <td>{{ $waste->orderItem->order->invoice_number ?? '-' }}</td>
                    <td>{{ $waste->orderItem->order->customer->nama ?? '-' }}</td>
                    <td>{{ $waste->created_at->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
