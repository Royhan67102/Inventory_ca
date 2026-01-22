<?php

namespace App\Http\Controllers;

use App\Models\AcrylicStock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AcrylicStockController extends Controller
{
    /* =====================
     * LIST STOCK
     * ===================== */
    public function index()
    {
        $stocks = AcrylicStock::orderBy('merk')
            ->orderBy('warna')
            ->orderBy('ketebalan')
            ->get();

        return view('acrylicstocks.index', compact('stocks'));
    }

    /* =====================
     * FORM CREATE
     * ===================== */
    public function create()
    {
        return view('acrylicstocks.create');
    }

    /* =====================
     * STORE
     * ===================== */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'merk'          => 'required|string|max:255',
            'warna'         => 'nullable|string|max:255',
            'jenis'         => 'required|in:lembar,sisa',

            'panjang'       => 'required|numeric|min:0.01',
            'lebar'         => 'required|numeric|min:0.01',
            'ketebalan'     => 'required|numeric|min:0.1',

            'jumlah_lembar' => 'nullable|integer|min:1',
            'harga_lembar'  => 'nullable|numeric|min:0',
        ]);

        /* =====================
         * HITUNG LUAS
         * ===================== */
        $luasPerLembar = $validated['panjang'] * $validated['lebar'];

        if ($validated['jenis'] === 'lembar') {
            $jumlah = $validated['jumlah_lembar'] ?? 1;
            $luasTotal = $luasPerLembar * $jumlah;
        } else {
            // sisa / limbah
            $jumlah = 1;
            $luasTotal = $luasPerLembar;
        }

        /* =====================
         * KODE STOK OTOMATIS
         * ===================== */
        $kodeStok = strtoupper(
            'ACR-' .
            Str::slug($validated['merk']) . '-' .
            ($validated['ketebalan'] . 'MM') . '-' .
            now()->format('His')
        );

        AcrylicStock::create([
            'kode_stok'       => $kodeStok,

            'merk'            => $validated['merk'],
            'warna'           => $validated['warna'],
            'jenis'           => $validated['jenis'],

            'panjang'         => $validated['panjang'],
            'lebar'           => $validated['lebar'],
            'ketebalan'       => $validated['ketebalan'],

            'luas_total'      => $luasTotal,
            'luas_tersedia'   => $luasTotal,

            'jumlah_lembar'   => $validated['jenis'] === 'lembar'
                                  ? ($validated['jumlah_lembar'] ?? 1)
                                  : 1,

            'harga_lembar'    => $validated['jenis'] === 'lembar'
                                  ? ($validated['harga_lembar'] ?? 0)
                                  : null,
        ]);

        return redirect()
            ->route('acrylic-stocks.index')
            ->with('success', 'Stok akrilik berhasil ditambahkan');
    }

    /* =====================
     * SHOW
     * ===================== */
    public function show(AcrylicStock $acrylic_stock)
    {
        return view('acrylicstocks.show', compact('acrylic_stock'));
    }

    /* =====================
     * EDIT
     * ===================== */
    public function edit(AcrylicStock $acrylic_stock)
    {
        return view('acrylicstocks.edit', compact('acrylic_stock'));
    }

    /* =====================
     * UPDATE
     * ===================== */
    public function update(Request $request, AcrylicStock $acrylic_stock)
    {
        $validated = $request->validate([
            'merk'          => 'required|string|max:255',
            'warna'         => 'nullable|string|max:255',
            'jenis'         => 'required|in:lembar,sisa',

            'panjang'       => 'required|numeric|min:0.01',
            'lebar'         => 'required|numeric|min:0.01',
            'ketebalan'     => 'required|numeric|min:0.1',

            'jumlah_lembar' => 'nullable|integer|min:1',
            'harga_lembar'  => 'nullable|numeric|min:0',
        ]);

        $luasPerLembar = $validated['panjang'] * $validated['lebar'];

        if ($validated['jenis'] === 'lembar') {
            $jumlah = $validated['jumlah_lembar'] ?? 1;
            $luasTotal = $luasPerLembar * $jumlah;
        } else {
            $jumlah = 1;
            $luasTotal = $luasPerLembar;
        }

        // jangan sampai luas tersisa melebihi total
        $luasTersedia = min($acrylic_stock->luas_tersedia, $luasTotal);

        $acrylic_stock->update([
            'merk'            => $validated['merk'],
            'warna'           => $validated['warna'],
            'jenis'           => $validated['jenis'],

            'panjang'         => $validated['panjang'],
            'lebar'           => $validated['lebar'],
            'ketebalan'       => $validated['ketebalan'],

            'luas_total'      => $luasTotal,
            'luas_tersedia'   => $luasTersedia,
            'jumlah_lembar'   => $jumlah,
            'harga_lembar'    => $validated['jenis'] === 'lembar'
                                  ? ($validated['harga_lembar'] ?? 0)
                                  : null,
        ]);

        return redirect()
            ->route('acrylic-stocks.index')
            ->with('success', 'Stok akrilik berhasil diperbarui');
    }

    /* =====================
     * DELETE (SOFT)
     * ===================== */
    public function destroy(AcrylicStock $acrylic_stock)
    {
        $acrylic_stock->delete();

        return redirect()
            ->route('acrylic-stocks.index')
            ->with('success', 'Stok akrilik dihapus');
    }
}
