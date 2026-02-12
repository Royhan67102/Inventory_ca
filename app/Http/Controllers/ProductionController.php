<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            ->whereIn('status', ['menunggu', 'proses']) // lebih aman
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
        if ($production->isSelesai()) {
            return redirect()
                ->route('productions.index')
                ->with('error', 'Produksi sudah selesai dan terkunci.');
        }

        return view('productions.edit', compact('production'));
    }

    /* =====================
     * UPDATE PRODUCTION
     * ===================== */
    public function update(Request $request, Production $production)
    {
        // 🔒 Jika sudah selesai, tidak bisa diubah
        if ($production->isSelesai()) {
            return back()->with('error', 'Produksi sudah selesai dan tidak dapat diubah.');
        }

        $validated = $request->validate([
            'tim_produksi'       => 'nullable|string|max:255',
            'status'             => 'required|in:menunggu,proses,selesai',
            'catatan'            => 'nullable|string',
            'bukti'              => 'nullable|file|max:10240',
        ]);

        /* =====================
         * VALIDASI TRANSISI STATUS
         * ===================== */

        // Tidak boleh lompat dari menunggu langsung ke selesai
        $allowedTransitions = [
            'menunggu' => ['proses', 'selesai'],
            'proses'   => ['selesai'],
        ];

        if (
            isset($allowedTransitions[$production->status]) &&
            !in_array($validated['status'], $allowedTransitions[$production->status]) &&
            $validated['status'] !== $production->status
        ) {
            return back()->with('error', 'Transisi status tidak valid.');
        }

        /* =====================
         * HANDLE FILE
         * ===================== */
        if ($request->hasFile('bukti')) {

            // hapus bukti lama jika ada
            if ($production->bukti) {
                Storage::disk('public')->delete($production->bukti);
            }

            $validated['bukti'] = $request->file('bukti')
                ->store('productions', 'public');
        }

        /* =====================
         * UPDATE DATA
         * ===================== */
        $production->update($validated);

        // ⚠️ Tidak perlu update order di sini
        // Karena sudah ditangani di Model (booted updating)

        return redirect()
            ->route('productions.index')
            ->with('success', 'Production berhasil diperbarui.');
    }
}
