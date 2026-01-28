<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Production;
use App\Models\DeliveryNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;



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
    'nama'   => 'required|string|max:100',
    'alamat' => 'required|string',

    // ORDER
    'tanggal_pemesanan' => 'required|date',
    'deadline'          => 'nullable|date',
    'payment_status'    => 'required|in:belum_bayar,dp,lunas',

    // DELIVERY
    'antar_barang'     => 'required|in:ya,tidak',
    'biaya_pengiriman' => 'nullable|numeric|min:0',

    // JASA PASANG
    'jasa_pemasangan'  => 'required|in:ya,tidak',
    'biaya_pemasangan' => 'nullable|numeric|min:0',

    // ITEM
    'product_name.*'    => 'required|string',
    'acrylic_brand.*'   => 'nullable|string',
    'panjang_cm.*'      => 'required|numeric|min:0',
    'lebar_cm.*'        => 'required|numeric|min:0',
    'qty.*'             => 'required|integer|min:1',
    'harga_per_m2.*'    => 'required|numeric|min:0',
]);


        
        Log::info('Validated Order Data:', $validated);
        DB::transaction(function () use ($validated, $request) {

            /* =====================
             * CUSTOMER
             * ===================== */
            $customer = Customer::create([
                'nama'    => $validated['nama'],
                'alamat'  => $validated['alamat'],
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

    // cm → m
    $luas_m2 = ($panjang / 100) * ($lebar / 100);
    $harga   = $validated['harga_per_m2'][$i];

    $subtotal = $luas_m2 * $harga * $qty;

    OrderItem::create([
        'order_id'     => $order->id,
        'product_name' => $name,
        'acrylic_merk' => $validated['acrylic_brand'][$i] ?? null,
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

    // EDIT
    public function edit(Order $order)
{
    return view('orders.edit', compact('order'));
}


// UPDATE

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
     * BATALKAN
     * ===================== */
    public function destroy(Order $order)
{
    $order->delete();

    return redirect()
        ->route('orders.index')
        ->with('success', 'Order berhasil dihapus');
}


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
