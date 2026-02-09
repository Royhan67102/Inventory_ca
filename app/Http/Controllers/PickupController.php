<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PickupController extends Controller
{
    /* =====================
     * LIST PICKUP
     * ===================== */
    public function index()
    {
        $pickups = Pickup::with([
            'order.customer'
        ])->latest()->get();

        return view('pickups.index', compact('pickups'));
    }

    /* =====================
     * DETAIL PICKUP
     * ===================== */
    public function show(Pickup $pickup)
    {
        $pickup->load([
            'order.customer',
            'order.items'
        ]);

        return view('pickups.show', compact('pickup'));
    }

    /* =====================
     * FORM EDIT PICKUP
     * ===================== */
    public function edit(Pickup $pickup)
    {
        if ($pickup->isSelesai()) {
            return redirect()
                ->route('pickups.index')
                ->with('error', 'Pickup sudah selesai.');
        }

        return view('pickups.edit', compact('pickup'));
    }

    /* =====================
     * UPDATE PICKUP
     * ===================== */
    public function update(Request $request, Pickup $pickup)
    {
        if ($pickup->isSelesai()) {
            return back()->with('error', 'Pickup sudah terkunci.');
        }

        $validated = $request->validate([
            'status'  => 'required|in:menunggu,selesai',
            'bukti'   => 'nullable|file|max:2048',
            'catatan' => 'nullable|string',
        ]);

        // upload bukti
        if ($request->hasFile('bukti')) {

            if ($pickup->bukti) {
                Storage::disk('public')->delete($pickup->bukti);
            }

            $validated['bukti'] = $request
                ->file('bukti')
                ->store('pickup', 'public');
        }

        $pickup->update([
            'catatan' => $validated['catatan'] ?? null,
        ]);

        // jika selesai → pakai business method
        if ($validated['status'] === 'selesai') {
            $pickup->tandaiSudahDiambil($validated['bukti'] ?? null);
        }

        return redirect()
            ->route('pickup.index')
            ->with('success', 'Pickup berhasil diperbarui.');
    }
}
