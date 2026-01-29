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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
