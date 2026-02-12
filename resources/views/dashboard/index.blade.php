@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ========================= --}}
{{-- CARD STATISTIK --}}
{{-- ========================= --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Hari Ini</small>
                <h5 class="mb-0">Rp {{ number_format($today ?? 0) }}</h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Minggu Ini</small>
                <h5 class="mb-0">Rp {{ number_format($week ?? 0) }}</h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Bulan Ini</small>
                <h5 class="mb-0">Rp {{ number_format($month ?? 0) }}</h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Tahun Ini</small>
                <h5 class="mb-0">Rp {{ number_format($year ?? 0) }}</h5>
            </div>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{-- GRAFIK PENJUALAN --}}
{{-- ========================= --}}
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h6 class="mb-3">
            Grafik Penjualan
            ({{ $from->format('d M Y') }} - {{ $to->format('d M Y') }})
        </h6>
        <canvas id="salesChart" height="100"></canvas>
    </div>
</div>

{{-- ========================= --}}
{{-- STATUS --}}
{{-- ========================= --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6>Status Pembayaran</h6>
                <ul class="mb-0">
                    @php
                        $paymentLabel = [
                            'belum_bayar' => 'Belum Bayar',
                            'dp' => 'DP',
                            'lunas' => 'Lunas'
                        ];
                    @endphp

                    @forelse($paymentStatus as $status => $total)
                        <li>{{ $paymentLabel[$status] ?? ucfirst($status) }} : {{ $total }}</li>
                    @empty
                        <li class="text-muted">Belum ada data</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6>Status Produksi</h6>
                <ul class="mb-0">
                    @forelse($productionStatus as $status => $total)
                        <li>{{ ucfirst($status) }} : {{ $total }}</li>
                    @empty
                        <li class="text-muted">Belum ada data</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- ========================= --}}
{{-- RIWAYAT PRODUKSI --}}
{{-- ========================= --}}
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center fw-bold">
        <span>Riwayat Produksi</span>
        {{-- Tombol Download Excel --}}
        <a href="{{ route('dashboard.exportProduksiExcel') }}" class="btn btn-sm btn-success">
            <i class="bi bi-download"></i> Download Excel
        </a>
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. Telp</th>
                    <th>Alamat</th>
                    <th>Tanggal Pesan</th>
                    <th>Status Pembayaran</th>
                    <th>Total Harga</th>
                </tr>
            </thead>

            <tbody>
            @forelse($productionHistory as $order)
            <tr>
                <td>{{ $order->customer->nama }}</td>
                <td>{{ $order->customer->telepon }}</td>
                <td>{{ $order->customer->alamat }}</td>
                <td>{{ $order->tanggal_pemesanan->format('d M Y') }}</td>
                <td>{{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}</td>
                <td>Rp {{ number_format($order->total_harga) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    Belum ada riwayat produksi
                </td>
            </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

{{-- ========================= --}}
{{-- CHART JS --}}
{{-- ========================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesChart->pluck('tanggal')) !!},
            datasets: [{
                label: 'Penjualan',
                data: {!! json_encode($salesChart->pluck('total')) !!},
                borderWidth: 2,
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

@endsection
