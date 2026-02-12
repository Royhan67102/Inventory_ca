<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $fillable = [
        'order_id',
        'tim_produksi',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'catatan',
        'bukti',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'datetime',
        'tanggal_selesai' => 'datetime',
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

    /* ================= AUTO ================= */

    protected static function booted()
    {
        /* =====================
         * SAAT PRODUCTION DIBUAT
         * ===================== */
        static::creating(function ($production) {

            $production->status ??= 'menunggu';

            if ($production->order) {
                $production->order->updateQuietly([
                    'status' => 'produksi'
                ]);
            }
        });

        /* =====================
         * SAAT PRODUCTION DIUPDATE
         * ===================== */
        static::updating(function ($production) {

            // otomatis isi tanggal mulai
            if ($production->isDirty('status') && $production->status === 'proses') {
                $production->tanggal_mulai ??= now();
            }

            // ketika produksi selesai
            if ($production->isDirty('status') && $production->status === 'selesai') {

                $production->tanggal_selesai ??= now();

                $order = $production->order;

                if (!$order) {
                    return;
                }

                /* =====================
                 * CEK DARI ORDER
                 * ===================== */

                if ($order->antar_barang) {

                    // lanjut ke delivery
                    $order->updateQuietly([
                        'status' => 'delivery'
                    ]);

                    $order->deliveryNote()->firstOrCreate([
                        'order_id' => $order->id
                    ]);

                } else {

                    // lanjut ke pickup
                    $order->updateQuietly([
                        'status' => 'pickup'
                    ]);

                    $order->pickup()->firstOrCreate([
                        'order_id' => $order->id
                    ]);
                }
            }
        });
    }
}
