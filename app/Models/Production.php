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
        'status_lock',
        'stok_dipotong',
        'bukti',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'datetime',
        'tanggal_selesai' => 'datetime',
        'perlu_pengiriman'=> 'boolean',
        'status_lock'     => 'boolean',
        'stok_dipotong'   => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    protected static function booted()
    {
        static::creating(function ($production) {
            $production->status ??= 'menunggu';
            $production->status_lock ??= false;
            $production->stok_dipotong ??= false;
        });
    }
}
