<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'tanggal_pemesanan',
        'deadline',

        // pembayaran
        'payment_status', // belum_bayar | dp | lunas
        'total_harga',

        // jasa tambahan
        'antar_barang',
        'biaya_pengiriman',
        'pasang_barang',
        'biaya_pemasangan',

        // status internal
        'status_produksi', // menunggu | proses | selesai
        'catatan',
    ];

    protected $casts = [
        'tanggal_pemesanan' => 'date',
        'deadline'          => 'date',
        'antar_barang'      => 'boolean',
        'pasang_barang'     => 'boolean',
        'total_harga'       => 'float',
        'biaya_pengiriman'  => 'float',
        'biaya_pemasangan'  => 'float',
    ];

    /* ================= RELATION ================= */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function production()
    {
        return $this->hasOne(Production::class);
    }

    public function deliveryNote()
    {
        return $this->hasOne(DeliveryNote::class);
    }

    /* ================= BUSINESS ================= */

    public function totalItem(): float
    {
        return $this->items()->sum('subtotal');
    }

    public function totalJasa(): float
    {
        return
            ($this->biaya_pengiriman ?? 0) +
            ($this->biaya_pemasangan ?? 0);
    }

    public function hitungTotal(): float
    {
        return $this->totalItem() + $this->totalJasa();
    }

    public function refreshTotal(): void
    {
        $this->update([
            'total_harga' => $this->hitungTotal(),
        ]);
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->invoice_number ??= 'INV-' . now()->format('YmdHis');
            $order->status_produksi ??= 'menunggu';
        });
    }
}
