@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Pengiriman</h4>
    </div>

    {{-- FILTER --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('delivery.index') }}">
                <div class="row g-2">

                    <div class="col-md-5">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="Cari invoice / customer">
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status')=='menunggu'?'selected':'' }}>Menunggu</option>
                            <option value="berangkat" {{ request('status')=='berangkat'?'selected':'' }}>Berangkat</option>
                            <option value="sampai" {{ request('status')=='sampai'?'selected':'' }}>Sampai</option>
                            <option value="selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary">Filter</button>
                        <a href="{{ route('delivery.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th width="140">Tanggal Kirim</th>
                            <th>Driver</th>
                            <th width="120">Status</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($deliveryNotes as $delivery)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $delivery->order->invoice_number ?? '-' }}
                                </td>

                                <td>
                                    {{ $delivery->order->customer->nama ?? '-' }}
                                </td>

                                <td>
                                    {{ optional($delivery->tanggal_kirim)->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ $delivery->driver ?? '-' }}
                                </td>

                                <td>
                                    @php
                                        $color = [
                                            'menunggu' => 'secondary',
                                            'berangkat' => 'primary',
                                            'sampai' => 'warning',
                                            'selesai' => 'success'
                                        ];
                                    @endphp

                                    <span class="badge bg-{{ $color[$delivery->status] ?? 'dark' }}">
                                        {{ ucfirst($delivery->status) }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('delivery.show',$delivery->id) }}"
                                       class="btn btn-sm btn-info">
                                       Detail
                                    </a>

                                    @if(!$delivery->status_lock)
                                        <a href="{{ route('delivery.edit',$delivery->id) }}"
                                           class="btn btn-sm btn-warning">
                                           Update
                                        </a>
                                    @endif

                                    @if($delivery->status_lock)
                                        <a href="{{ route('delivery.print',$delivery->id) }}"
                                           class="btn btn-sm btn-success">
                                           Cetak
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center p-3">
                                    Tidak ada data pengiriman
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
@endsection
