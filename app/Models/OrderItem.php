<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',

        // info produk (sesuai create)
        'merk',
        'ketebalan',
        'warna',

        // ukuran
        'panjang_cm',
        'lebar_cm',
        'luas_cm2',

        // transaksi
        'qty',
        'harga',
        'subtotal',
    ];

    protected $casts = [
        'qty'        => 'integer',
        'panjang_cm' => 'float',
        'lebar_cm'   => 'float',
        'luas_cm2'   => 'float',
        'harga'      => 'float',
        'subtotal'   => 'float',
    ];

    /* ================= RELATION ================= */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /* ================= AUTO HITUNG ================= */

    protected static function booted()
    {
        static::saving(function ($item) {

            $qty     = max(1, (int) ($item->qty ?? 1));
            $panjang = (float) ($item->panjang_cm ?? 0);
            $lebar   = (float) ($item->lebar_cm ?? 0);
            $harga   = (float) ($item->harga ?? 0);

            // luas cm2
            $item->luas_cm2 = $panjang * $lebar;

            // subtotal = harga × qty
            $item->qty      = $qty;
            $item->subtotal = $harga * $qty;
        });

        static::saved(function ($item) {
            $item->order?->refreshTotal();
        });

        static::deleted(function ($item) {
            $item->order?->refreshTotal();
        });
    }
}
