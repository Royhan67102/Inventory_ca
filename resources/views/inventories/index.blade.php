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

.table-wrapper {
    overflow-x: auto;
}

.inventory-table {
    min-width: 900px; /* supaya bisa scroll di HP */
}
</style>

<div class="mb-3">

    <h5 class="mb-2">Daftar Inventory</h5>

    <div class="d-flex gap-2">
        <a href="{{ route('inventories.create') }}" class="btn btn-primary">
            + Tambah Inventory
        </a>

        <a href="{{ route('inventories.export') }}" class="btn btn-success">
            Download Excel
        </a>
    </div>

</div>

<div class="card shadow-sm">
<div class="card-body">

<div class="table-wrapper">
<table class="table align-middle inventory-table">
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

<div class="mt-3">
    {{ $inventories->appends(request()->query())->links() }}
</div>

</div>
</div>

@endsection
