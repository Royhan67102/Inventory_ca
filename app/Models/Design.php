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
    ];

    /* ================= RELATION ================= */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /* ================= AUTO ================= */

    protected static function booted()
    {
        static::creating(function ($design) {
            $design->status ??= 'menunggu';
        });

        static::saved(function ($design) {
            $design->order?->refreshTotal();
        });

        static::deleted(function ($design) {
            $design->order?->refreshTotal();
        });
    }
}

