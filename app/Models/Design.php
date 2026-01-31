<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'designer',
        'status',
        'catatan',
        'file_desain',
        'file_hasil',

        // tambahan aman (opsional dipakai sekarang / nanti)
        'tanggal_mulai',
        'tanggal_selesai',
        'bukti_pengerjaan',
        'biaya_desain',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'datetime',
        'tanggal_selesai' => 'datetime',
        'biaya_desain'    => 'float',
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
        static::creating(function ($design) {

            // default status desain
            $design->status ??= 'menunggu';

            // set order ke desain (aman, tidak overwrite)
            if ($design->order && $design->order->status === 'order') {
                $design->order->updateQuietly([
                    'status' => 'desain'
                ]);
            }
        });

        static::updating(function ($design) {

            // ketika desain dinyatakan selesai
            if ($design->isDirty('status') && $design->status === 'selesai') {

                $design->tanggal_selesai ??= now();

                // ⬇️ otomatis lanjut ke produksi
                $design->order?->updateQuietly([
                    'status' => 'produksi'
                ]);
            }
        });

        static::saved(function ($design) {
            // hitung ulang total (sudah benar punyamu 👍)
            $design->order?->refreshTotal();
        });

        static::deleted(function ($design) {
            $design->order?->refreshTotal();
        });
    }
}
