@extends('layouts.app')

@section('title', 'Inventory')
@section('page-title', 'Data Inventory')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h5>Daftar Inventory</h5>
    <a href="{{ route('inventories.create') }}" class="btn btn-primary">
        + Tambah Inventory
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
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
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jenis_barang }}</td>
                    <td>{{ $item->pic_barang ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $item->jumlah > 0 ? 'success' : 'danger' }}">
                            {{ $item->jumlah }}
                        </span>
                    </td>
                    <td>{{ $item->kondisi ?? '-' }}</td>
                    <td>
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
                              class="d-inline"
                              onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Belum ada data inventory
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
