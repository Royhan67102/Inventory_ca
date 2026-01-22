@extends('layouts.app')

@section('title', 'Tambah Inventory')
@section('page-title', 'Tambah Inventory')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST" action="{{ route('inventories.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Barang</label>
                    <input type="text" name="jenis_barang" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Jumlah Awal</label>
                    <input type="number" name="jumlah" class="form-control" value="0">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Kondisi</label>
                    <input type="text" name="kondisi" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>PIC Barang</label>
                    <input type="text" name="pic_barang" class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>
@endsection
