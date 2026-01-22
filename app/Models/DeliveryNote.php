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
        'ttd_admin',
        'ttd_penerima',
        'status',
    ];

    protected $casts = [
        'tanggal_kirim' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function selesaikanPengiriman(string $ttdPenerima)
    {
        $this->update([
            'ttd_penerima' => $ttdPenerima,
            'status' => 'selesai',
        ]);

        $this->order?->update([
            'catatan' => 'Pengiriman selesai',
        ]);
    }
}
