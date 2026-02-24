@extends('layouts.app')

@section('title','Update Pickup')
@section('page-title','Update Pickup')

<style>
    /* =========================
   FORM WRAPPER
========================= */
.pickup-form {
    max-width: 600px;
}

/* =========================
   FORM GROUP
========================= */
.form-group-custom {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

/* =========================
   LABEL
========================= */
.form-group-custom label {
    font-weight: 600;
    margin-bottom: 6px;
}

/* =========================
   INPUT BORDER STYLE
========================= */
.form-control-custom {
    border: 1.5px solid #dcdcdc;
    border-radius: 8px;
    padding: 10px 12px;
    transition: all 0.2s ease;
    width: 100%;
}

/* Focus Effect */
.form-control-custom:focus {
    outline: none;
    border-color: #198754;
    box-shadow: 0 0 0 2px rgba(25,135,84,0.15);
}

/* =========================
   MOBILE OPTIMIZATION
========================= */
@media (max-width: 576px) {

    .card-body {
        padding: 16px;
    }

    .form-control-custom {
        font-size: 14px;
        padding: 9px 10px;
    }

    label {
        font-size: 14px;
    }

}
</style>
@section('content')
<div class="card">
    <div class="pickup-form">
        <form action="{{ route('pickup.update',$pickup->id) }}"
        method="POST"
        enctype="multipart/form-data">

            <div class="form-group-custom">
                <label>Status</label>
                <select name="status" class="form-control-custom" required>
                    <option value="menunggu"
                        {{ $pickup->status == 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>
                    <option value="selesai">
                        Selesai
                    </option>
                </select>
            </div>


           <div class="form-group-custom">
            <label>Bukti (opsional)</label>
            <input type="file" name="bukti" class="form-control-custom">
        </div>

            <div class="form-group-custom">
                <label>Catatan</label>
                <textarea name="catatan"
                        rows="3"
                        class="form-control-custom">{{ old('catatan',$pickup->catatan) }}</textarea>
            </div>

            <div class="d-flex flex-column flex-md-row gap-2 mt-3">
                <button class="btn btn-success w-100 w-md-auto">
                    Simpan
                </button>

                <a href="{{ route('pickup.index') }}"
                class="btn btn-secondary w-100 w-md-auto">
                Batal
                </a>
            </div>

        </form>

    </div>
</div>
@endsection
