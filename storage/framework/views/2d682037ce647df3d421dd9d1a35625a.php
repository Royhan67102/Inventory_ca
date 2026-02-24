<!DOCTYPE html>
<html>
<head>
    <title>Invoice <?php echo e($order->invoice->invoice_number ?? 'INV-'.$order->id); ?></title>
    <style>

body {
    font-family: Arial, sans-serif;
    font-size: 13px;
    margin: 20px;
}

/* CONTAINER */
.invoice-wrapper {
    max-width: 900px;
    margin: auto;
}

/* TITLE */
.invoice-title {
    text-align: center;
    margin-bottom: 20px;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #000;
    padding: 8px;
    font-size: 12px;
}

th {
    background: #f5f5f5;
}

.text-right { text-align: right; }
.text-center { text-align: center; }

/* SIGNATURE */
.signature-table td {
    border: none;
    padding-top: 40px;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {

    body {
        font-size: 11px;
        margin: 10px;
    }

    th, td {
        font-size: 10px;
        padding: 6px;
    }

    .invoice-title {
        font-size: 16px;
    }

    /* TABLE SCROLL */
    .table-responsive {
        overflow-x: auto;
    }

}

/* ================= PRINT ================= */
@media print {
    body {
        margin: 0;
    }
}

</style>
</head>
<body>
<div class="invoice-wrapper">

<h3 class="invoice-title">INVOICE</h3>

<p><strong>Nama Pemesan:</strong> <?php echo e($order->customer->nama); ?></p>
<p><strong>Tanggal:</strong> <?php echo e($order->tanggal_pemesanan?->format('d M Y')); ?></p>

<div class="table-responsive">
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

<table class="signature-table" width="100%">
<tr>
    <td align="center">
        Admin<br><br><br>____________________
    </td>
    <td align="center">
        Penerima<br><br><br>____________________
    </td>
</tr>
</table>
</div>

</body>
</div>
</html>
<?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/invoice-pdf.blade.php ENDPATH**/ ?>