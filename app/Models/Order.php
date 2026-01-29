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
        'jasa_pemasangan',
        'biaya_pemasangan',

        // status internal
        'status', // desain | produksi | delivery | pickup | selesai
        'catatan',
    ];

    protected $casts = [
        'tanggal_pemesanan' => 'date',
        'deadline'          => 'date',

        'antar_barang'      => 'boolean',
        'jasa_pemasangan'   => 'boolean',

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

    public function design()
    {
        return $this->hasOne(Design::class);
    }

    public function production()
    {
        return $this->hasOne(Production::class);
    }

    public function deliveryNote()
    {
        return $this->hasOne(DeliveryNote::class);
    }

    public function pickup()
    {
        return $this->hasOne(Pickup::class);
    }

    /* ================= BUSINESS ================= */

    public function totalItem(): float
    {
        return (float) $this->items()->sum('subtotal');
    }

    public function totalJasa(): float
    {
        return
            (float) ($this->biaya_pengiriman ?? 0) +
            (float) ($this->biaya_pemasangan ?? 0) +
            (float) ($this->design?->biaya_desain ?? 0);
    }

    public function hitungTotal(): float
    {
        return $this->totalItem() + $this->totalJasa();
    }

    public function refreshTotal(): void
    {
        $this->updateQuietly([
            'total_harga' => $this->hitungTotal(),
        ]);
    }

    /* ================= AUTO DEFAULT ================= */

    protected static function booted()
    {
        static::creating(function ($order) {

            $order->invoice_number ??= 'INV-' . now()->format('YmdHis');

            // ⬇️ DEFAULT STATUS ORDER
            $order->status ??= 'desain';

            // default jasa
            $order->antar_barang     ??= false;
            $order->jasa_pemasangan  ??= false;
            $order->biaya_pengiriman ??= 0;
            $order->biaya_pemasangan ??= 0;
            $order->total_harga      ??= 0;
        });
    }
}
