<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::latest()->get();
        return view('inventories.index', compact('inventories'));
    }

    public function create()
    {
        return view('inventories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'jenis_barang' => 'required|string',
            'jumlah' => 'nullable|integer|min:0',
            'pic_barang' => 'nullable|string',
            'kondisi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {

            $inventory = Inventory::create([
                'nama_barang' => $request->nama_barang,
                'jenis_barang' => $request->jenis_barang,
                'pic_barang' => $request->pic_barang,
                'kondisi' => $request->kondisi,
                'deskripsi' => $request->deskripsi,
                'jumlah' => 0
            ]);

            if ($request->jumlah > 0) {
                $inventory->increment('jumlah', $request->jumlah);

                InventoryHistory::create([
                    'inventory_id' => $inventory->id,
                    'tipe' => 'masuk',
                    'jumlah' => $request->jumlah,
                    'tanggal' => now(),
                    'keterangan' => 'Stok awal'
                ]);
            }
        });

        return redirect()->route('inventories.index')
            ->with('success', 'Inventory berhasil ditambahkan');
    }

    public function show($id)
    {
        $inventory = Inventory::with('histories')->findOrFail($id);
        return view('inventories.show', compact('inventory'));
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('inventories.edit', compact('inventory'));
    }

    /**
     * Update DATA MASTER (bukan stok)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'jenis_barang' => 'required|string',
            'pic_barang' => 'nullable|string',
            'kondisi' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->only([
            'nama_barang',
            'jenis_barang',
            'pic_barang',
            'kondisi',
            'deskripsi'
        ]));

        return redirect()->route('inventories.index')
            ->with('success', 'Data inventory berhasil diperbarui');
    }

    /**
     * UPDATE STOK (MASUK / KELUAR)
     */
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $inventory = Inventory::findOrFail($id);

        DB::transaction(function () use ($request, $inventory) {

            if ($request->tipe === 'keluar' && $inventory->jumlah < $request->jumlah) {
                abort(400, 'Stok tidak mencukupi');
            }

            if ($request->tipe === 'masuk') {
                $inventory->increment('jumlah', $request->jumlah);
            } else {
                $inventory->decrement('jumlah', $request->jumlah);
            }

            InventoryHistory::create([
                'inventory_id' => $inventory->id,
                'tipe' => $request->tipe,
                'jumlah' => $request->jumlah,
                'tanggal' => now(),
                'keterangan' => $request->keterangan
            ]);
        });

        return back()->with('success', 'Stok berhasil diperbarui');
    }

    public function destroy($id)
    {
        $inventory = Inventory::withCount('histories')->findOrFail($id);

        if ($inventory->histories_count > 0) {
            return back()->with('error', 'Data tidak bisa dihapus karena memiliki histori.');
        }

        $inventory->delete();

        return redirect()->route('inventories.index')
            ->with('success', 'Inventory berhasil dihapus');
    }
}
