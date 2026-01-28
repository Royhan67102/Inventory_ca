<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Services\AcrylicStockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductionController extends Controller
{
    /* =====================
     * LIST PRODUKSI (SPK)
     * ===================== */
    public function index()
    {
        $productions = Production::with([
                'order.customer',
                'order.items',
                'order.deliveryNote'
            ])
            ->latest()
            ->get();

        return view('productions.index', compact('productions'));
    }

    /* =====================
     * DETAIL PRODUKSI
     * ===================== */
    public function show(Production $production)
    {
        $production->load([
            'order.customer',
            'order.items'
        ]);

        return view('productions.show', compact('production'));
    }

    /* =====================
     * FORM EDIT PRODUKSI
     * ===================== */
    public function edit(Production $production)
    {
        if ($production->status_lock) {
            return redirect()
                ->route('productions.index')
                ->with('error', 'SPK sudah selesai dan terkunci.');
        }

        return view('productions.edit', compact('production'));
    }

    /* =====================
     * UPDATE PRODUKSI
     * ===================== */
    public function update(Request $request, Production $production)
{
    if ($production->status_lock) {
        return back()->with('error', 'SPK sudah terkunci.');
    }

    $validated = $request->validate([
        'status'       => 'required|in:menunggu,proses,selesai',
        'tim_produksi' => 'required|string|max:255',
        'catatan'      => 'nullable|string|max:1000',
        'bukti'        => 'nullable|image|max:2048',
    ]);

    try {
        DB::transaction(function () use ($request, $production, $validated) {

            // SET TANGGAL MULAI
            if ($validated['status'] === 'proses' && !$production->tanggal_mulai) {
                $production->tanggal_mulai = now();
            }

            // UPLOAD BUKTI
            if ($request->hasFile('bukti')) {
                if ($production->bukti) {
                    Storage::delete($production->bukti);
                }

                $production->bukti = $request
                    ->file('bukti')
                    ->store('productions', 'public');
            }

            // STATUS SELESAI
            if ($validated['status'] === 'selesai') {

                if (!$production->bukti) {
                    throw ValidationException::withMessages([
                        'bukti' => 'Bukti produksi wajib diupload.'
                    ]);
                }

                if (!$production->stok_dipotong) {
                    foreach ($production->order->items as $item) {
                        AcrylicStockService::useForOrderItem($item);
                    }
                    $production->stok_dipotong = true;
                }

                $production->tanggal_selesai = now();
                $production->status_lock = true;
            }

            // SIMPAN PRODUKSI
            $production->update([
                'status'       => $validated['status'],
                'tim_produksi' => $validated['tim_produksi'],
                'catatan'      => $validated['catatan'] ?? null,
            ]);

            // UPDATE STATUS ORDER
            if ($validated['status'] === 'selesai') {
                $production->order->update([
                    'status_produksi' => 'selesai'
                ]);
            }
        });

    } catch (\Throwable $e) {
        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }

    return redirect()
        ->route('productions.index')
        ->with('success', 'Produksi berhasil diperbarui.');
}

}