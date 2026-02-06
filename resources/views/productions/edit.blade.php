@extends('layouts.app')

@section('title', 'Edit Production')
@section('page-title', 'Edit Production')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h5>Edit Production</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('productions.update',$production->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- STATUS PRODUCTION --}}
                    <div class="mb-3">
                        <label>Status Production</label>
                        <select name="status" class="form-select" required>

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

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('productions.index') }}"
                           class="btn btn-secondary">
                           Kembali
                        </a>

                        <button type="submit"
                                class="btn btn-primary">
                                Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
