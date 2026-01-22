<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory;

class InventoryHistory extends Model
{
    protected $fillable = [
        'inventory_id',
        'tipe',
        'jumlah',
        'tanggal',
        'keterangan'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}

