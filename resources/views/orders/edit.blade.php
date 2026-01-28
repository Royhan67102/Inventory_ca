@extends('layouts.app')

@section('title', 'Edit Order')
@section('page-title', 'Edit Order')

@section('content')
<form action="{{ route('orders.update', $order) }}" method="POST">
@csrf
@method('PUT')

<div class="row">
    {{-- CUSTOMER --}}
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Data Customer</h6>

                <div class="mb-3">
                    <label class="form-label">Nama Customer</label>
                    <input
                        type="text"
                        name="nama"
                        class="form-control border border-dark rounded-0"
                        value="{{ old('nama', $order->customer->nama) }}"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea
                        name="alamat"
                        class="form-control border border-dark rounded-0"
                        rows="3"
                        required
                    >{{ old('alamat', $order->customer->alamat) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- ORDER --}}
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Informasi Order</h6>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Tanggal Pemesanan</label>
                        <input
                            type="date"
                            name="tanggal_pemesanan"
                            class="form-control"
                            value="{{ old('tanggal_pemesanan', $order->tanggal_pemesanan->format('Y-m-d')) }}"
                            required
                        >
                    </div>
                    <div class="col">
                        <label class="form-label">Deadline</label>
                        <input
                            type="date"
                            name="deadline"
                            class="form-control"
                            value="{{ old('deadline', $order->deadline?->format('Y-m-d')) }}"
                        >
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="payment_status" class="form-select" required>
                        <option value="belum_bayar" @selected($order->payment_status=='belum_bayar')>Belum Bayar</option>
                        <option value="dp" @selected($order->payment_status=='dp')>DP</option>
                        <option value="lunas" @selected($order->payment_status=='lunas')>Lunas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Antar Barang?</label>
                    <select name="antar_barang" class="form-select" required>
                        <option value="tidak" @selected($order->antar_barang=='tidak')>Tidak</option>
                        <option value="ya" @selected($order->antar_barang=='ya')>Ya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biaya Pengiriman</label>
                    <input
                        type="number"
                        name="biaya_pengiriman"
                        class="form-control"
                        value="{{ old('biaya_pengiriman', $order->biaya_pengiriman) }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Jasa Pemasangan?</label>
                    <select name="jasa_pemasangan" class="form-select" required>
                        <option value="tidak" @selected($order->jasa_pemasangan=='tidak')>Tidak</option>
                        <option value="ya" @selected($order->jasa_pemasangan=='ya')>Ya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biaya Pemasangan</label>
                    <input
                        type="number"
                        name="biaya_pemasangan"
                        class="form-control"
                        value="{{ old('biaya_pemasangan', $order->biaya_pemasangan) }}"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <input
                        type="text"
                        name="catatan"
                        class="form-control"
                        value="{{ old('catatan', $order->catatan) }}"
                    >
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ITEM --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold">Item Order</h6>

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>Produk</th>
                    <th>Merk</th>
                    <th>Panjang (cm)</th>
                    <th>Lebar (cm)</th>
                    <th>Qty</th>
                    <th>Harga / m²</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td><input name="product_name[]" class="form-control" value="{{ $item->product_name }}" required></td>
                    <td><input name="acrylic_brand[]" class="form-control" value="{{ $item->acrylic_brand }}"></td>
                    <td><input type="number" name="panjang_cm[]" class="form-control" value="{{ $item->panjang_cm }}" required></td>
                    <td><input type="number" name="lebar_cm[]" class="form-control" value="{{ $item->lebar_cm }}" required></td>
                    <td><input type="number" name="qty[]" class="form-control" value="{{ $item->qty }}" required></td>
                    <td><input type="number" name="harga_per_m2[]" class="form-control" value="{{ $item->harga_per_m2 }}" required></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="text-end">
    <button class="btn btn-success">Update Order</button>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
</div>

</form>
@endsection
