@extends('layouts.app')

@section('title', 'Tambah Stok Acrylic')
@section('page-title', 'Tambah Stok Acrylic')

@section('content')
<form action="{{ route('acrylic-stocks.store') }}" method="POST" id="acrylicForm">
    @csrf

    <input type="hidden" name="luas_total">
    <input type="hidden" name="luas_tersedia">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Merk</label>
            <input type="text" name="merk" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Warna</label>
            <input type="text" name="warna" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Jenis</label>
            <select name="jenis" class="form-control" required>
                <option value="lembar">Lembar</option>
                <option value="sisa">Sisa</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Ketebalan (mm)</label>
            <input type="number" step="0.01" name="ketebalan" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Panjang (cm)</label>
            <input type="number" step="0.01" name="panjang" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Lebar (cm)</label>
            <input type="number" step="0.01" name="lebar" class="form-control" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Jumlah Lembar</label>
            <input type="number" name="jumlah_lembar" class="form-control" min="1" value="1" required>
        </div>
    </div>

    <div class="mb-3">
        <label>Luas Total (m²)</label>
        <input type="text" id="luas_total_display" class="form-control" readonly>
    </div>

    <div class="text-end">
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('acrylic-stocks.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</form>

<script>
const panjang = document.querySelector('[name="panjang"]');
const lebar = document.querySelector('[name="lebar"]');
const jumlah = document.querySelector('[name="jumlah_lembar"]');
const luasTotal = document.querySelector('[name="luas_total"]');
const luasTersedia = document.querySelector('[name="luas_tersedia"]');
const display = document.getElementById('luas_total_display');

function hitungLuas() {
    const p = parseFloat(panjang.value) || 0;
    const l = parseFloat(lebar.value) || 0;
    const j = parseInt(jumlah.value) || 1;

    const luasCm2 = p * l * j;
    luasTotal.value = luasCm2;
    luasTersedia.value = luasCm2;
    display.value = (luasCm2 / 10000).toFixed(2);
}

[panjang, lebar, jumlah].forEach(el => el.addEventListener('input', hitungLuas));
hitungLuas();
</script>
@endsection
