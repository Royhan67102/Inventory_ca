<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Production;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'designer',
        'status',
        'catatan',
        'file_awal',
        'file_hasil',

        // tambahan aman (opsional dipakai sekarang / nanti)
        'deadline',
        'bukti_pengerjaan',
        'tanggal_selesai',
    ];

    protected $casts = [
        'deadline'   => 'datetime',
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

                $order = $design->order;

                if (!$order) {
                    return;
                }

                // ⬇️ WAJIB PINDAH KE PRODUKSI TERLEBIH DAHULU
                $order->updateQuietly([
                    'status' => 'produksi'
                ]);

                // Buat Production record jika belum ada
                Production::firstOrCreate(
                    ['order_id' => $order->id],
                    ['status' => 'menunggu']
                );
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
