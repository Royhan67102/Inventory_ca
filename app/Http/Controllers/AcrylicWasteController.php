<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Production;
use App\Models\DeliveryNote;
use App\Models\AcrylicStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /* =====================
     * LIST ORDER
     * ===================== */
    public function index()
    {
        $orders = Order::with(['customer'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    /* =====================
     * FORM CREATE
     * ===================== */
    public function create()
    {
        $stocks = AcrylicStock::where('luas_tersedia', '>', 0)->get();

        return view('orders.create', compact('stocks'));
    }

    /* =====================
     * SIMPAN ORDER
     * ===================== */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // CUSTOMER
            'nama'     => 'required|string|max:100',
            'alamat'   => 'required|string',
            'no_telp'  => 'required|string|max:20',

            // ORDER
            'tanggal_pemesanan' => 'required|date',
            'deadline'          => 'nullable|date',
            'payment_status'    => 'required|in:belum_bayar,dp,lunas',
            'antar_barang'      => 'required|in:ya,tidak',
            'biaya_pengiriman'  => 'nullable|numeric|min:0',

            // ITEM
            'jenis_order.*'     => 'required|in:lembaran,custom',
            'acrylic_stock_id.*'=> 'nullable|exists:acrylic_stocks,id',
            'panjang_cm.*'      => 'required|numeric|min:0.1',
            'lebar_cm.*'        => 'required|numeric|min:0.1',
            'qty.*'             => 'required|integer|min:1',
            'harga.*'           => 'nullable|numeric|min:0',
            'sumber_bahan.*'    => 'required|in:lembaran,limbah',
            'keterangan.*'      => 'nullable|string'
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
                'deadline'          => $validated['deadline'],
                'payment_status'    => $validated['payment_status'],
                'antar_barang'      => $validated['antar_barang'] === 'ya',
                'biaya_pengiriman'  => $validated['biaya_pengiriman'] ?? 0,
                'total_harga'       => 0,
                'status_produksi'   => 'menunggu',
            ]);

            $grandTotal = 0;

            /* =====================
             * ORDER ITEMS
             * ===================== */
            foreach ($validated['jenis_order'] as $i => $jenis) {

                $panjang = $validated['panjang_cm'][$i];
                $lebar   = $validated['lebar_cm'][$i];
                $qty     = $validated['qty'][$i];
                $luas    = $panjang * $lebar;

                $harga = $jenis === 'lembaran'
                    ? AcrylicStock::find($validated['acrylic_stock_id'][$i])->harga_per_cm
                    : $validated['harga'][$i];

                $subtotal = $luas * $qty * $harga;

                $item = OrderItem::create([
                    'order_id'         => $order->id,
                    'jenis_order'      => $jenis,
                    'acrylic_stock_id' => $validated['acrylic_stock_id'][$i] ?? null,
                    'panjang_cm'       => $panjang,
                    'lebar_cm'         => $lebar,
                    'luas_cm2'         => $luas,
                    'qty'              => $qty,
                    'harga'            => $harga,
                    'subtotal'         => $subtotal,
                    'sumber_bahan'     => $validated['sumber_bahan'][$i],
                    'keterangan'       => $validated['keterangan'][$i] ?? null,
                ]);

                /* =====================
                 * KURANGI STOK
                 * ===================== */
                if ($jenis === 'lembaran') {
                    $stock = AcrylicStock::find($validated['acrylic_stock_id'][$i]);
                    $stock->decrement('luas_tersedia', $luas * $qty);
                }

                $grandTotal += $subtotal;
            }

            $order->update([
                'total_harga' => $grandTotal + $order->biaya_pengiriman
            ]);

            /* =====================
             * PRODUKSI (SPK)
             * ===================== */
            Production::create([
                'order_id' => $order->id,
                'status'   => 'menunggu'
            ]);

            /* =====================
             * DELIVERY
             * ===================== */
            if ($order->antar_barang) {
                DeliveryNote::create([
                    'order_id' => $order->id,
                    'status'   => 'menunggu'
                ]);
            }
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil dibuat & SPK otomatis terbentuk');
    }

    /* =====================
     * DETAIL
     * ===================== */
    public function show(Order $order)
    {
        $order->load(['customer', 'items', 'production', 'deliveryNote']);
        return view('orders.show', compact('order'));
    }
}
