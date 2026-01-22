@extends('layouts.app')

@section('title', 'Edit Inventory')
@section('page-title', 'Edit Inventory')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <form action="{{ route('inventories.update', $inventory->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Nama Barang</label>
                    <input
                        type="text"
                        name="nama_barang"
                        class="form-control"
                        value="{{ old('nama_barang', $inventory->nama_barang) }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Barang</label>
                    <input
                        type="text"
                        name="jenis_barang"
                        class="form-control"
                        value="{{ old('jenis_barang', $inventory->jenis_barang) }}"
                        required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>PIC Barang</label>
                    <input
                        type="text"
                        name="pic_barang"
                        class="form-control"
                        value="{{ old('pic_barang', $inventory->pic_barang) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Kondisi</label>
                    <input
                        type="text"
                        name="kondisi"
                        class="form-control"
                        value="{{ old('kondisi', $inventory->kondisi) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Stok Saat Ini</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ $inventory->jumlah }}"
                        readonly>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea
                        name="deskripsi"
                        class="form-control"
                        rows="3">{{ old('deskripsi', $inventory->deskripsi) }}</textarea>
                </div>

            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('inventories.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
