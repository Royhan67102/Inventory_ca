@extends('layouts.app')

@section('title', 'Detail Desain')
@section('page-title', 'Detail Desain')

@section('content')

<style>
.detail-table th,
.detail-table td {
    border: 1px solid #dee2e6 !important;
    padding: 10px;
    vertical-align: middle;
}

.detail-table th {
    width: 35%;
    background: #f8f9fa;
    font-weight: 600;
}

@media(max-width:768px){
    .detail-table th,
    .detail-table td {
        font-size: 13px;
        padding: 8px;
    }

    .detail-table th {
        width: 45%;
    }
}
</style>

<div class="row justify-content-center">
<div class="col-lg-8 col-md-10 col-12">

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center flex-wrap">
    <h5 class="mb-2 mb-md-0">
        Detail Desain - Order #{{ $design->order_id }}
    </h5>

    <a href="{{ route('designs.index') }}" class="btn btn-secondary btn-sm">
        Kembali
    </a>
</div>

<div class="card-body">

{{-- ================= INFO ORDER ================= --}}
<h6 class="fw-bold mb-2">Info Order</h6>

<div class="table-responsive">
<table class="table detail-table">

<tr>
<th>Order ID</th>
<td>{{ $design->order_id }}</td>
</tr>

<tr>
<th>Nama Customer</th>
<td>{{ $design->order?->customer?->nama ?? '-' }}</td>
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
</div>

{{-- ================= INFO DESAIN ================= --}}
<h6 class="fw-bold mt-4 mb-2">Info Desain</h6>

<div class="table-responsive">
<table class="table detail-table">

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
<a href="{{ asset('storage/' . $design->file_awal) }}" target="_blank"
   class="btn btn-sm btn-outline-primary">
   Lihat File
</a>
@else
-
@endif
</td>
</tr>

<tr>
<th>File Hasil</th>
<td>
@if($design->file_hasil)
<a href="{{ asset('storage/' . $design->file_hasil) }}" target="_blank"
   class="btn btn-sm btn-outline-success">
   Lihat File
</a>
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
</div>

@endsection