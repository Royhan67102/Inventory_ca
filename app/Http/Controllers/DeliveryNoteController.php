<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use Illuminate\Http\Request;

class DeliveryNoteController extends Controller
{
    /* =====================
     * LIST DELIVERY
     * ===================== */
    public function index()
    {
        $deliveries = DeliveryNote::with([
            'order.customer'
        ])->latest()->get();

        return view('delivery.index', compact('deliveries'));
    }


    /* =====================
     * DETAIL DELIVERY
     * ===================== */
    public function show(DeliveryNote $delivery)
    {
        $delivery->load([
            'order.customer',
            'order.design'
        ]);

        return view('delivery.show', compact('delivery'));
    }

    /* =====================
     * FORM EDIT DELIVERY
     * ===================== */
    public function edit(DeliveryNote $delivery)
    {
        // kalau sudah selesai → tidak bisa diedit
        if ($delivery->status === 'selesai') {
            return redirect()
                ->route('delivery.index')
                ->with('error', 'Delivery sudah selesai dan terkunci');
        }

        return view('delivery.edit', compact('delivery'));
    }

    /* =====================
     * UPDATE DELIVERY
     * ===================== */
    public function update(Request $request, DeliveryNote $delivery)
    {
        if ($delivery->status === 'selesai') {
            return redirect()
                ->route('delivery.index')
                ->with('error', 'Delivery sudah selesai dan tidak bisa diubah');
        }

        $validated = $request->validate([
            'nama_pengirim'      => 'nullable|string|max:255',
            'driver'             => 'nullable|string|max:255',
            'status'             => 'required|in:menunggu,dikirim,selesai',
            'jam_berangkat'      => 'nullable',
            'jam_sampai_tujuan'  => 'nullable',
            'jam_kembali'        => 'nullable',
            'bukti_foto'         => 'nullable|file|image|max:10240',
        ]);

        if ($request->hasFile('bukti_foto')) {
            $validated['bukti_foto'] =
                $request->file('bukti_foto')->store('deliveries', 'public');
        }

        $delivery->update($validated);

        /* =====================
         * JIKA DELIVERY SELESAI
         * ===================== */
        if ($validated['status'] === 'selesai') {

            // Order pindah ke pickup
            $delivery->order->update([
                'status' => 'pickup'
            ]);

            // lock delivery
            $delivery->updateQuietly([
                'status_lock' => true
            ]);
        }

        return redirect()
            ->route('delivery.index')
            ->with('success', 'Delivery berhasil diperbarui');
    }
}
