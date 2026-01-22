<?php

namespace App\Services;

use App\Models\AcrylicStock;
use App\Models\AcrylicWaste;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Exception;

class AcrylicStockService
{
    /**
     * ======================================
     * POTONG STOK UNTUK 1 ORDER ITEM
     * ======================================
     */
    public static function useForOrderItem(OrderItem $item): void
    {
        DB::transaction(function () use ($item) {

            $kebutuhan = $item->luas_cm2;

            // Ambil stok sesuai item
            $stock = AcrylicStock::where('merk', $item->merk)
                ->where('warna', $item->warna)
                ->where('ketebalan', $item->ketebalan)
                ->lockForUpdate()
                ->first();

            if (!$stock) {
                throw new Exception('Stok akrilik tidak ditemukan');
            }

            /**
             * =====================
             * 1️⃣ PAKAI WASTE DULU
             * =====================
             */
            $wastes = AcrylicWaste::where('acrylic_stock_id', $stock->id)
                ->where('terpakai', false)
                ->orderBy('luas_sisa', 'asc')
                ->lockForUpdate()
                ->get();

            foreach ($wastes as $waste) {
                if ($kebutuhan <= 0) break;

                $pakai = min($waste->luas_sisa, $kebutuhan);

                $waste->update([
                    'luas_sisa' => $waste->luas_sisa - $pakai,
                    'terpakai'  => ($waste->luas_sisa - $pakai) <= 0,
                    'order_item_id' => $item->id,
                ]);

                $kebutuhan -= $pakai;
            }

            /**
             * =====================
             * 2️⃣ PAKAI LEMBAR BARU
             * =====================
             */
            while ($kebutuhan > 0) {

                if ($stock->jumlah_lembar <= 0) {
                    throw new Exception('Stok lembar akrilik habis');
                }

                $luasLembar = $stock->panjang * $stock->lebar;
                $pakai = min($luasLembar, $kebutuhan);
                $sisaLembar = $luasLembar - $pakai;

                // simpan sisa lembar sebagai waste
                if ($sisaLembar > 0) {
                    AcrylicWaste::create([
                        'acrylic_stock_id' => $stock->id,
                        'order_item_id' => $item->id,
                        'luas_sisa' => $sisaLembar,
                        'terpakai' => false,
                    ]);
                }

                $stock->decrement('jumlah_lembar', 1);
                $stock->decrement('luas_tersedia', $pakai);

                $kebutuhan -= $pakai;
            }
        });
    }
}
