<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\InventoryHistory;

class Inventory extends Model
{
    protected $fillable = [
        'nama_barang',
        'jenis_barang',
        'pic_barang',
        'jumlah',
        'kondisi',
        'deskripsi'
    ];

    public function histories()
    {
        return $this->hasMany(InventoryHistory::class);
    }
}

