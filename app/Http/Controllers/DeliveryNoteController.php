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
    public function index(Request $request)
    {
        $query = DeliveryNote::with([
            'order.customer',
            'order.production'
        ])->latest();

        // search invoice / customer
        if ($request->search) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('invoice_number', 'like', "%{$request->search}%")
                ->orWhereHas('customer', function ($c) use ($request) {
                    $c->where('nama', 'like', "%{$request->search}%");
                });
            });
        }

        // filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $deliveryNotes = $query->get();

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
     * FORM EDIT DELIVERY
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
            'driver'            => 'required|string|max:100',
            'status'            => 'required|in:menunggu,berangkat,sampai,selesai',
            'tanggal_kirim'     => 'required|date',
            'jam_berangkat'     => 'nullable',
            'jam_sampai_tujuan' => 'nullable',
            'jam_kembali'       => 'nullable',
            'bukti_foto'        => 'nullable|image|max:2048',
        ]);

        /* =====================
         * VALIDASI FOTO JIKA SELESAI
         * ===================== */
        if (
            $validated['status'] === 'selesai' &&
            !$request->hasFile('bukti_foto') &&
            !$deliveryNote->bukti_foto
        ) {
            return back()
                ->withInput()
                ->with('error', 'Bukti foto pengiriman wajib diupload.');
        }

        /* =====================
         * UPLOAD FOTO
         * ===================== */
        if ($request->hasFile('bukti_foto')) {

            if ($deliveryNote->bukti_foto) {
                Storage::disk('public')->delete($deliveryNote->bukti_foto);
            }

            $validated['bukti_foto'] = $request
                ->file('bukti_foto')
                ->store('delivery', 'public');
        }

        /* =====================
         * UPDATE DELIVERY NOTE
         * ===================== */
        $deliveryNote->update([
            'driver'        => $validated['driver'],
            'status'        => $validated['status'],
            'tanggal_kirim' => $validated['tanggal_kirim'],
            'jam_berangkat' => $validated['jam_berangkat'] ?? null,
            'jam_sampai_tujuan' => $validated['jam_sampai_tujuan'] ?? null,
            'jam_kembali'   => $validated['jam_kembali'] ?? null,
            'bukti_foto'    => $validated['bukti_foto'] ?? $deliveryNote->bukti_foto,
        ]);

        /* =====================
         * JIKA SELESAI
         * ===================== */
        if ($validated['status'] === 'selesai') {

            $deliveryNote->update([
                'status_lock' => true
            ]);

            // Order masuk history selesai
            $deliveryNote->order->update([
                'status' => 'selesai'
            ]);

        } else {
            // Order tetap di proses delivery
            $deliveryNote->order->update([
                'status' => 'delivery'
            ]);
        }

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
