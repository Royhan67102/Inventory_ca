<!DOCTYPE html>
<html lang="id">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <?php echo $__env->make('layouts.partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <style>
    /* Fix modal / alert ketutup sidebar */
    .modal {
        z-index: 2000 !important;
    }

    .modal-backdrop {
        z-index: 1999 !important;
    }

    /* Kalau pakai SweetAlert */
    .swal2-container {
        z-index: 9999 !important;
    }
    </style>
</head>

<body class="g-sidenav-show bg-gray-100">

    <?php echo $__env->make('layouts.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        <?php echo $__env->make('layouts.partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="container-fluid py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </main>

    <?php echo $__env->make('layouts.partials.scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const sidenavBtn = document.getElementById("iconNavbarSidenav");
        const body = document.body;

        if (sidenavBtn) {
            sidenavBtn.addEventListener("click", function () {

                body.classList.toggle("g-sidenav-pinned");

                // Supaya smooth di mobile
                if (window.innerWidth < 1200) {
                    body.classList.toggle("g-sidenav-hidden");
                }

            });
        }

    });
    </script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/layouts/app.blade.php ENDPATH**/ ?>