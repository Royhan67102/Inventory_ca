@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Update Pickup Order #{{ $order->id }}</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pickup.update', $order->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $order->customer->nama ?? '-' }}"
                           readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Pickup</label>
                    <select name="status" class="form-select" required>
                        <option value="menunggu"
                            {{ $pickup->status == 'menunggu' ? 'selected' : '' }}>
                            Menunggu
                        </option>

                        <option value="siap"
                            {{ $pickup->status == 'siap' ? 'selected' : '' }}>
                            Siap Diambil
                        </option>

                        <option value="diambil"
                            {{ $pickup->status == 'diambil' ? 'selected' : '' }}>
                            Sudah Diambil
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Bukti Pickup</label>
                    <input type="file" name="bukti" class="form-control">

                    @if($pickup->bukti)
                        <div class="mt-2">
                            <a href="{{ asset('storage/'.$pickup->bukti) }}"
                               target="_blank">
                                Lihat bukti sebelumnya
                            </a>
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan"
                              class="form-control"
                              rows="3">{{ old('catatan', $pickup->catatan) }}</textarea>
                </div>

                <button class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a href="{{ route('pickup.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
