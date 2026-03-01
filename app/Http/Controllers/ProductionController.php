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
    public function index(Request $request)
    {
        $query = Production::with([
                'order.customer',
                'order.design'
            ])
            ->where(function ($query) {

                $query->whereHas('order.design', function ($q) {
                    $q->where('status', 'selesai');
                })
                ->orWhereDoesntHave('order.design');
            })
            ->whereIn('status', ['menunggu', 'proses']);

        // 🔍 SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                // Cari berdasarkan status produksi
                $q->where('status', 'like', "%{$search}%")

                // Cari berdasarkan tim produksi
                ->orWhere('tim_produksi', 'like', "%{$search}%")

                // Cari berdasarkan invoice
                ->orWhereHas('order', function ($orderQuery) use ($search) {
                    $orderQuery->where('invoice_number', 'like', "%{$search}%")

                    // Cari nama customer
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('nama', 'like', "%{$search}%")
                                    ->orWhere('telepon', 'like', "%{$search}%");
                    });
                });
            });
        }

        $productions = $query->latest()->paginate(10);

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
            'tanggal_mulai'      => 'nullable|date',
            'tanggal_selesai'   => 'nullable|date|after_or_equal:tanggal_mulai',
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
        $data = $validated;

        $production->update($data);

        // ⚠️ Tidak perlu update order di sini
        // Karena sudah ditangani di Model (booted updating)

        return redirect()
            ->route('productions.index')
            ->with('success', 'Production berhasil diperbarui.');
    }
}
