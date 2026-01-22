<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DeliveryNoteController extends Controller
{
    /* =====================
     * LIST DELIVERY
     * ===================== */
    public function index()
    {
        $deliveryNotes = DeliveryNote::with([
            'order.customer',
            'order.production'
        ])->latest()->get();

        return view('delivery.index', compact('deliveryNotes'));
    }

    /* =====================
     * DETAIL DELIVERY
     * ===================== */
    public function show(DeliveryNote $deliveryNote)
    {
        $deliveryNote->load([
            'order.customer',
            'order.items',
            'order.production'
        ]);

        return view('delivery.show', compact('deliveryNote'));
    }

    /* =====================
     * FORM EDIT DRIVER
     * ===================== */
    public function edit(DeliveryNote $deliveryNote)
    {
        if ($deliveryNote->status_lock) {
            return redirect()
                ->route('delivery.index')
                ->with('error', 'Pengiriman sudah selesai & terkunci.');
        }

        return view('delivery.edit', compact('deliveryNote'));
    }

    /* =====================
     * UPDATE DELIVERY
     * ===================== */
    public function update(Request $request, DeliveryNote $deliveryNote)
    {
        if ($deliveryNote->status_lock) {
            return back()->with('error', 'Data pengiriman terkunci.');
        }

        $validated = $request->validate([
            'driver'             => 'required|string|max:100',
            'status_pengiriman'  => 'required|in:menunggu,berangkat,sampai,selesai',
            'tanggal_kirim'      => 'required|date',
            'jam_berangkat'      => 'nullable',
            'jam_sampai_tujuan'  => 'nullable',
            'jam_kembali'        => 'nullable',
            'bukti_foto'         => 'nullable|image|max:2048',
        ]);

        /* =====================
         * UPLOAD FOTO
         * ===================== */
        if ($request->hasFile('bukti_foto')) {
            if ($deliveryNote->bukti_foto) {
                Storage::delete($deliveryNote->bukti_foto);
            }

            $validated['bukti_foto'] = $request
                ->file('bukti_foto')
                ->store('delivery', 'public');
        }

        /* =====================
         * LOCK JIKA SELESAI
         * ===================== */
        if ($validated['status_pengiriman'] === 'selesai') {
            $validated['status_lock'] = true;
        }

        $deliveryNote->update($validated);

        return redirect()
            ->route('delivery.index')
            ->with('success', 'Data pengiriman berhasil diperbarui.');
    }

    /* =====================
     * CETAK SURAT JALAN
     * ===================== */
    public function print(DeliveryNote $deliveryNote)
    {
        if (!$deliveryNote->status_lock) {
            return back()->with('error', 'Pengiriman belum selesai.');
        }

        $deliveryNote->load([
            'order.customer',
            'order.items'
        ]);

        $pdf = Pdf::loadView('delivery.print', compact('deliveryNote'))
            ->setPaper('a4', 'portrait');

        return $pdf->download(
            'Surat-Jalan-' . $deliveryNote->order->invoice_number . '.pdf'
        );
    }
}
