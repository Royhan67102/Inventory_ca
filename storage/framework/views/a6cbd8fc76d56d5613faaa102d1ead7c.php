<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice <?php echo e($order->invoice_number ?? 'INV-'.$order->id); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #f5f5f5;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<table width="100%" style="border:none;">
    <tr>
        <td style="border:none;">
            <p><strong>Nama Pemesan</strong> : <?php echo e($order->customer->nama); ?></p>
            <p><strong>Nama Penerima</strong> : Cahaya Akrilik</p>
            <p><strong>Tanggal Pemesanan</strong> : <?php echo e($order->tanggal_pemesanan->format('d F Y')); ?></p>
            <p><strong>No Rekening</strong> : BCA A/N Mahmud</p>
        </td>
        <td style="border:none; text-align:right;">
            <h3>INVOICE</h3>
            <p><?php echo e($order->invoice_number); ?></p>
        </td>
    </tr>
</table>

<br>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Keterangan</th>
            <th width="10%">QTY</th>
            <th width="15%">Harga</th>
            <th width="15%">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td class="text-center"><?php echo e($i + 1); ?></td>
            <td>
                <?php echo e(strtoupper($item->product_name)); ?>

                <?php echo e($item->panjang_cm); ?> x <?php echo e($item->lebar_cm); ?> CM
            </td>
            <td class="text-center"><?php echo e($item->qty); ?> SET</td>
            <td class="text-right">
                Rp <?php echo e(number_format($item->harga_per_m2,0,',','.')); ?>

            </td>
            <td class="text-right">
                Rp <?php echo e(number_format($item->subtotal,0,',','.')); ?>

            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<br>

<table width="100%" style="border:none;">
    <tr>
        <td style="border:none;">
            <strong>TOTAL SISA PEMBAYARAN</strong>
        </td>
        <td style="border:none;" class="text-right">
            <p><strong>TOTAL :</strong> Rp <?php echo e(number_format($order->total_harga,0,',','.')); ?></p>
            <p><strong>DP :</strong> Rp 0</p>
            <p><strong>SISA :</strong> Rp <?php echo e(number_format($order->total_harga,0,',','.')); ?></p>
        </td>
    </tr>
</table>

<br>

<p>
Kami tidak menerima selain pembayaran atau transaksi ke No rekening yang tertera.
</p>

<br><br>

<table width="100%" style="border:none;">
    <tr>
        <td style="border:none;"></td>
        <td style="border:none; text-align:center;">
            Penerima<br><br><br>
            <strong>Mahmud</strong>
        </td>
    </tr>
</table>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/show.blade.php ENDPATH**/ ?>