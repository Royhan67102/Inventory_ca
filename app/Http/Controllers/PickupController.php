<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            ])
            ->where('status', 'menunggu') // lebih tegas
            ->latest()
            ->get();

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

        DB::transaction(function () use ($request, $validated, $pickup) {

            // ❗ Cegah status turun dari selesai ke menunggu
            if (
                $pickup->status === 'selesai' &&
                $validated['status'] === 'menunggu'
            ) {
                throw new \Exception('Status tidak dapat dikembalikan.');
            }

            $data = [
                'status'  => $validated['status'],
                'catatan' => $validated['catatan'] ?? null,
            ];

            // Upload bukti jika ada
            if ($request->hasFile('bukti')) {

                if ($pickup->bukti) {
                    Storage::disk('public')->delete($pickup->bukti);
                }

                $data['bukti'] = $request->file('bukti')
                    ->store('pickup', 'public');
            }

            $pickup->update($data);

            /* =====================
             * JIKA SELESAI
             * ===================== */
            if ($validated['status'] === 'selesai') {

                // Sync ke order
                $pickup->order()->update([
                    'status' => 'selesai'
                ]);
            }
        });

        return redirect()
            ->route('pickup.index')
            ->with('success', 'Pickup berhasil diperbarui.');
    }
}
