<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            ->whereIn('status', ['menunggu', 'proses']) // lebih aman
            ->latest()
            ->get();

        return view('designs.index', compact('designs'));
    }

    /* =====================
     * DETAIL DESAIN
     * ===================== */
    public function show(Design $design)
    {
        $design->load('order.customer');

        if (!$design->order) {
            abort(404, 'Order terkait desain tidak ditemukan');
        }

        return view('designs.show', compact('design'));
    }

    /* =====================
     * FORM EDIT DESAIN
     * ===================== */
    public function edit(Design $design)
    {
        if ($design->status === 'selesai') {
            return redirect()
                ->route('designs.index')
                ->with('error', 'Desain sudah selesai dan terkunci.');
        }

        $design->load('order.customer');

        return view('designs.edit', compact('design'));
    }

    /* =====================
     * UPDATE DESAIN
     * ===================== */
    public function update(Request $request, Design $design)
    {
        // 🔒 Jika sudah selesai, tidak bisa diubah
        if ($design->status === 'selesai') {
            return back()->with('error', 'Desain sudah selesai dan tidak dapat diubah.');
        }

        $validated = $request->validate([
            'designer'   => 'required|string|max:100',
            'status'     => 'required|in:menunggu,proses,selesai',
            'deadline'   => 'nullable|date_format:d/m/Y',
            'catatan'    => 'nullable|string',
            'file_hasil' => 'required|file|max:10240',
        ]);

        DB::transaction(function () use ($request, $validated, $design) {

            /* =====================
             * VALIDASI TRANSISI STATUS
             * ===================== */

            // Tidak boleh lompat dari menunggu langsung ke selesai
            $allowedTransitions = [
                'menunggu' => ['proses', 'selesai'],
                'proses'   => ['selesai'],
            ];

            if (
                isset($allowedTransitions[$design->status]) &&
                !in_array($validated['status'], $allowedTransitions[$design->status]) &&
                $validated['status'] !== $design->status
            ) {
                return back()->with('error', 'Transisi status tidak valid.');
            }

            $data = [
                'designer' => $validated['designer'] ?? null,
                'status'   => $validated['status'],
                'catatan'  => $validated['catatan'] ?? null,
            ];

            /* =====================
            * FORMAT DEADLINE
            * ===================== */
            if ($request->deadline) {
                $data['deadline'] = \Carbon\Carbon::createFromFormat(
                    'd/m/Y',
                    $request->deadline
                )->format('Y-m-d');
            }

            /* =====================
             * HANDLE FILE
             * ===================== */
            if ($request->hasFile('file_hasil')) {

                // hapus file lama jika ada
                if ($design->file_hasil) {
                    Storage::disk('public')->delete($design->file_hasil);
                }

                $data['file_hasil'] = $request->file('file_hasil')
                    ->store('designs', 'public');
            }

            /* =====================
             * TANGGAL SELESAI
             * ===================== */
            if (
                $validated['status'] === 'selesai' &&
                !$design->tanggal_selesai
            ) {
                $data['tanggal_selesai'] = now();
            }

            $design->update($data);

            // ✅ Model event handler di Design.php akan otomatis:
            // - Membuat Production
            // - Mengupdate status order ke 'produksi'
        });

        return redirect()
            ->route('designs.index')
            ->with('success', 'Status desain berhasil diperbarui.');
    }
}
