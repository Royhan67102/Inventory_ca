<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_name',
        'tipe_item', // lembaran | custom
        'qty',

        // custom
        'panjang_cm',
        'lebar_cm',
        'luas_cm2',
        'harga_per_cm',

        // lembaran
        'harga_satuan',

        'subtotal',
    ];

    protected $casts = [
        'qty'            => 'integer',
        'panjang_cm'     => 'float',
        'lebar_cm'       => 'float',
        'luas_cm2'       => 'float',
        'harga_per_cm'   => 'float',
        'harga_satuan'   => 'float',
        'subtotal'       => 'float',
    ];

    /* ================= RELATION ================= */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /* ================= ACCESSOR ================= */

    public function getLuasAttribute(): float
    {
        return $this->luas_cm2 ?? 0;
    }

    /* ================= AUTO HITUNG ================= */

    protected static function booted()
    {
        static::saving(function ($item) {

            // ITEM CUSTOM
            if ($item->tipe_item === 'custom') {
                $item->luas_cm2 = ($item->panjang_cm ?? 0) * ($item->lebar_cm ?? 0);
                $item->subtotal = $item->luas_cm2 * $item->harga_per_cm * $item->qty;
            }

            // ITEM LEMBARAN
            if ($item->tipe_item === 'lembaran') {
                $item->panjang_cm = null;
                $item->lebar_cm = null;
                $item->luas_cm2 = null;
                $item->harga_per_cm = null;
                $item->subtotal = $item->harga_satuan * $item->qty;
            }
        });

        static::saved(function ($item) {
            $item->order?->refreshTotal();
        });

        static::deleted(function ($item) {
            $item->order?->refreshTotal();
        });
    }
}
