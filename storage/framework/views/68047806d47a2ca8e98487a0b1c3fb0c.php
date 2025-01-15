

<?php $__env->startSection('title', 'Edit-LJKH'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="container-fluid">
        <a href="<?php echo e(route('admin.ljkh')); ?>" class="d-none d-sm-inline-block btn btn-primary shadow-sm float-right"
            style="margin-top: 15px">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i>BACK
        </a>
        <h1 class="mb-0 mt-4">Edit LJKH</h1>
        <hr style="border-top-color:gray">

        <?php if(Session::has('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(Session::get('error')); ?>

            </div>
        <?php endif; ?>

        <div class="card shadow rounded">
            <div class="card-body">
                <form action="<?php echo e(route('admin.updateLJKH', $ljkh->id_ljkh)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="row mb-1">
                        <div class="col">
                            <span style="color: red">*</span>
                            <label style="color: black"><strong>PROJECT</strong></label>
                            <input class="form-control" type="text" name="project" id="project"
                                value="<?php echo e($ljkh->project); ?>">
                        </div>
                        <div class="col">
                            <span style="color:red;">*</span>
                            <label style="color:black"><strong>ID MACHINING</strong></label>
                            <select class="form-control" name="id_mch" id="id_mch">
                                <option selected><?php echo e($ljkh->id_mch); ?></option>
                                <?php $__currentLoopData = $idMchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idMch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($idMch); ?>"><?php echo e($idMch); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col">
                            <span style="color:red;">*</span>
                            <label style="color: black"><strong>ID JOB</strong></label>
                            <input type="text" name="id_job" id="id_job" class="form-control"
                                value="<?php echo e(substr($ljkh->id_job, 0, 7)); ?>">
                            <?php $__errorArgs = ['id_job'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col">
                            <span style="color:red;">*</span>
                            <label style="color: black"><strong>TASK NAME</strong></label>
                            <select class="form-control" name="activity_name" id="activity_name">
                                <option selected><?php echo e($ljkh->activity_name); ?></option>
                                <?php $__currentLoopData = $taskNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $TN): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($TN); ?>"><?php echo e($TN); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col">
                            <span style="color:red;">*</span>
                            <label style="color: black"><strong>DIE PART</strong></label>
                            <input type="text" class="form-control" name="die_part" id="die_part"
                                value="<?php echo e($ljkh->die_part); ?>">
                        </div>
                        <div class="col">
                            <span style="color:red;">*</span>
                            <label style="color: black"><strong>ITU</strong></label>
                            <select class="form-control" name="itu" id="itu">
                                <option selected><?php echo e($ljkh->itu); ?></option>
                                <option value="AT01">AT01</option>
                                <option value="AT02">AT02</option>
                                <option value="AT03">AT03</option>
                                <option value="AT04">AT04</option>
                                <option value="AT07">AT07</option>
                                <option value="AU01">AU01</option>
                                <option value="AU03">AU03</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block btn-warning mt-5">Update</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\projek\resources\views/admin/editLJKH.blade.php ENDPATH**/ ?>