<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Design;
use App\Models\Production;
use App\Models\Pickup;
use App\Models\DeliveryNote;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    private function createCustomer()
    {
        return Customer::create([
            'nama'    => 'Test Customer',
            'alamat'  => 'Jl. Test',
            'telepon' => '081234567890',
        ]);
    }

    /** Test: Create custom order dengan jasa desain */
    public function test_create_custom_order_with_design()
    {
        // Create
        $customer = $this->createCustomer();
        $order = Order::create([
            'customer_id'       => $customer->id,
            'invoice_number'    => 'TEST-001',
            'tanggal_pemesanan' => now(),
            'payment_status'    => 'belum_bayar',
            'status'            => 'desain',
            'antar_barang'      => true,
            'total_harga'       => 0,
        ]);

        Design::create([
            'order_id' => $order->id,
            'status'   => 'menunggu',
        ]);

        // Assert
        $this->assertDatabaseHas('orders', ['id' => $order->id, 'status' => 'desain']);
        $this->assertTrue($order->design()->exists());
        $this->assertFalse($order->production()->exists());
        $this->assertFalse($order->pickup()->exists());
        $this->assertFalse($order->deliveryNote()->exists());
    }

    /** Test: Design selesai → auto create DeliveryNote (antar=1) */
    public function test_design_selesai_create_delivery_when_antar()
    {
        // Setup
        $customer = $this->createCustomer();
        $order = Order::create([
            'customer_id'       => $customer->id,
            'invoice_number'    => 'TEST-002',
            'tanggal_pemesanan' => now(),
            'payment_status'    => 'belum_bayar',
            'status'            => 'desain',
            'antar_barang'      => true,
            'total_harga'       => 0,
        ]);

        $design = Design::create([
            'order_id' => $order->id,
            'status'   => 'menunggu',
        ]);

        // Act: Update design status to selesai
        $design->update(['status' => 'selesai']);

        // Assert
        $order->refresh();
        $this->assertEquals('delivery', $order->status);
        $this->assertTrue($order->deliveryNote()->exists());
        $this->assertFalse($order->pickup()->exists());
    }

    /** Test: Design selesai → auto create Pickup (antar=0) */
    public function test_design_selesai_create_pickup_when_no_antar()
    {
        // Setup
        $customer = $this->createCustomer();
        $order = Order::create([
            'customer_id'       => $customer->id,
            'invoice_number'    => 'TEST-003',
            'tanggal_pemesanan' => now(),
            'payment_status'    => 'belum_bayar',
            'status'            => 'desain',
            'antar_barang'      => false,
            'total_harga'       => 0,
        ]);

        $design = Design::create([
            'order_id' => $order->id,
            'status'   => 'menunggu',
        ]);

        // Act: Update design status to selesai
        $design->update(['status' => 'selesai']);

        // Assert
        $order->refresh();
        $this->assertEquals('pickup', $order->status);
        $this->assertTrue($order->pickup()->exists());
        $this->assertFalse($order->deliveryNote()->exists());
    }

    /** Test: Pickup selesai → order selesai */
    public function test_pickup_selesai_order_selesai()
    {
        // Setup
        $customer = $this->createCustomer();
        $order = Order::create([
            'customer_id'       => $customer->id,
            'invoice_number'    => 'TEST-004',
            'tanggal_pemesanan' => now(),
            'payment_status'    => 'belum_bayar',
            'status'            => 'pickup',
            'antar_barang'      => false,
            'total_harga'       => 0,
        ]);

        $pickup = Pickup::create([
            'order_id' => $order->id,
            'status'   => 'menunggu',
        ]);

        // Act: Update pickup status to selesai
        $pickup->update(['status' => 'selesai']);

        // Assert
        $order->refresh();
        $this->assertEquals('selesai', $order->status);
    }

    /** Test: DeliveryNote selesai → order selesai */
    public function test_delivery_selesai_order_selesai()
    {
        // Setup
        $customer = $this->createCustomer();
        $order = Order::create([
            'customer_id'       => $customer->id,
            'invoice_number'    => 'TEST-005',
            'tanggal_pemesanan' => now(),
            'payment_status'    => 'belum_bayar',
            'status'            => 'delivery',
            'antar_barang'      => true,
            'total_harga'       => 0,
        ]);

        $delivery = DeliveryNote::create([
            'order_id' => $order->id,
            'status'   => 'menunggu',
        ]);

        // Act: Update delivery status to selesai
        $delivery->update(['status' => 'selesai']);

        // Assert
        $order->refresh();
        $this->assertEquals('selesai', $order->status);
    }

    /** Test: Production selesai → auto create Pickup (antar=0) */
    public function test_production_selesai_create_pickup_when_no_antar()
    {
        // Setup
        $customer = $this->createCustomer();
        $order = Order::create([
            'customer_id'       => $customer->id,
            'invoice_number'    => 'TEST-006',
            'tanggal_pemesanan' => now(),
            'payment_status'    => 'belum_bayar',
            'status'            => 'produksi',
            'antar_barang'      => false,
            'total_harga'       => 0,
        ]);

        $production = Production::create([
            'order_id' => $order->id,
            'status'   => 'menunggu',
        ]);

        // Act: Update production status to selesai
        $production->update(['status' => 'selesai']);

        // Assert
        $order->refresh();
        $this->assertEquals('pickup', $order->status);
        $this->assertTrue($order->pickup()->exists());
    }
}
