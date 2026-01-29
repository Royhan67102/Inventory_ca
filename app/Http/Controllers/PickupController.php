<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PickupController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status'   => 'required|in:menunggu,siap,diambil',
            'bukti'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'catatan'  => 'nullable|string',
        ]);

        $buktiPath = null;

        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')
                                 ->store('pickups', 'public');
        }

        Pickup::create([
            'order_id' => $request->order_id,
            'status'   => $request->status,
            'bukti'    => $buktiPath,
            'catatan'  => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Pickup berhasil dibuat');
    }

    public function update(Request $request, Pickup $pickup)
    {
        $request->validate([
            'status'  => 'required|in:menunggu,siap,diambil',
            'bukti'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string',
        ]);

        if ($request->hasFile('bukti')) {
            // hapus bukti lama
            if ($pickup->bukti) {
                Storage::disk('public')->delete($pickup->bukti);
            }

            $pickup->bukti = $request->file('bukti')
                                     ->store('pickups', 'public');
        }

        $pickup->update([
            'status'  => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Pickup berhasil diperbarui');
    }
}
