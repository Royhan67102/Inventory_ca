<!DOCTYPE html>
<html lang="id">
<head>
    <?php echo $__env->make('layouts.partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

</body>
</html>
<?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/layouts/app.blade.php ENDPATH**/ ?>