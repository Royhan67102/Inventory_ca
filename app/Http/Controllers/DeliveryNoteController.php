<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeliveryNoteController extends Controller
{
    /* =====================
     * LIST DELIVERY
     * ===================== */
    public function index()
    {
        $deliveries = DeliveryNote::with([
                'order.customer'
            ])
            ->where('status', '!=', 'selesai')
            ->latest()
            ->get();

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
            'nama_pengirim'      => 'required|string|max:255',
            'driver'             => 'required|string|max:255',
            'status'             => 'required|in:menunggu,dikirim,selesai',
            'jam_berangkat'      => 'nullable',
            'jam_sampai_tujuan'  => 'nullable',
            'jam_kembali'        => 'nullable',
            'bukti_foto'         => 'nullable|file|image|max:10240',
        ]);

        DB::transaction(function () use ($request, $validated, $delivery) {

            $allowedTransitions = [
                'menunggu' => ['dikirim', 'selesai'],
                'dikirim'  => ['selesai'],
            ];


            if (
                isset($allowedTransitions[$delivery->status]) &&
                !in_array($validated['status'], $allowedTransitions[$delivery->status]) &&
                $validated['status'] !== $delivery->status
            ) {
                throw new \Exception('Transisi status tidak valid.');
            }

            $data = $validated;

            if ($request->hasFile('bukti_foto')) {

                if ($delivery->bukti_foto) {
                    Storage::disk('public')->delete($delivery->bukti_foto);
                }

                $data['bukti_foto'] =
                    $request->file('bukti_foto')
                        ->store('deliveries', 'public');
            }

            $delivery->update($data);

            /* =====================
            * JIKA DELIVERY SELESAI
            * ===================== */
            if (
                $validated['status'] === 'selesai' &&
                $delivery->order &&
                $delivery->order->status !== 'selesai'
            ) {
                $delivery->order->updateQuietly([
                    'status' => 'selesai'
                ]);
            }
        });

        return redirect()
            ->route('delivery.index')
            ->with('success', 'Delivery berhasil diperbarui');
    }
}
