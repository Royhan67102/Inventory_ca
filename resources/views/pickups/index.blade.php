@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Daftar Pickup Order</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Order</th>
                        <th>Customer</th>
                        <th>Status Pickup</th>
                        <th>Bukti</th>
                        <th>Catatan</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pickups as $index => $pickup)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>#{{ $pickup->order->id }}</td>
                            <td>{{ $pickup->order->customer->nama ?? '-' }}</td>

                            <td>
                                @if($pickup->status == 'menunggu')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @elseif($pickup->status == 'siap')
                                    <span class="badge bg-warning text-dark">Siap Diambil</span>
                                @elseif($pickup->status == 'diambil')
                                    <span class="badge bg-success">Sudah Diambil</span>
                                @endif
                            </td>

                            <td>
                                @if($pickup->bukti)
                                    <a href="{{ asset('storage/'.$pickup->bukti) }}"
                                       target="_blank">
                                        Lihat Bukti
                                    </a>
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $pickup->catatan ?? '-' }}</td>

                            <td>
                                <a href="{{ route('pickup.edit', $pickup->order->id) }}"
                                   class="btn btn-sm btn-primary">
                                    Update
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada data pickup
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
