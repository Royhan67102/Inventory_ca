@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ========================= --}}
{{-- CARD STATISTIK --}}
{{-- ========================= --}}
<div class="row g-3 mb-4">

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body py-3">
                <small class="text-muted d-block">Hari Ini</small>
                <h5 class="mb-0 fw-semibold">Rp {{ number_format($today ?? 0) }}</h5>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body py-3">
                <small class="text-muted d-block">Minggu Ini</small>
                <h5 class="mb-0 fw-semibold">Rp {{ number_format($week ?? 0) }}</h5>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body py-3">
                <small class="text-muted d-block">Bulan Ini</small>
                <h5 class="mb-0 fw-semibold">Rp {{ number_format($month ?? 0) }}</h5>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body py-3">
                <small class="text-muted d-block">Tahun Ini</small>
                <h5 class="mb-0 fw-semibold">Rp {{ number_format($year ?? 0) }}</h5>
            </div>
        </div>
    </div>

</div>


{{-- ========================= --}}
{{-- GRAFIK PENJUALAN --}}
{{-- ========================= --}}
<div class="card mb-4 shadow-sm border-0">
    <div class="card-body">
        <h6 class="mb-3 fw-semibold">
            Grafik Penjualan
            ({{ $from->format('d M Y') }} - {{ $to->format('d M Y') }})
        </h6>

        <div style="height:260px;" class="mt-2">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
</div>


{{-- ========================= --}}
{{-- STATUS --}}
{{-- ========================= --}}
<div class="row g-3 mb-4">

    <div class="col-12 col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h6 class="fw-semibold">Status Pembayaran</h6>
                <ul class="mb-0 ps-3">
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

    <div class="col-12 col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h6 class="fw-semibold">Status Produksi</h6>
                <ul class="mb-0 ps-3">
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
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-0 pb-0 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 fw-semibold">
        <span>Riwayat Produksi</span>

        <a href="{{ route('dashboard.exportProduksiExcel') }}" class="btn btn-sm btn-success">
            <i class="bi bi-download"></i> Download Excel
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead class="table-light">
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
                    <td class="text-nowrap">{{ $order->customer->nama }}</td>
                    <td class="text-nowrap">{{ $order->customer->telepon }}</td>
                    <td>{{ $order->customer->alamat }}</td>
                    <td class="text-nowrap">{{ $order->tanggal_pemesanan->format('d M Y') }}</td>
                    <td class="text-nowrap">{{ strtoupper(str_replace('_', ' ', $order->payment_status)) }}</td>
                    <td class="text-nowrap">Rp {{ number_format($order->total_harga) }}</td>
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
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

@endsection
