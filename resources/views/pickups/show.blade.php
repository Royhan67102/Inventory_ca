@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Detail Pickup Order #{{ $order->id }}</h3>

    <div class="card">
        <div class="card-body">

            <p><strong>Customer:</strong>
                {{ $order->customer->nama ?? '-' }}
            </p>

            <p><strong>Status Pickup:</strong>
                {{ ucfirst($pickup->status) }}
            </p>

            <p><strong>Catatan:</strong><br>
                {{ $pickup->catatan ?? '-' }}
            </p>

            <p><strong>Bukti Pickup:</strong><br>
                @if($pickup->bukti)
                    <img src="{{ asset('storage/'.$pickup->bukti) }}"
                         width="300"
                         class="img-thumbnail">
                @else
                    Tidak ada bukti
                @endif
            </p>

            <a href="{{ route('pickup.edit', $order->id) }}"
               class="btn btn-primary">
                Edit Pickup
            </a>

            <a href="{{ route('pickup.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection
