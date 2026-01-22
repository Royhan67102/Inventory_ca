<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcrylicStock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'merk',
        'warna',
        'jenis',
        'panjang',
        'lebar',
        'ketebalan',
        'luas_total',
        'luas_tersedia',
        'jumlah_lembar',
    ];

    protected $casts = [
        'panjang'       => 'float',
        'lebar'         => 'float',
        'ketebalan'     => 'float',
        'luas_total'    => 'float',
        'luas_tersedia' => 'float',
        'jumlah_lembar' => 'integer',
    ];

    public function wastes()
    {
        return $this->hasMany(AcrylicWaste::class);
    }

    public function getLuasPerLembarAttribute(): float
    {
        return ($this->panjang ?? 0) * ($this->lebar ?? 0);
    }

    public function cukupUntuk(float $luas): bool
    {
        return $this->luas_tersedia >= $luas;
    }

    public function gunakanUntuk(OrderItem $item)
    {
        $luasDipakai = $item->luas;

        if (!$this->cukupUntuk($luasDipakai)) {
            throw new \Exception('Stok acrylic tidak mencukupi');
        }

        $this->luas_tersedia -= $luasDipakai;

        if ($this->luas_tersedia <= 0) {
            $this->jumlah_lembar -= 1;
            $this->luas_tersedia = $this->luas_per_lembar * $this->jumlah_lembar;
        }

        $this->jenis = $this->jumlah_lembar <= 0 ? 'habis' : 'tersedia';
        $this->save();

        AcrylicWaste::create([
            'acrylic_stock_id' => $this->id,
            'order_item_id'    => $item->id,
            'luas_sisa'        => max(0, $this->luas_per_lembar - $luasDipakai),
            'terpakai'         => false,
        ]);
    }

    protected static function booted()
    {
        static::creating(function ($stock) {
            $stock->luas_total = $stock->luas_per_lembar * $stock->jumlah_lembar;
            $stock->luas_tersedia = $stock->luas_total;
            $stock->jenis ??= 'tersedia';
        });
    }
}
