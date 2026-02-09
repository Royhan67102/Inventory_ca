<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\DeliveryNote;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    /* =====================
     * LIST PRODUCTION
     * ===================== */
    public function index()
    {
        $productions = Production::with([
            'order.customer',
            'order.design'
        ])
        ->whereHas('order.design', function ($q) {
            $q->where('status', 'selesai');
        })
        ->latest()
        ->get();

        return view('productions.index', compact('productions'));
    }

    /* =====================
     * DETAIL PRODUCTION
     * ===================== */
    public function show(Production $production)
    {
        $production->load([
            'order.customer',
            'order.design'
        ]);

        return view('productions.show', compact('production'));
    }

    /* =====================
     * FORM EDIT PRODUCTION
     * ===================== */
    public function edit(Production $production)
    {
        return view('productions.edit', compact('production'));
    }

    /* =====================
     * UPDATE PRODUCTION
     * ===================== */
    public function update(Request $request, Production $production)
    {
        $validated = $request->validate([
            'tim_produksi' => 'nullable|string|max:255',
            'status'       => 'required|in:menunggu,proses,selesai',
            'catatan'      => 'nullable|string',
            'bukti'        => 'nullable|file|max:10240',
            'perlu_pengiriman' => 'nullable|boolean',
        ]);

        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('productions', 'public');
            $validated['bukti'] = $path;
        }

        $validated['perlu_pengiriman'] = $request->has('perlu_pengiriman');

        $production->update($validated);

        /* =====================
        * JIKA PRODUKSI SELESAI
        * ===================== */
        if ($validated['status'] === 'selesai') {

            if ($validated['perlu_pengiriman']) {

                // Order masuk ke delivery
                $production->order->update([
                    'status' => 'delivery'
                ]);

                // Buat delivery note jika belum ada
                DeliveryNote::firstOrCreate(
                    ['order_id' => $production->order->id],
                    [
                        'status' => 'menunggu',
                        'status_lock' => false
                    ]
                );

            } else {

                // Jika tidak perlu kirim → langsung pickup
                $production->order->update([
                    'status' => 'pickup'
                ]);
            }
        }

        return redirect()
            ->route('productions.index')
            ->with('success', 'Production berhasil diperbarui');
    }

}
