<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Http\Request;

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
        return view('productions.edit', compact('production'));
    }

    /* =====================
     * UPDATE PRODUCTION
     * ===================== */
    public function update(Request $request, Production $production)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,proses,selesai'
        ]);

        $production->update([
            'status' => $validated['status']
        ]);

        return redirect()
            ->route('productions.index')
            ->with('success', 'Status production berhasil diperbarui');
    }
}
