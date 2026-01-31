@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-3">Update Produksi (SPK)</h4>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
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

    {{-- DETAIL ORDER --}}
    <div class="card mb-3">
        <div class="card-body">
            <h5>Informasi Order</h5>

            <p><b>No Order:</b> #{{ $production->order->id }}</p>
            <p><b>Customer:</b>
                {{ $production->order->customer->nama ?? '-' }}
            </p>

            <p><b>Status Order:</b>
                {{ ucfirst($production->order->status) }}
            </p>
        </div>
    </div>

    {{-- FORM UPDATE --}}
    <div class="card">
        <div class="card-body">

            <form action="{{ route('productions.update', $production) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tim Produksi</label>
                    <input type="text"
                           name="tim_produksi"
                           class="form-control"
                           value="{{ old('tim_produksi', $production->tim_produksi) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Produksi</label>
                    <select name="status" class="form-control" required>
                        <option value="menunggu"
                            {{ $production->status=='menunggu'?'selected':'' }}>
                            Menunggu
                        </option>
                        <option value="proses"
                            {{ $production->status=='proses'?'selected':'' }}>
                            Proses
                        </option>
                        <option value="selesai"
                            {{ $production->status=='selesai'?'selected':'' }}>
                            Selesai
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan Produksi</label>
                    <textarea name="catatan"
                              class="form-control"
                              rows="3">{{ old('catatan', $production->catatan) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Bukti Produksi</label>
                    <input type="file"
                           name="bukti"
                           class="form-control">

                    @if($production->bukti)
                        <div class="mt-2">
                            <small>Bukti saat ini:</small><br>
                            <a href="{{ asset('storage/'.$production->bukti) }}"
                               target="_blank">
                                Lihat Bukti
                            </a>
                        </div>
                    @endif
                </div>

                <button class="btn btn-primary">
                    Update Produksi
                </button>

                <a href="{{ route('productions.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>
@endsection
