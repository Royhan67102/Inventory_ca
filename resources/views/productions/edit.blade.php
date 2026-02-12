@extends('layouts.app')

@section('title', 'Edit Production')
@section('page-title', 'Edit Production')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <h5>Edit Production</h5>
            </div>

            <div class="card-body">

                {{-- ALERT JIKA SUDAH SELESAI --}}
                @if($production->status === 'selesai')
                    <div class="alert alert-danger">
                        Production sudah selesai dan tidak bisa diedit lagi.
                    </div>
                @endif

                <form action="{{ route('productions.update',$production->id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- TIM PRODUKSI --}}
                    <div class="mb-3">
                        <label class="form-label">Tim Produksi</label>
                        <input type="text"
                               name="tim_produksi"
                               class="form-control"
                               value="{{ $production->tim_produksi }}"
                               {{ $production->status === 'selesai' ? 'disabled' : '' }}>
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-3">
                        <label class="form-label">Status Production</label>
                        <select name="status"
                                class="form-select"
                                {{ $production->status === 'selesai' ? 'disabled' : '' }}>

                            <option value="menunggu"
                                {{ $production->status == 'menunggu' ? 'selected':'' }}>
                                Menunggu
                            </option>

                            <option value="proses"
                                {{ $production->status == 'proses' ? 'selected':'' }}>
                                Proses
                            </option>

                            <option value="selesai"
                                {{ $production->status == 'selesai' ? 'selected':'' }}>
                                Selesai
                            </option>
                        </select>
                    </div>

                    {{-- TANGGAL MULAI --}}
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="datetime-local"
                               name="tanggal_mulai"
                               class="form-control"
                               value="{{ $production->tanggal_mulai ? \Carbon\Carbon::parse($production->tanggal_mulai)->format('Y-m-d\TH:i') : '' }}"
                               {{ $production->status === 'selesai' ? 'disabled' : '' }}>
                    </div>

                    {{-- TANGGAL SELESAI --}}
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="datetime-local"
                               name="tanggal_selesai"
                               class="form-control"
                               value="{{ $production->tanggal_selesai ? \Carbon\Carbon::parse($production->tanggal_selesai)->format('Y-m-d\TH:i') : '' }}"
                               {{ $production->status === 'selesai' ? 'disabled' : '' }}>
                    </div>

                    {{-- BUKTI FOTO --}}
                    <div class="mb-3">
                        <label class="form-label">Bukti Pengerjaan</label>

                        @if($production->bukti)
                            <div class="mb-2">
                                <a href="{{ asset('storage/'.$production->bukti) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm">
                                    👁 Lihat Bukti
                                </a>
                            </div>
                        @endif

                        <input type="file"
                               name="bukti"
                               class="form-control"
                               {{ $production->status === 'selesai' ? 'disabled' : '' }}>
                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti file
                        </small>
                    </div>

                    {{-- CATATAN --}}
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan"
                                  class="form-control"
                                  rows="3"
                                  {{ $production->status === 'selesai' ? 'disabled' : '' }}>{{ $production->catatan }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">

                        <a href="{{ route('productions.index') }}"
                           class="btn btn-secondary">
                           Kembali
                        </a>

                        @if($production->status !== 'selesai')
                            <button type="submit"
                                    class="btn btn-primary">
                                    Simpan
                            </button>
                        @endif

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
