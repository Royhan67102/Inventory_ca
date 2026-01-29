<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Production;
use App\Models\DeliveryNote;

// === TAMBAHAN ===
use App\Models\Design;
use App\Models\Pickup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    /* =====================
     * LIST ORDER (ADMIN)
     * ===================== */
    public function index()
    {
        $orders = Order::with([
            'customer',
            'production',
            'deliveryNote',

            // === TAMBAHAN ===
            'design',
            'pickup'
        ])
        ->latest()
        ->get();

        return view('orders.index', compact('orders'));
    }

    /* =====================
     * FORM CREATE
     * ===================== */
    public function create()
    {
        return view('orders.create');
    }

    /* =====================
     * SIMPAN ORDER
     * ===================== */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // CUSTOMER
            'nama'   => 'required|string|max:100',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',

            // ORDER
            'tanggal_pemesanan' => 'required|date',
            'deadline'          => 'nullable|date',
            'payment_status'    => 'required|in:belum_bayar,dp,lunas',

            // DELIVERY
            'antar_barang'     => 'required|in:0,1',
            'biaya_pengiriman' => 'nullable|numeric|min:0',

            // JASA PASANG
            'jasa_pemasangan'  => 'required|in:0,1',
            'biaya_pemasangan' => 'nullable|numeric|min:0',

            // ITEM
            'merk.*'       => 'nullable|string',
            'ketebalan.*'  => 'nullable|string',
            'warna.*'      => 'nullable|string',
            'panjang_cm.*' => 'required|numeric|min:0',
            'lebar_cm.*'   => 'required|numeric|min:0',
            'qty.*'        => 'required|integer|min:1',
            'harga.*'      => 'required|numeric|min:0',
            'subtotal.*'   => 'required|string',

            // === TAMBAHAN ===
            'jasa_desain'     => 'nullable|in:0,1',
            'file_desain'     => 'nullable|file'
        ]);

        Log::info('Validated Order Data:', $validated);

        DB::transaction(function () use ($validated, $request) {

            /* =====================
             * CUSTOMER
             * ===================== */
            $customer = Customer::create([
                'nama'   => $validated['nama'],
                'alamat' => $validated['alamat'],
                'telepon' => $validated['telepon'],
            ]);

             /* =====================
             * STATUS AWAL ORDER
             * ===================== */
            $status = 'desain';

            if (($validated['jasa_desain'] ?? '0') == '0') {
                $status = $validated['antar_barang'] == '1'
                    ? 'delivery'
                    : 'pickup';
            }

            /* =====================
             * ORDER
             * ===================== */
            $order = Order::create([
                'customer_id'       => $customer->id,
                'invoice_number'    => 'INV-' . now()->format('YmdHis'),
                'tanggal_pemesanan' => $validated['tanggal_pemesanan'],
                'deadline'          => $validated['deadline'] ?? null,
                'payment_status'    => $validated['payment_status'],
                'status'            => $status,

                'antar_barang'      => $validated['antar_barang'] == '1',
                'biaya_pengiriman'  => $validated['biaya_pengiriman'] ?? 0,

                'jasa_pemasangan'   => $validated['jasa_pemasangan'] == '1',
                'biaya_pemasangan'  => $validated['biaya_pemasangan'] ?? 0,

                'catatan'           => $validated['keterangan'] ?? null,
                'total_harga'       => 0,
            ]);

            /* =====================
            * ORDER ITEMS
            * ===================== */
            $totalItem = 0;
            $hasCustomItem = false;

            foreach ($validated['merk'] as $i => $name) {

                $panjang = $validated['panjang_cm'][$i];
                $lebar   = $validated['lebar_cm'][$i];
                $qty     = $validated['qty'][$i];
                $harga   = $validated['harga'][$i];

                // luas m2
                $luas_m2 = ($panjang * $lebar) / 10000;
                $subtotal = $luas_m2 * $harga * $qty;

                $hasCustomItem = true;

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_name' => $name,
                    'ketebalan'    => $validated['ketebalan'][$i] ?? null,
                    'warna'        => $validated['warna'][$i] ?? null,
                    'panjang_cm'   => $panjang,
                    'lebar_cm'     => $lebar,
                    'qty'          => $qty,
                    'harga'        => $harga,
                    'subtotal'     => $subtotal,
                ]);

                $totalItem += $subtotal;
            }

            /* =====================
             * TOTAL ORDER
             * ===================== */
            $order->update([
                'total_harga' =>
                    $totalItem
                    + $order->biaya_pengiriman
                    + ($validated['biaya_pemasangan'] ?? 0),
            ]);

            /* =====================
             * DESAIN (TAMBAHAN, TIDAK MENGGANGGU FLOW LAMA)
             * ===================== */
            if ($hasCustomItem || (($validated['jasa_desain'] ?? '0') == '1')) {

                $fileDesain = null;
                if ($request->hasFile('file_desain')) {
                    $fileDesain = $request->file('file_desain')
                        ->store('desain/order');
                }

                Design::create([
                    'order_id'  => $order->id,
                    'status'    => 'menunggu',
                    'file_awal' => $fileDesain,
                ]);
            }

            /* =====================
             * PRODUKSI (SPK) — TETAP ADA
             * ===================== */
            Production::create([
                'order_id' => $order->id,
                'status'   => 'menunggu',
                'catatan'  => 'SPK otomatis dari order',
            ]);

            /* =====================
             * DELIVERY NOTE (FLOW LAMA TETAP)
             * ===================== */
            if ($order->antar_barang) {
                DeliveryNote::create([
                    'order_id' => $order->id,
                    'status'   => 'menunggu',
                ]);
            }

            /* =====================
             * PICKUP (TAMBAHAN, JIKA TIDAK ANTAR)
             * ===================== */
            if (!$order->antar_barang) {
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
        $order->load([
            'customer',
            'items',
            'production',
            'deliveryNote',

            // === TAMBAHAN ===
            'design',
            'pickup'
        ]);

        return view('orders.show', compact('order'));
    }

    // EDIT
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    /* =====================
     * UPDATE ORDER
     * ===================== */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:belum_bayar,dp,lunas',
            'deadline'       => 'nullable|date',
            'catatan'        => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order berhasil diperbarui');
    }

    /* =====================
     * HAPUS
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
    public function invoice(Order $order)
    {
        $order->load(['customer', 'items']);
        return view('orders.invoice', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        $order->load(['customer', 'items']);

        $pdf = Pdf::loadView('orders.invoice-pdf', compact('order'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Invoice-' . $order->invoice_number . '.pdf');
    }
}
