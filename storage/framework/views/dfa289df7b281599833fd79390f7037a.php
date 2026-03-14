<?php $__env->startSection('content'); ?>

<div class="card">

<div class="card-body text-center">

    
    <div id="area-print">
        <?php echo $__env->make('orders.invoice-pdf', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

    <br>

    
    <div class="no-print">

        <a href="<?php echo e(route('orders.invoice.download',$order)); ?>"
        class="btn btn-success">
            Download PDF
        </a>

        <button onclick="window.print()"
        class="btn btn-secondary">
            Print
        </button>

    </div>

</div>

</div>

<?php $__env->stopSection(); ?>



<?php $__env->startPush('styles'); ?>

<style>

/* ================= PRINT AREA ================= */

@media print {

body *{
    visibility:hidden;
}

/* tampilkan hanya invoice */
#area-print,
#area-print *{
    visibility:visible;
}

/* posisi invoice */
#area-print{
    position:absolute;
    left:0;
    top:0;
    width:100%;
}

/* sembunyikan tombol */
.no-print{
    display:none;
}

}

</style>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/invoice.blade.php ENDPATH**/ ?>