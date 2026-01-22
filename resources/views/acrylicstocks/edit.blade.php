@extends('layouts.app')

@section('title', 'Edit Stok Acrylic')
@section('page-title', 'Edit Stok Acrylic')

@section('content')
@php
    $locked = $acrylic_stock->luas_tersedia < $acrylic_stock->luas_total;
@endphp

<form action="{{ route('acrylic-stocks.update', $acrylic_stock) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Merk</label>
            <input type="text" name="merk" class="form-control"
                value="{{ $acrylic_stock->merk }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Warna</label>
            <input type="text" name="warna" class="form-control"
                value="{{ $acrylic_stock->warna }}">
        </div>

        <div class="col-md-6 mb-3">
            <label>Jenis</label>
            <select name="jenis" class="form-control">
                <option value="lembar" {{ $acrylic_stock->jenis == 'lembar' ? 'selected' : '' }}>Lembar</option>
                <option value="sisa" {{ $acrylic_stock->jenis == 'sisa' ? 'selected' : '' }}>Sisa</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Ketebalan (mm)</label>
            <input type="number" step="0.01" name="ketebalan" class="form-control"
                value="{{ $acrylic_stock->ketebalan }}" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Panjang (cm)</label>
            <input type="number" step="0.01" name="panjang" class="form-control"
                value="{{ $acrylic_stock->panjang }}" {{ $locked ? 'readonly' : '' }}>
        </div>

        <div class="col-md-4 mb-3">
            <label>Lebar (cm)</label>
            <input type="number" step="0.01" name="lebar" class="form-control"
                value="{{ $acrylic_stock->lebar }}" {{ $locked ? 'readonly' : '' }}>
        </div>

        <div class="col-md-4 mb-3">
            <label>Jumlah Lembar</label>
            <input type="number" name="jumlah_lembar" class="form-control"
                value="{{ $acrylic_stock->jumlah_lembar }}" {{ $locked ? 'readonly' : '' }}>
        </div>
    </div>

    <div class="mb-3">
        <label>Luas Total (m²)</label>
        <input type="text" class="form-control"
            value="{{ number_format($acrylic_stock->luas_total / 10000, 2) }}" readonly>
    </div>

    <div class="text-end">
        <button class="btn btn-success">Update</button>
        <a href="{{ route('acrylic-stocks.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</form>
@endsection
