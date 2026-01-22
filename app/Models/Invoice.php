<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'order_id',
        'invoice_number',
        'tanggal_invoice',
        'status_pembayaran',
        'total_harga',
        'dp',
        'sisa_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'tanggal_invoice' => 'date',
        'total_harga'     => 'float',
        'dp'              => 'float',
        'sisa_pembayaran' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function hitungSisa(): void
    {
        $this->sisa_pembayaran = max(0, $this->total_harga - ($this->dp ?? 0));
    }

    protected static function booted()
    {
        static::creating(function ($invoice) {
            $invoice->tanggal_invoice ??= now();
            $invoice->dp ??= 0;
            $invoice->status_pembayaran ??= 'belum_bayar';
            $invoice->hitungSisa();
        });

        static::updating(function ($invoice) {
            $invoice->hitungSisa();
        });
    }
}
