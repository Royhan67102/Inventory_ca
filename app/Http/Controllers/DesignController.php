<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Design;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    /* =====================
     * LIST DESAIN
     * ===================== */
    public function index()
    {
        $designs = Design::with('order.customer')
            ->latest()
            ->get();

        return view('designs.index', compact('designs'));
    }

    /* =====================
     * FORM DESAIN
     * ===================== */
    public function create(Order $order)
    {
        return view('designs.create', compact('order'));
    }

    /* =====================
     * SIMPAN DESAIN
     * ===================== */
    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            'designer' => 'nullable|string|max:100',
            'status'   => 'required|in:menunggu,proses,revisi,selesai',
            'catatan'  => 'nullable|string',
        ]);

        Design::create([
            'order_id' => $order->id,
            'designer' => $validated['designer'] ?? null,
            'status'   => $validated['status'],
            'catatan'  => $validated['catatan'] ?? null,
        ]);

        // status order otomatis
        $order->update([
            'status_produksi' => 'desain',
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Desain berhasil ditambahkan');
    }

    /* =====================
     * UPDATE DESAIN
     * ===================== */
    public function update(Request $request, Design $design)
    {
        $validated = $request->validate([
            'designer' => 'nullable|string|max:100',
            'status'   => 'required|in:menunggu,proses,revisi,selesai',
            'catatan'  => 'nullable|string',
        ]);

        $design->update([
            'designer' => $validated['designer'] ?? null,
            'status'   => $validated['status'],
            'catatan'  => $validated['catatan'] ?? null,
        ]);

        // kalau desain selesai → produksi
        if ($design->status === 'selesai') {
            $design->order?->update([
                'status_produksi' => 'produksi',
            ]);
        }

        return back()->with('success', 'Desain berhasil diperbarui');
    }
}
