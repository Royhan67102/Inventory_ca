@extends('layouts.app')

@section('content')

<div class="card">

<div class="card-body text-center">

    {{-- AREA PRINT --}}
    <div id="area-print">
        @include('orders.invoice-pdf')
    </div>

    <br>

    {{-- TOMBOL AKSI --}}
    <div class="no-print">

        <a href="{{ route('orders.invoice.download',$order) }}"
        class="btn btn-success">
            Download PDF
        </a>

        <button onclick="window.print()"
        class="btn btn-secondary">
            Print
        </button>

    </div>

</div>

</div>

@endsection


{{-- STYLE KHUSUS PRINT --}}
@push('styles')

<style>

/* ================= PRINT AREA ================= */

@media print {

body *{
    visibility:hidden;
}

/* tampilkan hanya invoice */
#area-print,
#area-print *{
    visibility:visible;
}

/* posisi invoice */
#area-print{
    position:absolute;
    left:0;
    top:0;
    width:100%;
}

/* sembunyikan tombol */
.no-print{
    display:none;
}

}

</style>

@endpush
