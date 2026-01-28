@extends('layouts.app')

@section('title', 'Update Produksi')
@section('page-title', 'Update Produksi')

@section('content')
<form method="POST"
      action="{{ route('productions.update', $production) }}"
      enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row">
    {{-- INFO ORDER (READONLY) --}}
    <div class="col-md-5">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Informasi Order</h6>

                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <input type="text" class="form-control" disabled
                        value="{{ $production->order->customer->nama ?? '-' }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pemesanan</label>
                    <input type="text" class="form-control" disabled
                        value="{{ $production->order->tanggal_pemesanan?->format('d M Y') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="text" class="form-control" disabled
                        value="{{ $production->order->deadline?->format('d M Y') ?? '-' }}">
                </div>
            </div>
        </div>
    </div>

    {{-- UPDATE PRODUKSI --}}
    <div class="col-md-7">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Update Produksi</h6>

                {{-- STATUS --}}
                <div class="mb-3">
                    <label class="form-label">Status Produksi</label>
                    <select name="status" class="form-select" required>
                        <option value="menunggu" @selected($production->status=='menunggu')>Menunggu</option>
                        <option value="proses" @selected($production->status=='proses')>Produksi</option>
                        <option value="selesai" @selected($production->status=='selesai')>Selesai</option>
                    </select>
                </div>

                {{-- PIC --}}
                <div class="mb-3">
                    <label class="form-label">PIC Produksi</label>
                    <input type="text"
                           name="tim_produksi"
                           class="form-control"
                           value="{{ old('tim_produksi', $production->tim_produksi) }}"
                           required>
                </div>

                {{-- CATATAN --}}
                <div class="mb-3">
                    <label class="form-label">Catatan Produksi</label>
                    <textarea name="catatan"
                              class="form-control"
                              rows="3">{{ old('catatan', $production->catatan) }}</textarea>
                </div>

                {{-- BUKTI --}}
                <div class="mb-3">
                    <label class="form-label">Bukti Produksi (Foto)</label>
                    <input type="file"
                           name="bukti"
                           class="form-control"
                           accept="image/*">

                    @if($production->bukti)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$production->bukti) }}"
                                 class="img-thumbnail"
                                 style="max-width: 200px">
                        </div>
                    @endif
                </div>

                <div class="text-end">
                    <button class="btn btn-success">
                        Simpan Produksi
                    </button>
                    <a href="{{ route('productions.index') }}"
                       class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection
