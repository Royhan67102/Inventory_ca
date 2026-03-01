@extends('layouts.app')

@section('title', 'Daftar Desain')
@section('page-title', 'Daftar Desain')

@section('content')

<style>
.design-table th,
.design-table td {
    border: 1px solid #dee2e6 !important;
    vertical-align: middle;
    white-space: nowrap;
}

/* Supaya text panjang tidak merusak layout */
.design-table td {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Responsive */
.table-responsive-custom {
    width: 100%;
    overflow-x: auto;
}

@media(max-width:768px){

    .design-table th,
    .design-table td {
        font-size: 12px;
        padding: 6px;
    }

    .btn-sm {
        padding: 3px 6px;
        font-size: 11px;
    }

    .action-btn-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
}
</style>

<div class="row">
<div class="col-12">

<div class="card">

<div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Daftar Desain</h5>
</div>

<div class="card-body">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive-custom">
<table class="table table-bordered design-table">

<thead class="table-light text-center">
<tr>
    <th>#</th>
    <th>Kode</th>
    <th>Customer</th>
    <th>Status</th>
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

<td class="text-center">{{ $loop->iteration }}</td>

<td class="text-center">
    {{ $design->order->invoice_number ?? '-' }}
</td>

<td>
    {{ $design->order->customer->nama ?? '-' }}
</td>

<td class="text-center">
    <span class="badge
        @if($design->status === 'menunggu') bg-warning
        @elseif($design->status === 'proses') bg-info
        @elseif($design->status === 'selesai') bg-success
        @endif">
        {{ ucfirst($design->status) }}
    </span>
</td>

<td>{{ $design->designer ?? '-' }}</td>

<td title="{{ $design->catatan }}">
    {{ $design->catatan ?? '-' }}
</td>

<td class="text-center">
@if($design->file_awal)
<a href="{{ asset('storage/'.$design->file_awal) }}"
   target="_blank"
   class="btn btn-outline-primary btn-sm">
   Lihat
</a>
@else
-
@endif
</td>

<td class="text-center">
@if($design->file_hasil)
<a href="{{ asset('storage/'.$design->file_hasil) }}"
   target="_blank"
   class="btn btn-outline-success btn-sm">
   Lihat
</a>
@else
-
@endif
</td>

<td class="text-center">
{{ $design->order->deadline
    ? $design->order->deadline->format('d/m/Y')
    : '-' }}
</td>

<td>
<div class="action-btn-group text-center">

<a href="{{ route('designs.show',$design->id) }}"
   class="btn btn-primary btn-sm">
   Detail
</a>

<a href="{{ route('designs.edit', $design->id) }}"
   class="btn btn-warning btn-sm">
   Update
</a>

<a href="{{ route('orders.show', $design->order_id) }}"
   class="btn btn-info btn-sm">
   Order
</a>

</div>
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
</div>

<div class="mt-3">
    {{ $designs->appends(request()->query())->links() }}
</div>

</div>
</div>
</div>
</div>

@endsection
