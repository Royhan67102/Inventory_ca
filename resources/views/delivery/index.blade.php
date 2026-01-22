@extends('layouts.app')

@section('title', 'Daftar Pengiriman')
@section('page-title', 'Daftar Pengiriman')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Pengirim</th>
                    <th>Driver</th>
                    <th>Tanggal Kirim</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($deliveryNotes as $dn)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dn->order->customer->nama }}</td>
                        <td>{{ $dn->nama_pengirim ?? '-' }}</td>
                        <td>{{ $dn->driver ?? '-' }}</td>
                        <td>{{ $dn->tanggal_kirim?->format('d M Y') ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('delivery.show', $dn) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('delivery.edit', $dn) }}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('delivery.print', $dn) }}" class="btn btn-secondary btn-sm">PDF</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Belum ada data pengiriman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
