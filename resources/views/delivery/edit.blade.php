@extends('layouts.app')

@section('title', 'Update Delivery')
@section('page-title', 'Update Delivery')

@section('content')

{{-- ALERT MESSAGES --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Kesalahan!</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Update Delivery</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('delivery.update',$delivery->id) }}"
              method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- NAMA PENGIRIM --}}
            <div class="mb-3">
                <label for="nama_pengirim" class="form-label">Nama Pengirim</label>
                <input type="text" 
                       id="nama_pengirim"
                       name="nama_pengirim"
                       value="{{ old('nama_pengirim',$delivery->nama_pengirim) }}"
                       class="form-control @error('nama_pengirim') is-invalid @enderror"
                       required>
                @error('nama_pengirim')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- DRIVER --}}
            <div class="mb-3">
                <label for="driver" class="form-label">Driver</label>
                <input type="text" 
                       id="driver"
                       name="driver"
                       value="{{ old('driver',$delivery->driver) }}"
                       class="form-control @error('driver') is-invalid @enderror"
                       required>
                @error('driver')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- STATUS --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="menunggu" @selected($delivery->status=='menunggu')>Menunggu</option>
                    <option value="proses" @selected($delivery->status=='proses')>Proses</option>
                    <option value="selesai" @selected($delivery->status=='selesai')>Selesai</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- JAM BERANGKAT --}}
            <div class="mb-3">
                <label for="jam_berangkat" class="form-label">Jam Berangkat</label>
                <input type="time" 
                       id="jam_berangkat"
                       name="jam_berangkat"
                       value="{{ old('jam_berangkat',$delivery->jam_berangkat) }}"
                       class="form-control @error('jam_berangkat') is-invalid @enderror">
                @error('jam_berangkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- JAM SAMPAI TUJUAN --}}
            <div class="mb-3">
                <label for="jam_sampai_tujuan" class="form-label">Jam Sampai Tujuan</label>
                <input type="time" 
                       id="jam_sampai_tujuan"
                       name="jam_sampai_tujuan"
                       value="{{ old('jam_sampai_tujuan',$delivery->jam_sampai_tujuan) }}"
                       class="form-control @error('jam_sampai_tujuan') is-invalid @enderror">
                @error('jam_sampai_tujuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            {{-- BUKTI FOTO --}}
            <div class="mb-3">
                <label for="bukti_foto" class="form-label">Bukti Foto</label>
                <input type="file" 
                       id="bukti_foto"
                       name="bukti_foto" 
                       class="form-control @error('bukti_foto') is-invalid @enderror"
                       accept="image/*">
                @if($delivery->bukti_foto)
                    <small class="d-block mt-2 text-muted">Foto saat ini: <a href="{{ asset('storage/'.$delivery->bukti_foto) }}" target="_blank">Lihat</a></small>
                @endif
                @error('bukti_foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- BUTTONS --}}
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('delivery.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
