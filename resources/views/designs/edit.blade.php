@extends('layouts.app')

@section('title', 'Edit Desain')
@section('page-title', 'Edit Desain')

@section('content')

<style>
.design-card {
    border-radius: 12px;
    overflow: hidden;
}

/* Input Styling */
.form-control,
.form-select,
textarea {
    border: 1px solid #ced4da !important;
    border-radius: 8px;
    padding: 10px;
}

/* Label */
.form-label {
    font-weight: 600;
}

/* File Box */
.file-box {
    border: 1px dashed #dee2e6;
    border-radius: 10px;
    padding: 10px 15px;
    background: #f9fafb;
}

/* Responsive */
@media(max-width:768px){

    .form-grid {
        display: block !important;
    }

    .btn-group-mobile {
        flex-direction: column;
        gap: 10px;
    }

    .btn-group-mobile .btn {
        width: 100%;
    }
}
</style>

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">

        <div class="card design-card">

            <div class="card-header bg-light">
                <h5 class="mb-0">Edit Desain - Order #{{ $design->order->id ?? '-' }}</h5>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('designs.update', $design->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- DESIGNER --}}
                    <div class="mb-3">
                        <label class="form-label">Designer</label>
                        <input type="text" name="designer"
                               class="form-control"
                               value="{{ old('designer', $design->designer) }}">
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-3">
                        <label class="form-label">Status Desain</label>
                        <select name="status" class="form-select" required>
                            <option value="menunggu" {{ $design->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="proses" {{ $design->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $design->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    {{-- DEADLINE --}}
                    <div class="mb-3">
                        <label class="form-label">Deadline</label>
                        <input type="text"
                               name="deadline"
                               class="form-control"
                               value="{{ old('deadline', optional($design->deadline ?? $design->order?->deadline)->format('d/m/Y')) }}">
                    </div>

                    {{-- CATATAN --}}
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" rows="3" class="form-control">
                            {{ old('catatan', $design->catatan) }}
                        </textarea>
                    </div>

                    {{-- FILE AWAL --}}
                    @if($design->file_awal)
                    <div class="mb-3">
                        <label class="form-label">File Awal</label>
                        <div class="file-box">
                            <a href="{{ asset('storage/'.$design->file_awal) }}" target="_blank">
                                Lihat File Awal
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- FILE HASIL --}}
                    <div class="mb-3">
                        <label class="form-label">Upload File Hasil</label>
                        <input type="file" name="file_hasil" class="form-control"
                               accept=".jpg,.jpeg,.png,.pdf,.ai,.psd">

                        @if($design->file_hasil)
                        <div class="file-box mt-2">
                            File saat ini:
                            <a href="{{ asset('storage/'.$design->file_hasil) }}" target="_blank">
                                Lihat File
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- BUKTI --}}
                    <div class="mb-3">
                        <label class="form-label">Bukti Pengerjaan</label>
                        <input type="file" name="bukti_pengerjaan" class="form-control"
                               accept=".jpg,.jpeg,.png,.pdf">

                        @if($design->bukti_pengerjaan)
                        <div class="file-box mt-2">
                            File saat ini:
                            <a href="{{ asset('storage/'.$design->bukti_pengerjaan) }}" target="_blank">
                                Lihat Bukti
                            </a>
                        </div>
                        @endif
                    </div>

                    {{-- TANGGAL SELESAI --}}
                    @if($design->tanggal_selesai)
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="text" class="form-control" readonly
                               value="{{ $design->tanggal_selesai }}">
                    </div>
                    @endif

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-between btn-group-mobile">
                        <a href="{{ route('designs.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection