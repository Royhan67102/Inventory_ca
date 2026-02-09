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
                        <label class="form-label">Designer</label>
                        <input type="text" name="designer" class="form-control"
                               value="{{ old('designer', $design->designer) }}">
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status Desain</label>
                        <select name="status" class="form-select" required>
                            <option value="menunggu" {{ $design->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="proses" {{ $design->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $design->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    {{-- Deadline --}}
                    <div class="mb-3">
                        <label class="form-label">Deadline</label>
                        <input
                            type="date"
                            name="deadline"
                            class="form-control"
                            value="{{ old(
                                'deadline',
                                optional($design->deadline ?? $design->order?->deadline)->format('Y-m-d')
                            ) }}"
                        >
                    </div>


                    {{-- Catatan --}}
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" rows="3" class="form-control">{{ old('catatan', $design->catatan) }}</textarea>
                    </div>

                    {{-- File Awal (VIEW ONLY) --}}
                    @if($design->file_awal)
                        <div class="mb-3">
                            <label class="form-label">File Awal</label><br>
                            <a href="{{ asset('storage/'.$design->file_awal) }}" target="_blank">
                                Lihat File Awal
                            </a>
                        </div>
                    @endif

                    {{-- File Hasil --}}
                    <div class="mb-3">
                        <label class="form-label">Upload File Hasil</label>
                        <input type="file" name="file_hasil" class="form-control"
                               accept=".jpg,.jpeg,.png,.pdf,.ai,.psd">

                        @if($design->file_hasil)
                            <small class="text-muted">
                                File saat ini:
                                <a href="{{ asset('storage/'.$design->file_hasil) }}" target="_blank">
                                    Lihat File
                                </a>
                            </small>
                        @endif
                    </div>

                    {{-- Bukti Pengerjaan --}}
                    <div class="mb-3">
                        <label class="form-label">Bukti Pengerjaan</label>
                        <input type="file" name="bukti_pengerjaan" class="form-control"
                               accept=".jpg,.jpeg,.png,.pdf">

                        @if($design->bukti_pengerjaan)
                            <small class="text-muted">
                                File saat ini:
                                <a href="{{ asset('storage/'.$design->bukti_pengerjaan) }}" target="_blank">
                                    Lihat Bukti
                                </a>
                            </small>
                        @endif
                    </div>

                    {{-- Tanggal Selesai (READ ONLY) --}}
                    @if($design->tanggal_selesai)
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="text" class="form-control" readonly
                                   value="{{ $design->tanggal_selesai }}">
                        </div>
                    @endif

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
