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
        'perlu_pengiriman',
        'bukti',
    ];

    protected $casts = [
        'tanggal_mulai'    => 'datetime',
        'tanggal_selesai'  => 'datetime',
        'perlu_pengiriman' => 'boolean',
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
        static::creating(function ($production) {

            $production->status ??= 'menunggu';
            $production->status_lock ??= false;
            $production->stok_dipotong ??= false;

            // sync ke order
            if ($production->order) {
                $production->order->updateQuietly([
                    'status' => 'produksi'
                ]);
            }
        });

        static::updating(function ($production) {

            // set tanggal mulai otomatis
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

                // ⬇️ tentukan lanjut ke mana
                if ($production->perlu_pengiriman) {

                    $order->updateQuietly([
                        'status' => 'delivery'
                    ]);

                    // auto buat delivery jika belum ada
                    $order->deliveryNote()->firstOrCreate([
                        'order_id' => $order->id
                    ]);

                } else {

                    $order->updateQuietly([
                        'status' => 'pickup'
                    ]);

                    // auto buat pickup jika belum ada
                    $order->pickup()->firstOrCreate([
                        'order_id' => $order->id
                    ]);
                }
            }
        });
    }
}
