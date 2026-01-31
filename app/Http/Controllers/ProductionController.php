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
    public function index(Request $request)
    {
        $query = Production::with([
            'order.customer',
            'order.items',
            'order.deliveryNote',
            'order.pickup'
        ]);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->whereHas('order.customer', function ($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%');
            })->orWhereHas('order', function ($q) use ($request) {
                $q->where('id', 'like', '%'.$request->search.'%');
            });
        }

        $productions = $query->latest()->get();

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

                /* =====================
                 * UPLOAD BUKTI
                 * ===================== */
                if ($request->hasFile('bukti')) {
                    if ($production->bukti) {
                        Storage::disk('public')->delete($production->bukti);
                    }

                    $production->bukti = $request
                        ->file('bukti')
                        ->store('productions', 'public');
                }

                /* =====================
                 * STATUS SELESAI
                 * ===================== */
                if ($validated['status'] === 'selesai') {

                    if (!$production->bukti) {
                        throw ValidationException::withMessages([
                            'bukti' => 'Bukti produksi wajib diupload.'
                        ]);
                    }

                    // potong stok hanya sekali
                    if (!$production->stok_dipotong) {
                        foreach ($production->order->items as $item) {
                            AcrylicStockService::useForOrderItem($item);
                        }
                        $production->stok_dipotong = true;
                    }

                    $production->status_lock = true;
                }

                /* =====================
                 * SIMPAN PRODUKSI
                 * ===================== */
                $production->update([
                    'status'       => $validated['status'],
                    'tim_produksi' => $validated['tim_produksi'],
                    'catatan'      => $validated['catatan'] ?? null,
                    'bukti'        => $production->bukti,
                    'stok_dipotong'=> $production->stok_dipotong,
                    'status_lock'  => $production->status_lock,
                ]);

                /*
                 * STATUS ORDER tidak diupdate di sini.
                 * Sudah otomatis diatur di Model Production.
                 */
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
