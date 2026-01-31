@extends('layouts.app')

@section('title', 'Edit Desain')
@section('page-title', 'Edit Desain')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Edit Desain - Order #{{ $design->order->id ?? '-' }}</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('designs.update', $design->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Designer --}}
                    <div class="mb-3">
                        <label for="designer" class="form-label">Designer</label>
                        <input type="text" name="designer" id="designer" class="form-control"
                            value="{{ old('designer', $design->designer) }}">
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Desain</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="menunggu" {{ $design->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="proses" {{ $design->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $design->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    {{-- Catatan --}}
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="3" class="form-control">{{ old('catatan', $design->catatan) }}</textarea>
                    </div>

                    {{-- File Hasil --}}
                    <div class="mb-3">
                        <label for="file_hasil" class="form-label">Upload File Hasil Desain</label>
                        <input type="file" name="file_hasil" id="file_hasil" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.ai,.psd">
                        @if($design->file_hasil)
                            <small class="text-muted">
                                File saat ini: <a href="{{ asset('storage/' . $design->file_hasil) }}" target="_blank">Lihat File</a>
                            </small>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('designs.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
