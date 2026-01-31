<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    protected $fillable = [
        'order_id',
        'nama_pengirim',
        'driver',
        'tanggal_kirim',
        'jam_berangkat',
        'jam_sampai_tujuan',
        'jam_kembali',
        'ttd_admin',
        'ttd_penerima',
        'bukti_foto',
        'status',
        'status_lock',
    ];


    protected $casts = [
        'tanggal_kirim' => 'date',
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

    public function selesaikanPengiriman(string $ttdPenerima)
    {
        $this->update([
            'ttd_penerima' => $ttdPenerima,
            'status'       => 'selesai',
        ]);

        // tandai order sebagai selesai (masuk history)
        $this->order?->updateQuietly([
            'status'   => 'selesai',
            'catatan' => 'Pengiriman selesai',
        ]);
    }

    /* ================= AUTO ================= */

    protected static function booted()
    {
        static::creating(function ($delivery) {

            // default status
            $delivery->status ??= 'menunggu';

            // auto tanggal kirim
            $delivery->tanggal_kirim ??= now();

            // sync status ke order
            if ($delivery->order) {
                $delivery->order->updateQuietly([
                    'status' => 'delivery'
                ]);
            }
        });

        static::updating(function ($delivery) {

            // ketika status berubah jadi dikirim
            if ($delivery->isDirty('status') && $delivery->status === 'dikirim') {
                $delivery->tanggal_kirim ??= now();
            }
        });
    }
}
