@extends('layouts.app')

@section('title', 'Detail Inventory')
@section('page-title', 'Detail Inventory')

@section('content')

{{-- Tombol Kembali --}}
<div class="mb-3">
    <a href="{{ route('inventories.index') }}" class="btn btn-secondary">
        ← Kembali ke Data Inventory
    </a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Informasi Barang</h6>
                <p><b>Nama:</b> {{ $inventory->nama_barang }}</p>
                <p><b>Jenis:</b> {{ $inventory->jenis_barang }}</p>
                <p><b>Stok:</b> {{ $inventory->jumlah }}</p>
                <p><b>Kondisi:</b> {{ $inventory->kondisi }}</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Update Stok</h6>
                <form method="POST" action="{{ route('inventories.updateStock', $inventory->id) }}">
                    @csrf

                    <select name="tipe" class="form-control mb-2">
                        <option value="masuk">Stok Masuk</option>
                        <option value="keluar">Stok Keluar</option>
                    </select>

                    <input type="number" name="jumlah" class="form-control mb-2" placeholder="Jumlah" required>

                    <input type="text" name="keterangan" class="form-control mb-2" placeholder="Keterangan">

                    <button class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Riwayat Stok</h6>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventory->histories as $row)
                        <tr>
                            <td>{{ $row->tanggal }}</td>
                            <td>
                                <span class="badge bg-{{ $row->tipe == 'masuk' ? 'success' : 'danger' }}">
                                    {{ strtoupper($row->tipe) }}
                                </span>
                            </td>
                            <td>{{ $row->jumlah }}</td>
                            <td>{{ $row->keterangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection
