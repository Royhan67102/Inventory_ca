<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcrylicWaste extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'acrylic_stock_id',
        'order_item_id',
        'luas_sisa',
        'terpakai',
    ];

    protected $casts = [
        'luas_sisa' => 'float',
        'terpakai'  => 'boolean',
    ];

    public function stock()
    {
        return $this->belongsTo(AcrylicStock::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('terpakai', false)->where('luas_sisa', '>', 0);
    }

    public function gunakan(float $luasDipakai)
    {
        if ($this->luas_sisa < $luasDipakai) {
            throw new \Exception('Luas sisa acrylic tidak mencukupi');
        }

        $this->luas_sisa -= $luasDipakai;

        if ($this->luas_sisa <= 0) {
            $this->luas_sisa = 0;
            $this->terpakai = true;
        }

        $this->save();
    }
}
