<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        $pickups = Pickup::with('order.customer')
            ->latest()
            ->get();

        return view('pickups.index', compact('pickups'));
    }

    public function show(Order $order)
    {
        $pickup = $order->pickup;

        if (!$pickup) {
            abort(404);
        }

        return view('pickups.show', compact('order', 'pickup'));
    }

    /* =====================
     * FORM EDIT PICKUP
     * ===================== */
    public function edit(Order $order)
    {
        $pickup = $order->pickup;

        if (!$pickup) {
            abort(404, 'Data pickup tidak ditemukan');
        }

        return view('pickups.edit', compact('order', 'pickup'));
    }

    /* =====================
     * UPDATE PICKUP
     * ===================== */
    public function update(Request $request, Order $order)
    {
        $pickup = $order->pickup;

        if (!$pickup) {
            abort(404, 'Data pickup tidak ditemukan');
        }

        $validated = $request->validate([
            'status'  => 'required|in:menunggu,siap,diambil',
            'bukti'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string|max:1000',
        ]);

        /* =====================
         * UPLOAD BUKTI
         * ===================== */
        if ($request->hasFile('bukti')) {
            if ($pickup->bukti) {
                Storage::disk('public')->delete($pickup->bukti);
            }

            $pickup->bukti = $request
                ->file('bukti')
                ->store('pickups', 'public');
        }

        /* =====================
         * UPDATE PICKUP
         * ===================== */
        $pickup->update([
            'status'  => $validated['status'],
            'catatan' => $validated['catatan'] ?? null,
            'bukti'   => $pickup->bukti,
        ]);

        /* =====================
         * AUTO FLOW ORDER
         * ===================== */
        if ($validated['status'] === 'diambil') {

            if (!$pickup->bukti) {
                return back()
                    ->withInput()
                    ->with('error', 'Bukti pickup wajib diupload.');
            }

            // order selesai
            $order->update([
                'status' => 'selesai',
            ]);
        } else {
            // pastikan tetap di pickup
            $order->update([
                'status' => 'pickup',
            ]);
        }

        return redirect()
            ->route('pickups.index')
            ->with('success', 'Pickup berhasil diperbarui.');
    }
}
