@extends('layouts.app')

@section('title', 'Daftar Production')
@section('page-title', 'Daftar Production')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Daftar Production</h5>
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
                    <th>Customer</th>
                    <th>Catatan</th>
                    <th>File Hasil</th>
                    <th>Deadline</th>
                    <th>Status Production</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($productions as $production)

                @php
                    $design = $production->order->design;
                @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $production->order->invoice_number }}</td>

                    <td>{{ $production->order->customer->nama }}</td>

                    <td>{{ $design->catatan ?? '-' }}</td>

                    {{-- FILE HASIL DESIGN --}}
                    <td>
                        @if($design?->file_hasil)
                            <a href="{{ asset('storage/'.$design->file_hasil) }}"
                               target="_blank"
                               class="btn btn-sm btn-success">
                               Lihat
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    {{-- DEADLINE --}}
                    <td>
                        {{ $production->order->deadline
                            ? $production->order->deadline->format('d/m/Y')
                            : '-' }}
                    </td>

                    {{-- STATUS PRODUCTION --}}
                    <td>
                        <span class="badge
                            @if($production->status == 'menunggu') bg-warning
                            @elseif($production->status == 'proses') bg-info
                            @elseif($production->status == 'selesai') bg-success
                            @endif">
                            {{ ucfirst($production->status) }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('productions.edit',$production->id) }}"
                           class="btn btn-warning btn-sm">
                           Update
                        </a>

                        <a href="{{ route('orders.show',$production->order_id) }}"
                           class="btn btn-info btn-sm">
                           Order
                        </a>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Belum ada data production
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
