<?php $__env->startSection('title', 'Preview Surat Jalan'); ?>

<style>
/* ===== CONTAINER ===== */
.print-wrapper {
    display: flex;
    justify-content: center;
    padding: 20px;
}

/* ===== DOCUMENT ===== */
.print-area {
    position: relative;
    width: 100%;
    max-width: 210mm;
    min-height: 297mm;
    background: white;
    padding: 25mm;
    box-shadow: 0 0 10px rgba(0,0,0,0.15);
    font-family: sans-serif;
    font-size: 12px;
}

/* ===== TABLE FIX ===== */
.print-area table {
    width: 100%;
}

/* ===== MOBILE ===== */
@media (max-width: 768px) {
    .print-area {
        padding: 20px;
        font-size: 11px;
    }

    .print-area img {
        height: 60px !important;
    }

    .watermark {
        font-size: 40px !important;
        left: 10% !important;
        top: 45% !important;
    }

    .print-area h2 {
        font-size: 18px !important;
    }

    .print-area h3 {
        font-size: 16px !important;
    }
}

/* ===== SMALL PHONE ===== */
@media (max-width: 480px) {
    .print-area {
        padding: 15px;
        font-size: 10px;
    }

    .watermark {
        font-size: 30px !important;
    }
}

/* ===== PRINT MODE ===== */
@media print {
    body * {
        visibility: hidden;
    }

    #printArea, #printArea * {
        visibility: visible;
    }

    #printArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 210mm;
        min-height: 297mm;
        box-shadow: none;
    }
}
</style>


<?php $__env->startSection('content'); ?>
<div style="text-align: right; margin-bottom: 20px;">
    <a href="<?php echo e(route('delivery.index')); ?>" class="btn btn-secondary btn-sm">
        ← Kembali
    </a>
</div>

<div class="print-wrapper">

    <div id="printArea" class="print-area">

        
       <div class="watermark" style="
    position:absolute;
    top:40%;
    left:20%;
    font-size:70px;
    color:rgba(0,0,0,0.05);
    transform: rotate(-30deg);
    z-index:0;
">
    SURAT JALAN
</div>

        
        <table style="width:100%; border-bottom:2px solid black; padding-bottom:10px;">
            <tr>
                
                <td width="20%" style="vertical-align:middle;">
                    <img src="<?php echo e(asset('assets/img/ca3.png')); ?>" style="height:90px;">
                </td>

                
                <td width="80%" style="text-align:center;">
                    <h2 style="margin:0; font-size:22px;">
                        PT. Cahaya Mutiara Biru
                    </h2>
                    <p style="margin:3px 0; font-size:10px;">
                        Jl. Pancasan No.19, RT.01/RW.07, Pasir Jaya, Kec. Bogor Bar.,
                        Kota Bogor, Jawa Barat 16119
                    </p>
                    <p style="margin:0; font-size:10px;">
                        Telp: 08118840838
                    </p>
                </td>
            </tr>
        </table>

        <div style="border-top:2px solid black; margin:10px 0 20px 0; position:relative; z-index:1;"></div>

        
        <h3 style="text-align:center; position:relative; z-index:1;">
            SURAT JALAN
        </h3>

        <table style="width:100%; position:relative; z-index:1;">
            <tr>
                <td width="20%">No Surat</td>
                <td width="30%">: <?php echo e($delivery->no_surat); ?></td>

                <td width="20%">Tanggal</td>
                <td width="30%">: <?php echo e(optional($delivery->tanggal_kirim)->format('d/m/Y')); ?></td>
            </tr>
            <tr>
                <td>Invoice</td>
                <td>: <?php echo e($delivery->order->invoice_number); ?></td>

                <td>Driver</td>
                <td>: <?php echo e($delivery->driver ?? '-'); ?></td>
            </tr>
        </table>

        <br>

        
        <table style="width:100%; position:relative; z-index:1;">
            <tr>
                <td width="20%">Kepada Yth</td>
                <td>: <?php echo e($delivery->order->customer->nama); ?></td>
            </tr>
            <tr>
                <td>No.Telpon</td>
                <td>: <?php echo e($delivery->order->customer->no_telp); ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <?php echo e($delivery->order->customer->alamat); ?></td>
            </tr>
        </table>

        <br>

        
        <table style="width:100%; border-collapse: collapse; position:relative; z-index:1;">
            <thead>
                <tr>
                    <th style="border:1px solid black; padding:8px;" width="5%">No</th>
                    <th style="border:1px solid black; padding:8px;">Nama Barang</th>
                    <th style="border:1px solid black; padding:8px;" width="10%">Qty</th>
                    <th style="border:1px solid black; padding:8px;" width="25%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $delivery->order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="height:70px;">
                    <td style="border:1px solid black; padding:8px; text-align:center; vertical-align:top;">
                        <?php echo e($loop->iteration); ?>

                    </td>
                    <td style="border:1px solid black; padding:8px; vertical-align:top;">
                        <?php echo e(strtoupper($item->merk)); ?>

                    </td>
                    <td style="border:1px solid black; padding:8px; text-align:center; vertical-align:top;">
                        <?php echo e($item->qty); ?>

                    </td>
                    <td style="border:1px solid black; padding:8px;"></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        
        <table style="width:100%; border-collapse: collapse; position:relative; z-index:1;">
            <tr>
                <td style="border:1px solid black; padding:10px; width:60%; vertical-align:top;">
                    <i><b>Catatan :</b> bayar setelah menerima barang</i>
                </td>
                <td style="border:1px solid black; padding:10px; width:40%; vertical-align:top;">
                    <b>PERHATIAN :</b><br>
                    1. Surat Jalan ini merupakan bukti resmi penerimaan barang<br>
                    2. Surat Jalan ini bukan bukti penjualan<br>
                    3. Surat Jalan ini akan dilengkapi invoice sebagai bukti penjualan
                </td>
            </tr>
        </table>

        <br><br>


        
        <table style="width:100%; margin-top:50px; position:relative; z-index:1;">
            <tr>
                <td style="text-align:center;">
                    Pengirim,<br><br><br><br>
                    (__________________)
                </td>

                <td style="text-align:center;">
                    Penerima,<br><br><br><br>
                    (__________________)
                </td>
            </tr>
        </table>

    </div>
</div>


<div class="text-center mt-4">
    <button onclick="printDiv()" class="btn btn-success">
        Print
    </button>

    <a href="<?php echo e(route('delivery.suratjln', $delivery->id)); ?>"
       class="btn btn-primary">
        Download PDF
    </a>
</div>

<script>
function printDiv() {
    var printContents = document.getElementById('printArea').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/delivery/preview-suratjln.blade.php ENDPATH**/ ?>