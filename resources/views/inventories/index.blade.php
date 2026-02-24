@extends('layouts.app')

@section('title', 'Inventory')
@section('page-title', 'Data Inventory')

@section('content')

<style>
.table-box {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 8px;
    background: #fafafa;
    min-height: 55px;
    display: flex;
    align-items: center;
}

.table-responsive-card {
    border: 1px solid #dee2e6;
    border-radius: 10px;
    padding: 10px;
    background: white;
}

@media(max-width:768px){

    .desktop-table {
        display: none;
    }

    .mobile-card {
        display: block;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 12px;
        background: #fff;
    }

}

@media(min-width:769px){
    .mobile-card {
        display: none;
    }
}
</style>

<div class="d-flex flex-wrap justify-content-between mb-3 gap-2">
    <h5>Daftar Inventory</h5>
    <a href="{{ route('inventories.create') }}" class="btn btn-primary">
        + Tambah Inventory
    </a>
</div>

<div class="card shadow-sm">
<div class="card-body">

<div class="table-responsive desktop-table">
<table class="table align-middle">
    <thead class="table-light">
        <tr>
            <th>Nama Barang</th>
            <th>Jenis Barang</th>
            <th>PIC</th>
            <th>Stok</th>
            <th>Kondisi</th>
            <th width="180">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($inventories as $item)
        <tr>
            <td><div class="table-box">{{ $item->nama_barang }}</div></td>
            <td><div class="table-box">{{ $item->jenis_barang }}</div></td>
            <td><div class="table-box">{{ $item->pic_barang ?? '-' }}</div></td>

            <td>
                <div class="table-box">
                    <span class="badge bg-{{ $item->jumlah > 0 ? 'success' : 'danger' }}">
                        {{ $item->jumlah }}
                    </span>
                </div>
            </td>

            <td><div class="table-box">{{ $item->kondisi ?? '-' }}</div></td>

            <td>
                <div class="table-box d-flex gap-1 flex-wrap">
                    <a href="{{ route('inventories.show', $item->id) }}"
                       class="btn btn-sm btn-info">
                        Detail
                    </a>

                    <a href="{{ route('inventories.edit', $item->id) }}"
                       class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form action="{{ route('inventories.destroy', $item->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            Hapus
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted">
                Belum ada data inventory
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>

{{-- MOBILE VIEW --}}
@foreach($inventories as $item)
<div class="mobile-card">
    <div class="table-box mb-2"><b>Nama:</b> {{ $item->nama_barang }}</div>
    <div class="table-box mb-2"><b>Jenis:</b> {{ $item->jenis_barang }}</div>
    <div class="table-box mb-2"><b>PIC:</b> {{ $item->pic_barang ?? '-' }}</div>
    <div class="table-box mb-2">
        <b>Stok:</b>
        <span class="badge bg-{{ $item->jumlah > 0 ? 'success' : 'danger' }}">
            {{ $item->jumlah }}
        </span>
    </div>
    <div class="table-box mb-2"><b>Kondisi:</b> {{ $item->kondisi ?? '-' }}</div>

    <div class="d-flex gap-2 mt-2 flex-wrap">
        <a href="{{ route('inventories.show', $item->id) }}"
           class="btn btn-sm btn-info">
            Detail
        </a>

        <a href="{{ route('inventories.edit', $item->id) }}"
           class="btn btn-sm btn-warning">
            Edit
        </a>

        <form action="{{ route('inventories.destroy', $item->id) }}"
              method="POST"
              onsubmit="return confirm('Yakin hapus data ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">
                Hapus
            </button>
        </form>
    </div>
</div>
@endforeach

</div>
</div>

@endsection