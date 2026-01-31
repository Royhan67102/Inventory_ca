@extends('layouts.app')

@section('title', 'Daftar Desain')
@section('page-title', 'Daftar Desain')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Desain</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Nama Customer</th>
                            <th>Status Desain</th>
                            <th>Designer</th>
                            <th>Catatan</th>
                            <th>File Awal</th>
                            <th>File Hasil</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($designs as $design)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $design->order_id }}</td>
                            <td>{{ $design->order?->customer?->name ?? '-' }}</td>
                            <td>
                                <span class="badge
                                    @if($design->status == 'menunggu') bg-warning
                                    @elseif($design->status == 'proses') bg-info
                                    @elseif($design->status == 'selesai') bg-success
                                    @endif">
                                    {{ ucfirst($design->status) }}
                                </span>
                            </td>
                            <td>{{ $design->designer ?? '-' }}</td>
                            <td>{{ $design->catatan ?? '-' }}</td>
                            <td>
                                @if($design->file_awal)
                                    <a href="{{ asset('storage/' . $design->file_awal) }}" target="_blank">Lihat File</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($design->file_hasil)
                                    <a href="{{ asset('storage/' . $design->file_hasil) }}" target="_blank">Lihat Hasil</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $design->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('designs.edit', $design->order_id) }}" class="btn btn-sm btn-warning">Update</a>
                                <a href="{{ route('designs.show', $design->id) }}" class="btn btn-sm btn-info">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Belum ada desain</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{-- Jika menggunakan pagination: $designs->links() --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
