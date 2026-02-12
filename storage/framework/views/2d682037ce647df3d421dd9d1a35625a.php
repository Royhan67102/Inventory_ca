<!DOCTYPE html>
<html>
<head>
    <title>Invoice <?php echo e($order->invoice->invoice_number ?? 'INV-'.$order->id); ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<h3 style="text-align:center;">INVOICE</h3>

<p><strong>Nama Pemesan:</strong> <?php echo e($order->customer->nama); ?></p>
<p><strong>Tanggal:</strong> <?php echo e($order->tanggal_pemesanan?->format('d M Y')); ?></p>

<table>
    <thead>
        <tr>
            <th>Produk</th>
            <th>Ukuran (cm)</th>
            <th>Qty</th>
            <th>Harga / m²</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($item->product_name); ?></td>
            <td><?php echo e($item->panjang_cm); ?> x <?php echo e($item->lebar_cm); ?></td>
            <td><?php echo e($item->qty); ?></td>
            <td>Rp <?php echo e(number_format($item->harga_per_m2,0,',','.')); ?></td>
            <td>Rp <?php echo e(number_format($item->subtotal,0,',','.')); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<br>

<p><strong>Total:</strong> Rp <?php echo e(number_format($order->invoice->total_harga ?? $order->total_harga,0,',','.')); ?></p>
<p><strong>DP:</strong> Rp <?php echo e(number_format($order->invoice->dp ?? 0,0,',','.')); ?></p>
<p><strong>Sisa Pembayaran:</strong> Rp <?php echo e(number_format($order->invoice->sisa_pembayaran ?? ($order->total_harga - ($order->invoice->dp ?? 0)),0,',','.')); ?></p>

<br>

<p><strong>Catatan:</strong></p>
<p>
Kami tidak menerima pembayaran selain melalui rekening resmi.
Segala bentuk kesalahan transfer bukan tanggung jawab kami.
</p>

<br><br>

<table width="100%">
<tr>
    <td align="center">
        Admin<br><br><br>____________________
    </td>
    <td align="center">
        Penerima<br><br><br>____________________
    </td>
</tr>
</table>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/invoice-pdf.blade.php ENDPATH**/ ?>