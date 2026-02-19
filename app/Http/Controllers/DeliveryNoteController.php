<?php

namespace App\Http\Controllers;

use App\Models\DeliveryNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;


class DeliveryNoteController extends Controller
{
    /* =====================
     * LIST DELIVERY
     * ===================== */
    public function index()
    {
        $deliveries = DeliveryNote::with([
                'order.customer'
            ])
            ->where('status', '!=', 'selesai')
            ->latest()
            ->get();

        return view('delivery.index', compact('deliveries'));
    }

    /* =====================
     * DETAIL DELIVERY
     * ===================== */
    public function show(DeliveryNote $delivery)
    {
        $delivery->load([
            'order.customer',
            'order.design'
        ]);

        return view('delivery.show', compact('delivery'));
    }

    /* =====================
     * FORM EDIT DELIVERY
     * ===================== */
    public function edit(DeliveryNote $delivery)
    {
        if ($delivery->status === 'selesai') {
            return redirect()
                ->route('delivery.index')
                ->with('error', 'Delivery sudah selesai dan terkunci');
        }

        return view('delivery.edit', compact('delivery'));
    }

    /* =====================
     * UPDATE DELIVERY
     * ===================== */
    public function update(Request $request, DeliveryNote $delivery)
    {
        if ($delivery->status === 'selesai') {
            return redirect()
                ->route('delivery.index')
                ->with('error', 'Delivery sudah selesai dan tidak bisa diubah');
        }

        $validated = $request->validate([
            'nama_pengirim'      => 'required|string|max:255',
            'driver'             => 'required|string|max:255',
            'status'             => 'required|in:menunggu,proses,selesai',
            'jam_berangkat'      => 'nullable|string',
            'jam_sampai_tujuan'  => 'nullable|string',
            'jam_kembali'        => 'nullable|string',
            'bukti_foto'         => 'nullable|file|image|max:10240',
        ]);

        try {
            DB::transaction(function () use ($request, $validated, $delivery) {

                // Validasi transisi status - hanya jika status benar-benar berubah
                $newStatus = $validated['status'];
                $currentStatus = $delivery->status;

                if ($newStatus !== $currentStatus) {
                    // Transisi yang diperbolehkan (izinkan langsung ke 'selesai')
                    $allowedTransitions = [
                        'menunggu' => ['proses', 'selesai'],
                        'proses'   => ['selesai'],
                    ];

                    // Jika transisi tidak valid, lempar exception
                    if (!isset($allowedTransitions[$currentStatus]) || !in_array($newStatus, $allowedTransitions[$currentStatus])) {
                        throw new \Exception('Transisi status tidak valid: dari ' . ucfirst($currentStatus) . ' ke ' . ucfirst($newStatus) . '. Diizinkan: ' . (isset($allowedTransitions[$currentStatus]) ? implode(', ', $allowedTransitions[$currentStatus]) : 'tidak ada'));
                    }
                }

                $data = $validated;

                // Handle file upload
                if ($request->hasFile('bukti_foto')) {
                    // Hapus foto lama jika ada
                    if ($delivery->bukti_foto) {
                        Storage::disk('public')->delete($delivery->bukti_foto);
                    }

                    $data['bukti_foto'] =
                        $request->file('bukti_foto')
                            ->store('deliveries', 'public');
                }

                // Update delivery - model event handler akan otomatis update order status
                $delivery->update($data);

            });

            return redirect()
                ->route('delivery.index')
                ->with('success', 'Delivery berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function previewSuratJalan(DeliveryNote $delivery)
    {
        $delivery->load('order.customer');

        return view('delivery.preview-suratjln', compact('delivery'));
    }

    public function suratJalan(DeliveryNote $delivery)
    {
        $delivery->load('order.customer');

        $pdf = Pdf::loadView(
            'delivery.suratjln',
            compact('delivery')
        )->setPaper('A4', 'portrait');

        return $pdf->download(
            'suratjln-' . $delivery->order->invoice_number . '.pdf'
        );
    }

}
