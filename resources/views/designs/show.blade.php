@extends('layouts.app')

@section('title', 'Detail Desain')
@section('page-title', 'Detail Desain')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Detail Desain - Order #{{ $design->order_id }}</h5>
                <a href="{{ route('designs.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="card-body">

                {{-- Info Order --}}
                <h6 class="fw-bold">Info Order</h6>
                <table class="table table-borderless table-sm mb-3">
                    <tr>
                        <th>Order ID</th>
                        <td>{{ $design->order_id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Customer</th>
                        <td>{{ $design->order?->customer?->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ ucfirst($design->order?->kategori ?? '-') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Order</th>
                        <td>{{ $design->order?->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                </table>

                {{-- Info Desain --}}
                <h6 class="fw-bold">Info Desain</h6>
                <table class="table table-borderless table-sm">
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge
                                @if($design->status == 'menunggu') bg-warning
                                @elseif($design->status == 'proses') bg-info
                                @elseif($design->status == 'selesai') bg-success
                                @endif">
                                {{ ucfirst($design->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Designer</th>
                        <td>{{ $design->designer ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $design->catatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>File Awal</th>
                        <td>
                            @if($design->file_awal)
                                <a href="{{ asset('storage/' . $design->file_awal) }}" target="_blank">Lihat File</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>File Hasil</th>
                        <td>
                            @if($design->file_hasil)
                                <a href="{{ asset('storage/' . $design->file_hasil) }}" target="_blank">Lihat File</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td>{{ $design->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diperbarui</th>
                        <td>{{ $design->updated_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
