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
                            <th>Kode</th>
                            <th>Nama Customer</th>
                            <th>Status Desain</th>
                            <th>Designer</th>
                            <th>Catatan</th>
                            <th>File Awal</th>
                            <th>File Hasil</th>
                            <th>Deadline</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($designs as $design)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                                {{-- KODE ORDER --}}
                            <td>
                            {{ $design->order->invoice_number ?? '-' }}
                            </td>

                        {{-- CUSTOMER --}}
                            <td>
                                {{ $design->order->customer->nama ?? '-' }}
                            </td>

                        {{-- STATUS DESAIN --}}
                            <td>
                                <span class="badge
                                    @if($design->status === 'menunggu') bg-warning
                                    @elseif($design->status === 'proses') bg-info
                                    @elseif($design->status === 'selesai') bg-success
                                    @endif
                                ">
                                {{ ucfirst($design->status) }}
                            </span>
                        </td>

                        {{-- DESIGNER --}}
                        <td>{{ $design->designer ?? '-' }}</td>

                        {{-- CATATAN --}}
                        <td>{{ $design->catatan ?? '-' }}</td>

                        {{-- FILE AWAL --}}
                        <td class="text-center">
                            @if($design->file_awal)
                                <a href="{{ asset('storage/'.$design->file_awal) }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                    Lihat
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        {{-- FILE HASIL --}}
                        <td class="text-center">
                            @if($design->file_hasil)
                                <a href="{{ asset('storage/'.$design->file_hasil) }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-success">
                                    Lihat
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        {{-- DEADLINE (AMBIL DARI ORDER) --}}
                        <td>
                            {{ $design->order->deadline
                                ? $design->order->deadline->format('d/m/Y')
                                : '-' }}
                        </td>

                        {{-- AKSI --}}
                        <td class="text-nowrap">
                            <a href="{{ route('designs.edit', $design->id) }}"
                            class="btn btn-sm btn-warning">
                                Update
                            </a>

                            <a href="{{ route('orders.show', $design->order_id) }}"
                            class="btn btn-sm btn-info">
                                Order
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">
                            Belum ada data desain
                        </td>
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
