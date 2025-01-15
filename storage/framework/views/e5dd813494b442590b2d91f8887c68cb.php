

<?php $__env->startSection('title', 'Reset Password'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-5 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        Reset Password
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('storePass')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div id="resetPasswordMessage"></div>
                            <div class="form-group">
                                <label for="resetPasswordUsername">Username</label>
                                <input type="text" class="form-control" id="resetPasswordUsername" name="resetUsername" value="<?php echo e(old('resetUsername')); ?>">
                                <?php if($errors->has('resetUsername')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('resetUsername')); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="resetPasswordPassword1">New Password</label>
                                <input type="password" class="form-control" id="resetPasswordPassword1" name="resetPassword1">
                            </div>
                            <div class="form-group">
                                <label for="resetPasswordPassword2">Confirm New Password</label>
                                <input type="password" class="form-control" id="resetPasswordPassword2" name="resetPassword2">
                            </div>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Login</a>
                            <a href="<?php echo e(route('registerUser')); ?>" class="btn btn-success">Register</a>
                            <button type="submit" class="btn btn-warning">Reset Password</button>
                            <button type="reset" class="btn">Clear</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\projek\resources\views\auth\updatePassword.blade.php ENDPATH**/ ?>