

<?php $__env->startSection('title', 'REGISTER'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-5 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        Register
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('register')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div id="registerMessage"></div>
                            <div class="form-group">
                                <label for="registerFullName">Name<span class="requiredIcon">*</span></label>
                                <input type="text" class="form-control" id="registerFullName" name="registerFullName">
                            </div>
                            <div class="form-group">
                                <label for="registerUsername">Username<span class="requiredIcon">*</span></label>
                                <input type="text" class="form-control" id="registerUsername" name="registerUsername" autocomplete="on">
                            </div>
                            <div class="form-group">
                                <label for="registerPassword1">Password<span class="requiredIcon">*</span></label>
                                <input type="password" class="form-control" id="registerPassword1" name="registerPassword1">
                            </div>
                            <div class="form-group">
                                <label for="registerPassword2">Re-enter password<span class="requiredIcon">*</span></label>
                                <input type="password" class="form-control" id="registerPassword2" name="registerPassword2">
                            </div>
                            <div class="form-group">
                                <label for="level">Role<span class="requiredIcon">*</span></label>
                                <input type="text" class="form-control" id="level" name="level">
                            </div>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Login</a>
                            <button type="submit" class="btn btn-success">Register</button>
                            <a href="<?php echo e(route('updatePass')); ?>" class="btn btn-warning">Reset Password</a>
                            <button type="reset" class="btn">Clear</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\projek\resources\views\auth\register.blade.php ENDPATH**/ ?>