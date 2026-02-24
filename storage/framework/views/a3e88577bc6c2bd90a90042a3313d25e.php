<?php $__env->startSection('title', 'Edit Profile'); ?>
<?php $__env->startSection('page-title', 'Edit Profile'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-4">
    <div class="row">

        <!-- LEFT SIDEBAR -->
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-body text-center">

                    
                    <?php if($user->photo): ?>
                        <img src="<?php echo e(asset('storage/' . $user->photo)); ?>"
                             class="rounded-circle img-fluid mb-3"
                             width="120">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>"
                             class="rounded-circle img-fluid mb-3"
                             width="120">
                    <?php endif; ?>

                    <h5 class="mb-0"><?php echo e($user->name); ?></h5>
                    <p class="text-sm text-muted text-capitalize">
                        <?php echo e($user->role); ?>

                    </p>

                    <hr>

                    <a href="<?php echo e(route('profile.index')); ?>"
                        class="btn btn-outline-dark btn-sm w-100 mb-2">
                        Personal Information
                    </a>

                    <a href="<?php echo e(route('profile.edit')); ?>"
                        class="btn btn-dark btn-sm w-100">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- RIGHT FORM -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Edit Personal Information</h6>
                </div>

                <div class="card-body">

                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST"
                          action="<?php echo e(route('profile.update')); ?>"
                          enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>

                        <div class="row">

                            <!-- Name -->
                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text"
                                       name="name"
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('name', $user->name)); ?>">

                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('email', $user->email)); ?>">

                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label>Phone</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="<?php echo e(old('phone', $user->phone)); ?>">
                            </div>

                            <!-- Birthday -->
                            <div class="col-md-6 mb-3">
                                <label>Birthday</label>
                                <input type="date"
                                       name="birthday"
                                       class="form-control"
                                       value="<?php echo e(old('birthday', $user->birthday?->format('Y-m-d'))); ?>">
                            </div>

                            <!-- Employee Number -->
                            <div class="col-md-6 mb-3">
                                <label>Employee Number</label>
                                <input type="text"
                                       name="employee_number"
                                       class="form-control"
                                       value="<?php echo e(old('employee_number', $user->employee_number)); ?>">
                            </div>

                            <!-- Photo -->
                            <div class="col-md-6 mb-3">
                                <label>Photo</label>
                                <input type="file"
                                       name="photo"
                                       class="form-control">
                            </div>

                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="<?php echo e(route('profile.index')); ?>"
                                class="btn btn-light me-2">
                                Cancel
                            </a>

                            <button type="submit"
                                class="btn bg-gradient-dark">
                                Save Changes
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/profile/edit.blade.php ENDPATH**/ ?>