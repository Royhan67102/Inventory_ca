@extends('layouts.app')

@section('title', 'Update Delivery')
@section('page-title', 'Update Delivery')

@section('content')
<style>
/* Card Form */
.form-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* Title */
.form-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
}

/* Label */
.form-label {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
}

/* Input Styling */
.form-control {
    border: 1px solid #d1d5db !important;
    border-radius: 10px !important;
    padding: 10px 12px;
    transition: all 0.2s ease;
}

/* Focus */
.form-control:focus {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 2px rgba(13,110,253,0.15) !important;
}

/* File Input */
input[type="file"].form-control {
    padding: 8px;
}

/* Responsive Button */
.form-action {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    flex-wrap: wrap;
}

/* Mobile */
@media (max-width: 768px) {
    .form-card {
        padding: 18px;
    }

    .form-action {
        justify-content: center;
    }

    .btn {
        width: 100%;
    }
}
</style>


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

<div class="form-card">
<div class="form-title">Update Delivery</div>

<form action="{{ route('delivery.update',$delivery->id) }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Nama Pembeli</label>
            <input type="text"
                   name="nama_pengirim"
                   value="{{ old('nama_pengirim',$delivery->nama_pengirim) }}"
                   class="form-control @error('nama_pengirim') is-invalid @enderror"
                   required>
            @error('nama_pengirim')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Driver</label>
            <input type="text"
                   name="driver"
                   value="{{ old('driver',$delivery->driver) }}"
                   class="form-control @error('driver') is-invalid @enderror"
                   required>
            @error('driver')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">-- Pilih Status --</option>
                <option value="menunggu" @selected($delivery->status=='menunggu')>Menunggu</option>
                <option value="proses" @selected($delivery->status=='proses')>Proses</option>
                <option value="selesai" @selected($delivery->status=='selesai')>Selesai</option>
            </select>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <label class="form-label">Jam Berangkat</label>
            <input type="time"
                   name="jam_berangkat"
                   value="{{ old('jam_berangkat',$delivery->jam_berangkat) }}"
                   class="form-control">
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <label class="form-label">Jam Sampai</label>
            <input type="time"
                   name="jam_sampai_tujuan"
                   value="{{ old('jam_sampai_tujuan',$delivery->jam_sampai_tujuan) }}"
                   class="form-control">
        </div>

        <div class="col-12 mb-3">
            <label class="form-label">Bukti Foto</label>
            <input type="file"
                   name="bukti_foto"
                   class="form-control @error('bukti_foto') is-invalid @enderror"
                   accept="image/*">

            @if($delivery->bukti_foto)
                <small class="d-block mt-2 text-muted">
                    Foto saat ini:
                    <a href="{{ asset('storage/'.$delivery->bukti_foto) }}" target="_blank">
                        Lihat
                    </a>
                </small>
            @endif
        </div>

    </div>

    <div class="form-action mt-4">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('delivery.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
</div>

</div>
@endsection
