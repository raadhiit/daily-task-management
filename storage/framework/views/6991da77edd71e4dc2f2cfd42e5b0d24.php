

<?php $__env->startSection('title', 'LOGIN'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-5 col-lg-5">
                <div class="card 0-hidden border-0 shadow my-5 mx-auto">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <?php if(Session::has('success')): ?>
                            <div id="successMessage" class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="fa fa-times"></i>
                                </button>
                                <strong>Success !</strong> <?php echo e(session('success')); ?>

                            </div>
                        <?php elseif(Session::has('error')): ?>
                            <div id="errorMessage" class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="fa fa-times"></i>
                                </button>
                                <strong>Error !</strong> <?php echo e(session('error')); ?>

                            </div>
                        <?php elseif($errors->any()): ?>
                            <div id="wrongUserPass" class="alert alert-danger wrongUserPass">
                                <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo e(route('login.action')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div id="loginMessage"></div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" id="login" class="btn btn-primary">Login</button>
                            <a href="<?php echo e(route('registerUser')); ?>" class="btn btn-success">Register</a>
                            <a href="<?php echo e(route('updatePass')); ?>" class="btn btn-warning">Reset Password</a>
                            <button type="reset" class="btn btn-light">Clear</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\projek\resources\views/auth/login.blade.php ENDPATH**/ ?>