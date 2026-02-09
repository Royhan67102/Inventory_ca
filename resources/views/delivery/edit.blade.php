@extends('layouts.app')

@section('title', 'Update Delivery')
@section('page-title', 'Update Delivery')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Update Delivery</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('delivery.update',$delivery->id) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Driver</label>
                <input type="text" name="driver"
                       value="{{ old('driver',$delivery->driver) }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="menunggu" @selected($delivery->status=='menunggu')>Menunggu</option>
                    <option value="dikirim" @selected($delivery->status=='dikirim')>Dikirim</option>
                    <option value="selesai" @selected($delivery->status=='selesai')>Selesai</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Bukti Foto</label>
                <input type="file" name="bukti_foto" class="form-control">
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('delivery.index') }}"
               class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
