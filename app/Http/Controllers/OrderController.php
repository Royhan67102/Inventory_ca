<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Production;
use App\Models\DeliveryNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /* =====================
     * LIST ORDER
     * ===================== */
    public function index()
    {
        $orders = Order::with(['customer', 'production', 'deliveryNote'])
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
            'nama'      => 'required|string|max:100',
            'alamat'    => 'required|string',
            'no_telp'   => 'required|string|max:20',

            // ORDER
            'tanggal_pemesanan' => 'required|date',
            'deadline'          => 'nullable|date',
            'payment_status'    => 'required|in:belum_bayar,dp,lunas',
            'keterangan'        => 'nullable|string',

            // DELIVERY
            'antar_barang'     => 'required|in:ya,tidak',
            'biaya_pengiriman' => 'nullable|numeric|min:0',

            // ITEM
            'product_name.*' => 'required|string',
            'jenis_order.*'  => 'required|in:custom,lembar',

            'panjang_cm.*'   => 'required|numeric|min:0',
            'lebar_cm.*'     => 'required|numeric|min:0',
            'qty.*'          => 'required|integer|min:1',

            'harga_per_cm2.*' => 'nullable|numeric|min:0',
            'harga_per_lembar.*' => 'nullable|numeric|min:0',

            // MATERIAL SNAPSHOT
            'acrylic_merk.*'    => 'required|string',
            'acrylic_warna.*'   => 'required|string',
            'ketebalan_mm.*'    => 'required|numeric|min:0',

            // SUMBER BAHAN
            'sumber_bahan.*' => 'required|in:lembar_utuh,limbah',
        ]);

        DB::transaction(function () use ($validated, $request) {

            /* =====================
             * CUSTOMER
             * ===================== */
            $customer = Customer::create([
                'nama'    => $validated['nama'],
                'alamat'  => $validated['alamat'],
                'no_telp' => $validated['no_telp'],
            ]);

            /* =====================
             * ORDER
             * ===================== */
            $order = Order::create([
                'customer_id'       => $customer->id,
                'invoice_number'    => 'INV-' . now()->format('YmdHis'),
                'tanggal_pemesanan' => $validated['tanggal_pemesanan'],
                'deadline'          => $validated['deadline'] ?? null,
                'payment_status'    => $validated['payment_status'],
                'status_produksi'   => 'menunggu',
                'antar_barang'      => $validated['antar_barang'] === 'ya',
                'biaya_pengiriman'  => $validated['biaya_pengiriman'] ?? 0,
                'keterangan'        => $validated['keterangan'] ?? null,
                'total_harga'       => 0,
            ]);

            /* =====================
             * ORDER ITEMS
             * ===================== */
            $totalItem = 0;

            foreach ($validated['product_name'] as $i => $name) {

                $panjang = $validated['panjang_cm'][$i];
                $lebar   = $validated['lebar_cm'][$i];
                $qty     = $validated['qty'][$i];
                $luas    = $panjang * $lebar;

                $jenis   = $validated['jenis_order'][$i];

                if ($jenis === 'custom') {
                    $harga   = $validated['harga_per_cm2'][$i] ?? 0;
                    $subtotal = $luas * $qty * $harga;
                } else {
                    $harga   = $validated['harga_per_lembar'][$i] ?? 0;
                    $subtotal = $qty * $harga;
                }

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_name'  => $name,
                    'jenis_order'   => $jenis,

                    'panjang_cm'    => $panjang,
                    'lebar_cm'      => $lebar,
                    'luas_cm2'      => $luas,
                    'qty'           => $qty,

                    'acrylic_merk'  => $validated['acrylic_merk'][$i],
                    'acrylic_warna' => $validated['acrylic_warna'][$i],
                    'ketebalan_mm'  => $validated['ketebalan_mm'][$i],

                    'harga_per_cm2'     => $jenis === 'custom' ? $harga : null,
                    'harga_per_lembar' => $jenis === 'lembar' ? $harga : null,

                    'subtotal' => $subtotal,
                ]);

                $totalItem += $subtotal;
            }

            /* =====================
             * TOTAL ORDER
             * ===================== */
            $order->update([
                'total_harga' => $totalItem + $order->biaya_pengiriman,
            ]);

            /* =====================
             * PRODUKSI (SPK)
             * ===================== */
            Production::create([
                'order_id' => $order->id,
                'status'   => 'menunggu',
                'catatan'  => 'SPK otomatis dari order',
            ]);

            /* =====================
             * DELIVERY NOTE
             * ===================== */
            if ($order->antar_barang) {
                DeliveryNote::create([
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
        $order->load(['customer', 'items', 'production', 'deliveryNote']);
        return view('orders.show', compact('order'));
    }

    /* =====================
     * BATALKAN
     * ===================== */
    public function destroy(Order $order)
    {
        $order->update([
            'status_produksi' => 'dibatalkan'
        ]);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order dibatalkan');
    }
}
