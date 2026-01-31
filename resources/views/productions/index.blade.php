@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-3">Antrian Produksi (SPK)</h4>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FILTER --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET">
                <div class="row">

                    <div class="col-md-4">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="Cari Order / Customer">
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="menunggu"
                                {{ request('status')=='menunggu'?'selected':'' }}>
                                Menunggu
                            </option>
                            <option value="proses"
                                {{ request('status')=='proses'?'selected':'' }}>
                                Proses
                            </option>
                            <option value="selesai"
                                {{ request('status')=='selesai'?'selected':'' }}>
                                Selesai
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            Filter
                        </button>
                    </div>

                    <div class="col-md-2">
                        <a href="{{ route('productions.index') }}"
                           class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Tim</th>
                        <th>Status</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($productions as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>

                        <td>#{{ $p->order->id }}</td>

                        <td>{{ $p->order->customer->nama ?? '-' }}</td>

                        <td>{{ $p->tim_produksi ?? '-' }}</td>

                        <td>
                            @if($p->status=='menunggu')
                                <span class="badge bg-secondary">Menunggu</span>
                            @elseif($p->status=='proses')
                                <span class="badge bg-warning text-dark">Proses</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>

                        <td>
                            {{ optional($p->tanggal_mulai)->format('d-m H:i') }}
                        </td>

                        <td>
                            {{ optional($p->tanggal_selesai)->format('d-m H:i') }}
                        </td>

                        <td>
                            <a href="{{ route('productions.show',$p) }}"
                               class="btn btn-sm btn-info">
                                Detail
                            </a>

                            @if(!$p->status_lock)
                                <a href="{{ route('productions.edit',$p) }}"
                                   class="btn btn-sm btn-primary">
                                    Update
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            Tidak ada data produksi
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
