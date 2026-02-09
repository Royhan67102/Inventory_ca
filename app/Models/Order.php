<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Design;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'tanggal_pemesanan',
        'deadline',
        'tipe_order',
        'payment_status',
        'status',

        'antar_barang',
        'biaya_pengiriman',

        'jasa_pemasangan',
        'biaya_pemasangan',

        'catatan',
        'total_harga',
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

    /* ================= FLOW HELPER ================= */

    // apakah order custom (butuh desain)
    public function isCustom(): bool
    {
        return $this->design()->exists();
    }


    // apakah order hanya lembaran
    public function isLembaran(): bool
    {
        return !$this->isCustom();
    }

    // cek apakah pakai delivery
    public function isDelivery(): bool
    {
        return $this->antar_barang === true;
    }

    // cek apakah pickup
    public function isPickup(): bool
    {
        return $this->antar_barang === false;
    }

    /* ================= AUTO DEFAULT ================= */

    protected static function booted()
    {
        static::creating(function ($order) {

            $order->invoice_number ??= 'INV-' . now()->format('YmdHis');

            // ⬇️ DEFAULT STATUS (sementara)
            $order->status ??= 'order';

            // default jasa
            $order->antar_barang     ??= false;
            $order->jasa_pemasangan  ??= false;
            $order->biaya_pengiriman ??= 0;
            $order->biaya_pemasangan ??= 0;
            $order->total_harga      ??= 0;
        });

        static::created(function ($order) {

            if ($order->isCustom()) {

                $order->updateQuietly(['status' => 'desain']);

                // otomatis buat desain
                Design::create([
                    'order_id' => $order->id,
                    'status' => 'menunggu',
                ]);

            } else {
                $order->updateQuietly(['status' => 'produksi']);
            }
        });
    }
}
