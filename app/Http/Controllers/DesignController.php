<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DesignController extends Controller
{
    /* =====================
     * LIST DESAIN
     * ===================== */
    public function index()
    {
        $designs = Design::with([
        'order.customer'
        ])
        ->latest()
        ->get();

    return view('designs.index', compact('designs'));
    }


    public function show(Design $design)
    {
        $design->load('order.customer'); // pastikan customer tersedia
        if (!$design->order) {
            abort(404, 'Order terkait desain tidak ditemukan');
        }

        return view('designs.show', compact('design'));
    }

    public function edit(Design $design)
    {
        if (!$design->order) {
            abort(404, 'Order terkait desain tidak ditemukan');
        }

        // load relasi order + customer agar nama customer muncul
        $design->order->load('customer');

        return view('designs.edit', compact('design'));
    }

    public function update(Request $request, Design $design)
        {
            $validated = $request->validate([
                'designer'   => 'nullable|string|max:100',
                'status'     => 'required|in:menunggu,proses,selesai',
                'catatan'    => 'nullable|string',
                'file_hasil' => 'nullable|file|max:10240',
            ]);

            $data = [
                'designer' => $validated['designer'] ?? null,
                'status'   => $validated['status'],
                'catatan'  => $validated['catatan'] ?? null,
            ];

            if ($request->hasFile('file_hasil')) {
                $data['file_hasil'] = $request->file('file_hasil')
                    ->store('designs', 'public');
            }

            if ($validated['status'] === 'selesai') {
                $data['tanggal_selesai'] = now();
            } else {
                $data['tanggal_selesai'] = null;
            }


            $design->update($data);

            return redirect()
            ->route('designs.index')
            ->with('success', 'Status desain berhasil diperbarui');
        }

    }
