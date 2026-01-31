@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Update Pengiriman</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('delivery.update', $deliveryNote->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- DRIVER --}}
                <div class="mb-3">
                    <label class="form-label">Driver</label>
                    <input type="text"
                           name="driver"
                           class="form-control"
                           value="{{ old('driver', $deliveryNote->driver) }}"
                           required>
                </div>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="menunggu"
                            {{ $deliveryNote->status=='menunggu'?'selected':'' }}>
                            Menunggu
                        </option>
                        <option value="berangkat"
                            {{ $deliveryNote->status=='berangkat'?'selected':'' }}>
                            Berangkat
                        </option>
                        <option value="sampai"
                            {{ $deliveryNote->status=='sampai'?'selected':'' }}>
                            Sampai
                        </option>
                        <option value="selesai"
                            {{ $deliveryNote->status=='selesai'?'selected':'' }}>
                            Selesai
                        </option>
                    </select>
                </div>

                {{-- TANGGAL KIRIM --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Kirim</label>
                    <input type="date"
                           name="tanggal_kirim"
                           class="form-control"
                           value="{{ old('tanggal_kirim', optional($deliveryNote->tanggal_kirim)->format('Y-m-d')) }}"
                           required>
                </div>

                {{-- JAM --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Jam Berangkat</label>
                        <input type="time" name="jam_berangkat"
                               class="form-control"
                               value="{{ $deliveryNote->jam_berangkat }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Jam Sampai</label>
                        <input type="time" name="jam_sampai_tujuan"
                               class="form-control"
                               value="{{ $deliveryNote->jam_sampai_tujuan }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Jam Kembali</label>
                        <input type="time" name="jam_kembali"
                               class="form-control"
                               value="{{ $deliveryNote->jam_kembali }}">
                    </div>
                </div>

                {{-- FOTO --}}
                <div class="mb-3">
                    <label class="form-label">Bukti Foto</label>
                    <input type="file" name="bukti_foto" class="form-control">

                    @if($deliveryNote->bukti_foto)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$deliveryNote->bukti_foto) }}"
                                 width="150">
                        </div>
                    @endif
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ route('delivery.index') }}"
                   class="btn btn-secondary">Kembali</a>

            </form>
        </div>
    </div>
</div>
@endsection
