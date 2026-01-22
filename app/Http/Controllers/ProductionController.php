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
            // STATUS UMUM
            'status' => 'required|in:menunggu,proses,selesai',

            // DESAIN
            'desain_selesai' => 'nullable|boolean',
            'catatan_desain' => 'nullable|string|max:1000',
            'bukti_desain'   => 'nullable|image|max:2048',

            // PRODUKSI
            'produksi_selesai' => 'nullable|boolean',
            'catatan_produksi' => 'nullable|string|max:1000',
            'bukti_produksi'   => 'nullable|image|max:2048',
        ]);

        try {
            DB::transaction(function () use ($request, $production, $validated) {

                /* =====================
                 * STATUS PROSES
                 * ===================== */
                if ($validated['status'] === 'proses' && !$production->tanggal_mulai) {
                    $production->tanggal_mulai = now();
                }

                /* =====================
                 * UPLOAD BUKTI DESAIN
                 * ===================== */
                if ($request->hasFile('bukti_desain')) {
                    if ($production->bukti_desain) {
                        Storage::delete($production->bukti_desain);
                    }

                    $production->bukti_desain = $request
                        ->file('bukti_desain')
                        ->store('productions/desain');
                }

                /* =====================
                 * UPLOAD BUKTI PRODUKSI
                 * ===================== */
                if ($request->hasFile('bukti_produksi')) {
                    if ($production->bukti_produksi) {
                        Storage::delete($production->bukti_produksi);
                    }

                    $production->bukti_produksi = $request
                        ->file('bukti_produksi')
                        ->store('productions/produksi');
                }

                /* =====================
                 * VALIDASI SELESAI
                 * ===================== */
                if ($validated['status'] === 'selesai') {

                    if (!$request->desain_selesai || !$request->produksi_selesai) {
                        throw ValidationException::withMessages([
                            'status' => 'Desain dan Produksi harus selesai.'
                        ]);
                    }

                    if (!$production->bukti_produksi) {
                        throw ValidationException::withMessages([
                            'bukti_produksi' => 'Bukti produksi wajib diupload.'
                        ]);
                    }

                    // POTONG STOK (1x saja)
                    if (!$production->stok_dipotong) {
                        foreach ($production->order->items as $item) {
                            AcrylicStockService::useForOrderItem($item);
                        }
                        $production->stok_dipotong = true;
                    }

                    $production->tanggal_selesai = now();
                    $production->status_lock     = true;
                }

                /* =====================
                 * SIMPAN PRODUKSI
                 * ===================== */
                $production->update([
                    'status'            => $validated['status'],
                    'desain_selesai'    => $request->desain_selesai ?? false,
                    'produksi_selesai'  => $request->produksi_selesai ?? false,
                    'catatan_desain'    => $validated['catatan_desain'] ?? null,
                    'catatan_produksi'  => $validated['catatan_produksi'] ?? null,
                ]);

                /* =====================
                 * UPDATE STATUS ORDER
                 * ===================== */
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
            ->with('success', 'SPK berhasil diperbarui.');
    }
}
