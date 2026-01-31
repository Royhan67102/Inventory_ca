<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'bukti',
        'catatan',
    ];

    /* ================= RELATION ================= */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /* ================= HELPER ================= */

    public function isSelesai(): bool
    {
        return $this->status === 'selesai';
    }

    /* ================= BUSINESS ================= */

    public function tandaiSudahDiambil(?string $bukti = null)
    {
        $this->update([
            'status' => 'selesai',
            'bukti'  => $bukti,
        ]);

        // order masuk history penjualan
        $this->order?->updateQuietly([
            'status'   => 'selesai',
            'catatan' => 'Barang sudah diambil customer',
        ]);
    }

    /* ================= AUTO ================= */

    protected static function booted()
    {
        static::creating(function ($pickup) {

            // default status pickup
            $pickup->status ??= 'menunggu';

            // sinkron ke order
            if ($pickup->order) {
                $pickup->order->updateQuietly([
                    'status' => 'pickup'
                ]);
            }
        });
    }
}
