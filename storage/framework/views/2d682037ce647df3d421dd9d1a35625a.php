<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
    font-family: monospace;
    font-size:12px;
    margin:0;
}

/* ukuran nota dotmatrix */
.wrapper{
    width:90%;
    margin:0 auto;
}

/* HEADER */

.header{
    text-align:center;
    font-weight:bold;
    margin-bottom:10px;
}

/* INFO */

.info{
    width:100%;
    margin-bottom:10px;
}

.info td{
    border:none;
    padding:2px;
}

/* TABLE */

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #000;
    padding:5px;
}

th{
    text-align:center;
}

.text-center{
    text-align:center;
}

.text-right{
    text-align:right;
}

/* WATERMARK */

.watermark{
    position:fixed;
    top:45%;
    left:50%;
    transform:translate(-50%,-50%) rotate(-30deg);
    font-size:80px;
    color:rgba(0,0,0,0.07);
    font-weight:bold;
}

/* TTD */

.ttd td{
    border:none;
    padding-top:30px;
}

.td{
    border:1px solid #000;
    padding:6px;
}

</style>

</head>

<body>

<?php

$total = $order->total_harga;
$dp = $order->jumlah_bayar ?? 0;
$discount = $order->diskon ?? 0;

$totalDiskon = $total;
$sisa = $totalDiskon - $dp;

?>


<?php if($order->payment_status == 'lunas'): ?>
<div class="watermark">LUNAS</div>
<?php endif; ?>


<div class="wrapper">

<div class="header">
<h3>INVOICE</h3>
</div>


<table class="info">

<tr>

<td width="60%">
Nama Pemesan : <?php echo e($order->customer->nama); ?> <br>
Nama Pengirim : CAHAYA ACRYLIC <br>
Tanggal Pemesanan : <?php echo e($order->tanggal_pemesanan->format('d/m/Y')); ?> <br>
No rekening : BCA AN MAHMUD 8720516501
</td>

<td width="40%" class="text-right">
No Invoice : <?php echo e($order->invoice_number); ?>

</td>

</tr>

</table>



<table>

<thead>

<tr>
<th width="5%">No</th>
<th>Keterangan</th>
<th width="10%">QTY</th>
<th width="20%">Harga</th>
<th width="20%">Total</th>
</tr>

</thead>

<tbody>

<?php for($i = 1; $i <= 7; $i++): ?>

<tr>

<td class="text-center">
<?php echo e($i); ?>

</td>

<?php if(isset($order->items[$i-1])): ?>

<td>

<strong>
<?php echo e(strtoupper($order->items[$i-1]->product_name)); ?>

</strong>

<?php if($order->items[$i-1]->merk): ?>
<br>Merk : <?php echo e($order->items[$i-1]->merk); ?>

<?php endif; ?>

<?php if($order->items[$i-1]->ketebalan): ?>
<br>Ketebalan : <?php echo e($order->items[$i-1]->ketebalan); ?>

<?php endif; ?>

<?php if($order->items[$i-1]->warna): ?>
<br>Warna : <?php echo e($order->items[$i-1]->warna); ?>

<?php endif; ?>

<?php if($order->items[$i-1]->keterangan): ?>
<br><?php echo e($order->items[$i-1]->keterangan); ?>

<?php endif; ?>

</td>

<td class="text-center">
<?php echo e($order->items[$i-1]->qty); ?>

</td>

<td class="text-right">
Rp <?php echo e(number_format($order->items[$i-1]->harga,0,',','.')); ?>

</td>

<td class="text-right">
Rp <?php echo e(number_format($order->items[$i-1]->subtotal,0,',','.')); ?>

</td>

<?php else: ?>

<td></td>
<td></td>
<td></td>
<td class="text-center">-</td>

<?php endif; ?>

</tr>

<?php endfor; ?>


<tr>

<td colspan="4" class="text-center">
TOTAL
</td>

<td class="text-right">
Rp <?php echo e(number_format($totalDiskon,0,',','.')); ?>

</td>

</tr>


<?php if($discount > 0): ?>

<tr>

<td colspan="4" class="text-center">
DISCOUNT
</td>

<td class="text-right">
- Rp <?php echo e(number_format($discount,0,',','.')); ?>

</td>

</tr>

<?php endif; ?>



<?php if($order->payment_status == 'dp'): ?>

<tr>

<td colspan="4" class="text-center">
DP
</td>

<td class="text-right">
Rp <?php echo e(number_format($dp,0,',','.')); ?>

</td>

</tr>

<tr>

<td colspan="4" class="text-center">
TOTAL SISA PEMBAYARAN
</td>

<td class="text-right">
Rp <?php echo e(number_format($sisa,0,',','.')); ?>

</td>

</tr>

<?php endif; ?>



<?php if($order->payment_status == 'lunas'): ?>

<tr>

<td colspan="4" class="text-center">
LUNAS
</td>

<td class="text-right">
Rp <?php echo e(number_format($totalDiskon,0,',','.')); ?>

</td>

</tr>

<?php endif; ?>

</tbody>

</table>


<br>

<p>
* Kami tidak menerima selain pembayaran atau transaksi ke No rekening yang tertera
</p>


<br><br>


<table class="ttd">

<tr>

<td class="text-center">
Admin
<br><br><br>
(_______________)
</td>

<td class="text-center">
Penerima
<br><br><br>
<br>
(_______________)
</td>

</tr>

</table>

</div>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/invoice-pdf.blade.php ENDPATH**/ ?>