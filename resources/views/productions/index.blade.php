@extends('layouts.app')

@section('title', 'Daftar Produksi')
@section('page-title', 'Daftar Produksi')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h6 class="mb-0">Daftar Produksi</h6>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Deadline</th>
                    <th>Tim Produksi</th>
                    <th>Status</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productions as $prod)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $prod->order->customer->nama ?? '-' }}</td>
                    <td class="text-center">
                        {{ $prod->order->deadline?->format('d M Y') ?? '-' }}
                    </td>
                    <td>{{ $prod->tim_produksi ?? '-' }}</td>
                    <td class="text-center">
                        @php
                            $badge = match($prod->status) {
                                'menunggu' => 'secondary',
                                'proses' => 'warning',
                                'selesai' => 'success',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $badge }}">{{ ucfirst($prod->status) }}</span>
                    </td>
                    <td class="text-center">{{ $prod->tanggal_mulai?->format('d M Y') ?? '-' }}</td>
                    <td class="text-center">{{ $prod->tanggal_selesai?->format('d M Y') ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('productions.show', $prod) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('productions.edit', $prod) }}" class="btn btn-primary btn-sm">Update</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada produksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
