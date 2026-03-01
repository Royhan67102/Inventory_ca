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
    public function index(Request $request)
    {
        $query = Pickup::with([
            'order.customer'
        ])
        ->where('status', 'menunggu');

        // 🔎 SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Cari berdasarkan invoice_number
                $q->whereHas('order', function ($q2) use ($search) {
                    $q2->where('invoice_number', 'like', "%$search%");
                })

                // Cari berdasarkan nama customer
                ->orWhereHas('order.customer', function ($q3) use ($search) {
                    $q3->where('nama', 'like', "%$search%");
                });

            });
        }

        $pickups = $query->latest()->paginate(10);

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
        });

        return redirect()
            ->route('pickup.index')
            ->with('success', 'Pickup berhasil diperbarui.');
    }
}
