<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Production;
use App\Models\DeliveryNote;
use App\Models\Design;
use App\Models\Pickup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /* =====================
     * LIST ORDER
     * ===================== */
    public function index()
    {
        $orders = Order::with([
            'customer',
            'production',
            'deliveryNote',
            'design',
            'pickup'
        ])->latest()->get();

        return view('orders.index', compact('orders'));
    }

    /* =====================
     * FORM CREATE
     * ===================== */
    public function create()
    {
        return view('orders.create');
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }


    /* =====================
     * SIMPAN ORDER
     * ===================== */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // customer
            'nama'     => 'required|string|max:100',
            'alamat'   => 'required|string',
            'telepon'  => 'required|string|max:20',

            // order
            'tanggal_pemesanan' => 'required|date',
            'deadline'          => 'nullable|date',
            'payment_status'    => 'required|in:belum_bayar,dp,lunas',
            'tipe_order'        => 'required|in:custom,lembaran',

            // jasa
            'antar_barang'      => 'required|in:0,1',
            'biaya_pengiriman'  => 'nullable|numeric|min:0',
            'jasa_pemasangan'   => 'required|in:0,1',
            'biaya_pemasangan'  => 'nullable|numeric|min:0',
            'jasa_desain'       => 'nullable|in:0,1',

            // items
            'merk.*'       => 'nullable|string',
            'ketebalan.*'  => 'nullable|string',
            'warna.*'      => 'nullable|string',
            'panjang_cm.*' => 'nullable|numeric|min:0',
            'lebar_cm.*'   => 'nullable|numeric|min:0',
            'qty.*'        => 'nullable|integer|min:1',
            'harga.*'      => 'nullable|numeric|min:0',

            // file
            'file_desain'  => 'nullable|file|max:51200',
        ]);

        DB::transaction(function () use ($validated, $request) {

            /* ========== CUSTOMER ========== */
            $customer = Customer::create([
                'nama'    => $validated['nama'],
                'alamat'  => $validated['alamat'],
                'telepon' => $validated['telepon'],
            ]);

            /* ========== STATUS AWAL ========== */
            $status = $validated['tipe_order'] === 'custom'
                ? 'desain'
                : ($validated['antar_barang'] ? 'delivery' : 'pickup');

            /* ========== ORDER ========== */
            $order = Order::create([
                'customer_id'       => $customer->id,
                'invoice_number'    => 'INV-' . now()->format('YmdHis'),
                'tanggal_pemesanan' => $validated['tanggal_pemesanan'],
                'deadline'          => $validated['deadline'] ?? null,
                'payment_status'    => $validated['payment_status'],
                'status'            => $status,
                'antar_barang'      => $validated['antar_barang'],
                'biaya_pengiriman'  => $validated['biaya_pengiriman'] ?? 0,
                'jasa_pemasangan'   => $validated['jasa_pemasangan'],
                'biaya_pemasangan'  => $validated['biaya_pemasangan'] ?? 0,
                'catatan'           => $validated['catatan'] ?? null,
                'total_harga'       => 0,
            ]);

            /* ========== ITEMS ========== */
            $totalItem = 0;
            $hasDesign = ($validated['jasa_desain'] ?? '0') == '1';

            foreach ($validated['merk'] ?? [] as $i => $merk) {

                if (
                    empty($validated['panjang_cm'][$i]) ||
                    empty($validated['lebar_cm'][$i]) ||
                    empty($validated['qty'][$i]) ||
                    empty($validated['harga'][$i])
                ) continue;

                $subtotal = $validated['harga'][$i] * $validated['qty'][$i];

                OrderItem::create([
                    'order_id'   => $order->id,
                    'merk'       => $merk,
                    'ketebalan'  => $validated['ketebalan'][$i] ?? null,
                    'warna'      => $validated['warna'][$i] ?? null,
                    'panjang_cm' => $validated['panjang_cm'][$i],
                    'lebar_cm'   => $validated['lebar_cm'][$i],
                    'luas_cm2'   => $validated['panjang_cm'][$i] * $validated['lebar_cm'][$i],
                    'qty'        => $validated['qty'][$i],
                    'harga'      => $validated['harga'][$i],
                    'subtotal'   => $subtotal,
                ]);

                $totalItem += $subtotal;
            }

            /* ========== TOTAL ========== */
            $order->update([
                'total_harga' =>
                    $totalItem +
                    $order->biaya_pengiriman +
                    $order->biaya_pemasangan
            ]);

            /* ========== DESAIN ========== */
            if ($hasDesign && $request->hasFile('file_desain')) {

                $path = $request->file('file_desain')
                    ->store('desain/order', 'public');

                Design::create([
                    'order_id'  => $order->id,
                    'status'    => 'menunggu',
                    'file_awal' => $path,
                ]);
            }

            /* ========== PRODUKSI ========== */
            Production::create([
                'order_id' => $order->id,
                'status'   => 'menunggu',
                'catatan'  => 'SPK otomatis dari order',
            ]);

            /* ========== DELIVERY / PICKUP ========== */
            if ($order->antar_barang) {
                DeliveryNote::create([
                    'order_id' => $order->id,
                    'status'   => 'menunggu',
                ]);
            } else {
                Pickup::create([
                    'order_id' => $order->id,
                    'status'   => 'menunggu',
                ]);
            }
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order berhasil dibuat');
    }

    /* =====================
     * DETAIL
     * ===================== */
    public function show(Order $order)
    {
        $order->load(['customer', 'items', 'design', 'production', 'deliveryNote', 'pickup']);
        return view('orders.show', compact('order'));
    }

    /* =====================
     * UPDATE
     * ===================== */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'alamat'         => 'required|string',
            'payment_status' => 'required|in:belum_bayar,dp,lunas',
            'deadline'       => 'nullable|date',
            'catatan'        => 'nullable|string',
            'jasa_desain'    => 'nullable|in:0,1',
            'file_desain'    => 'nullable|file|max:51200',
        ]);

        $order->customer->update([
            'alamat' => $validated['alamat'],
        ]);

        $order->update([
            'payment_status' => $validated['payment_status'],
            'deadline'       => $validated['deadline'],
            'catatan'        => $validated['catatan'] ?? null,
        ]);

        if (($validated['jasa_desain'] ?? '0') == '1' && $request->hasFile('file_desain')) {

            $order->design()->updateOrCreate(
                ['order_id' => $order->id],
                [
                    'status'    => 'menunggu',
                    'file_awal' => $request->file('file_desain')
                        ->store('desain/order', 'public'),
                ]
            );
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order berhasil diperbarui');
    }

    /* =====================
     * DELETE
     * ===================== */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order berhasil dihapus');
    }

    /* =====================
     * INVOICE
     * ===================== */
    public function downloadInvoice(Order $order)
    {
        $order->load(['customer', 'items']);

        $pdf = Pdf::loadView('orders.invoice-pdf', compact('order'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Invoice-' . $order->invoice_number . '.pdf');
    }
}
