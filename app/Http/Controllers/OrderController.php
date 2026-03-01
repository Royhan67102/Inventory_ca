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
    public function index(Request $request)
    {
        $query = Order::with([
            'customer',
            'production',
            'deliveryNote',
            'design',
            'pickup'
        ])->where('status', '!=', 'selesai');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('payment_status', 'like', "%{$search}%")
                ->orWhere('tipe_order', 'like', "%{$search}%")
                ->orWhereHas('customer', function ($c) use ($search) {
                    $c->where('nama', 'like', "%{$search}%")
                        ->orWhere('telepon', 'like', "%{$search}%");
                });
            });
        }

        $orders = $query->latest()->paginate(10);

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
        // Prevent edit jika sudah masuk tahap pickup atau delivery
        if (in_array($order->status, ['pickup', 'delivery', 'selesai'])) {
            return back()->with('error', 'Order tidak dapat diubah pada tahap ' . ucfirst($order->status) . '.');
        }

        $order->load([
            'customer',
            'items',
            'design',
            'production',
            'deliveryNote',
            'pickup'
        ]);

        return view('orders.edit', compact('order'));
    }

    /* =====================
     * STORE ORDER
     * ===================== */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:100',
            'alamat'   => 'required|string',
            'telepon'  => 'required|numeric',

            'tanggal_pemesanan' => 'required|date',
            'deadline'          => 'nullable|date',
            'payment_status'    => 'required|in:belum_bayar,dp,lunas',
            'tipe_order'        => 'required|in:custom,lembaran',

            'antar_barang'      => 'required|in:0,1',
            'biaya_pengiriman'  => 'nullable|numeric|min:0',
            'jasa_pemasangan'   => 'required|in:0,1',
            'biaya_pemasangan'  => 'nullable|numeric|min:0',
            'jasa_desain'       => 'nullable|in:0,1',

            'merk.*'       => 'nullable|string',
            'ketebalan.*'  => 'nullable|string',
            'warna.*'      => 'nullable|string',
            'panjang_cm.*' => 'nullable|numeric|min:0',
            'lebar_cm.*'   => 'nullable|numeric|min:0',
            'qty.*'        => 'nullable|integer|min:1',
            'harga.*'      => 'nullable|numeric|min:0',

            'file_desain'  => 'nullable|file|max:51200',
        ]);

        DB::transaction(function () use ($validated, $request) {

            /* ================= CUSTOMER ================= */
            $customer = Customer::create([
                'nama'    => $validated['nama'],
                'alamat'  => $validated['alamat'],
                'telepon' => $validated['telepon'],
            ]);

            /* ================= STATUS AWAL ================= */
            // Status ditentukan berdasarkan jasa desain
            if ($validated['tipe_order'] === 'custom' && ($validated['jasa_desain'] ?? '0') == '1') {
                // Custom dengan jasa desain → langsung ke desain
                $status = 'desain';
            } else {
                // Custom tanpa jasa desain, atau tipe lembaran → langsung ke produksi
                $status = 'produksi';
            }

            /* ================= ORDER ================= */
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

            /* ================= ITEMS ================= */
            $totalItem = 0;

            foreach ($validated['merk'] ?? [] as $i => $merk) {

                if (
                    empty($validated['panjang_cm'][$i]) ||
                    empty($validated['lebar_cm'][$i]) ||
                    empty($validated['qty'][$i]) ||
                    empty($validated['harga'][$i])
                ) {
                    continue;
                }

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

            /* ================= TOTAL ================= */
            $order->update([
                'total_harga' =>
                    $totalItem +
                    $order->biaya_pengiriman +
                    $order->biaya_pemasangan
            ]);

            /* ================= DESIGN (CUSTOM DENGAN JASA DESAIN) ================= */
            if (
                $validated['tipe_order'] === 'custom' &&
                ($validated['jasa_desain'] ?? '0') == '1'
            ) {
                // Buat Design record
                $filePath = null;
                if ($request->hasFile('file_desain')) {
                    $filePath = $request->file('file_desain')
                        ->store('desain/order', 'public');
                }

                Design::create([
                    'order_id'  => $order->id,
                    'status'    => 'menunggu',
                    'file_awal' => $filePath,
                ]);
            }

            /* ================= PRODUCTION (CUSTOM TANPA JASA DESAIN) ================= */
            if (
                $validated['tipe_order'] === 'custom' &&
                ($validated['jasa_desain'] ?? '0') == '0'
            ) {
                // Langsung buat Production record
                Production::create([
                    'order_id' => $order->id,
                    'status'   => 'menunggu',
                ]);
            }

            /* ================= PRODUCTION ================= */
            // Semua order harus melewati produksi (kecuali yang pakai desain, itu nanti otomatis)
            if ($validated['tipe_order'] === 'custom' && ($validated['jasa_desain'] ?? '0') == '0') {
                // Custom tanpa jasa desain → langsung buat Production
                Production::create([
                    'order_id' => $order->id,
                    'status'   => 'menunggu',
                ]);
            } else if ($validated['tipe_order'] === 'lembaran') {
                // Tipe lembaran → langsung buat Production
                Production::create([
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
     * SHOW
     * ===================== */
    public function show(Order $order)
    {
        $order->load([
            'customer',
            'items',
            'design',
            'production',
            'deliveryNote',
            'pickup'
        ]);

        return view('orders.show', compact('order'));
    }

    /* =====================
     * UPDATE
     * ===================== */
    public function update(Request $request, Order $order)
    {
        // Prevent update jika sudah masuk tahap pickup atau delivery
        if (in_array($order->status, ['pickup', 'delivery', 'selesai'])) {
            return back()->with('error', 'Order tidak dapat diubah pada tahap ' . ucfirst($order->status) . '.');
        }

        $validated = $request->validate([
            'alamat'            => 'sometimes|required|string',
            'payment_status'    => 'sometimes|required|in:belum_bayar,dp,lunas',
            'deadline'          => 'nullable|date',
            'catatan'           => 'nullable|string',
            'jasa_desain'       => 'required|in:0,1',
            'file_desain'       => 'nullable|file|max:51200',
            'tipe_order'        => 'required|in:custom,lembaran',
            'antar_barang'      => 'required|in:0,1',
            'biaya_pengiriman'  => 'nullable|numeric|min:0',
            'biaya_pemasangan'  => 'nullable|numeric|min:0',

            'merk.*'            => 'nullable|string',
            'ketebalan.*'       => 'nullable|string',
            'warna.*'           => 'nullable|string',
            'panjang_cm.*'      => 'nullable|numeric|min:0',
            'lebar_cm.*'        => 'nullable|numeric|min:0',
            'qty.*'             => 'nullable|integer|min:1',
            'harga.*'           => 'nullable|numeric|min:0',
        ]);


        DB::transaction(function () use ($validated, $request, $order) {

            /* ================= UPDATE CUSTOMER ================= */
            if (isset($validated['alamat'])) {
                $order->customer->update([
                    'alamat' => $validated['alamat'],
                ]);
            }

            /* ================= UPDATE ORDER ================= */
            $order->update([
                'payment_status'   => $validated['payment_status'],
                'deadline'         => $validated['deadline'],
                'catatan'          => $validated['catatan'] ?? null,
                'tipe_order'       => $validated['tipe_order'],
                'antar_barang'     => $validated['antar_barang'],
                'biaya_pengiriman' => $validated['biaya_pengiriman'] ?? 0,
                'biaya_pemasangan' => $validated['biaya_pemasangan'] ?? 0,
            ]);

            /* ================= UPDATE ITEMS ================= */
            $order->items()->delete();

            $totalItem = 0;

            foreach ($validated['merk'] ?? [] as $i => $merk) {

                if (
                    empty($validated['panjang_cm'][$i]) ||
                    empty($validated['lebar_cm'][$i]) ||
                    empty($validated['qty'][$i]) ||
                    empty($validated['harga'][$i])
                ) {
                    continue;
                }

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

            /* ================= UPDATE TOTAL ================= */
            $order->update([
                'total_harga' =>
                    $totalItem +
                    ($validated['biaya_pengiriman'] ?? 0) +
                    ($validated['biaya_pemasangan'] ?? 0)
            ]);

           /* ================= FLOW STATUS ONLY UPDATE IF AT DESIGN STAGE ================= */
            // Hanya update flow status ketika masih di tahap desain
            // Jika sudah di tahap produksi atau lebih lanjut, jangan ubah statusnya lagi
            if ($order->status === 'desain') {

                if ($validated['tipe_order'] === 'custom') {

                    if ($validated['jasa_desain'] == 1) {

                        // Tetap di tahap DESAIN
                        $order->update([
                            'status' => 'desain'
                        ]);

                        // 🔥 TAMBAHAN (sinkron data)
                        $order->design()->firstOrCreate([
                            'order_id' => $order->id
                        ]);

                        $order->production()->delete();

                        // Pastikan tidak ada delivery / pickup
                        $order->deliveryNote()->delete();
                        $order->pickup()->delete();

                    } else {

                        // Kalau tidak pakai jasa desain → langsung PRODUKSI
                        $order->update([
                            'status' => 'produksi'
                        ]);

                        // 🔥 TAMBAHAN (sinkron data)
                        $order->design()->delete();

                        $order->production()->firstOrCreate([
                            'order_id' => $order->id
                        ]);

                        // Hapus delivery & pickup juga
                        $order->deliveryNote()->delete();
                        $order->pickup()->delete();
                    }
                }

                /* ================= LEMBARAN ================= */
                if ($validated['tipe_order'] === 'lembaran') {

                    $order->design()->delete();

                    // Tipe lembaran harus masuk produksi
                    $order->update([
                        'status' => 'produksi'
                    ]);

                    // 🔥 Buat Production jika belum ada
                    $order->production()->firstOrCreate([
                        'order_id' => $order->id
                    ]);

                    // Hapus delivery & pickup (akan dibuat otomatis saat production selesai)
                    $order->deliveryNote()->delete();
                    $order->pickup()->delete();
                }
            }
            // Jika sudah di tahap produksi/selanjutnya, jangan ubah status, cukup update data items saja

            /* ================= UPDATE FILE DESAIN ================= */
            if ($request->hasFile('file_desain')) {

                $path = $request->file('file_desain')
                    ->store('desain/order', 'public');

                $order->design()->updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'status'    => 'menunggu',
                        'file_awal' => $path
                    ]
                );
            }
        });

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
     * INVOICE VIEW
     * ===================== */
    public function invoice(Order $order)
    {
        $order->load(['customer', 'items']);
        return view('orders.invoice', compact('order'));
    }

    /* =====================
     * DOWNLOAD INVOICE
     * ===================== */
    public function downloadInvoice(Order $order)
    {
        $order->load(['customer', 'items']);

        $pdf = Pdf::loadView('orders.invoice-pdf', compact('order'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('Invoice-' . $order->invoice_number . '.pdf');
    }
}
