

<?php $__env->startSection('title', 'LJKH'); ?>

<?php $__env->startSection('contents'); ?>

<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-center">
        <h1 class="text-center badge badge-dark fs-2 mt-3"><i>LEMBAR JAM KERJA HARIAN</i></h1>
    </div>
    <hr style="border-top-color:gray">
    
    <div class="text-between mb-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <a href="<?php echo e(route('admin.exportLJKH')); ?>" class="btn btn-success"><i class="fas fa-download"></i><b>  Export</b></a>
            </div>

            
            <div class="col-4">
                <form id="searchForm" action="<?php echo e(route('admin.ljkh')); ?>" method="GET">
                    <input type="text" id="searchInput" class="form-control" name="search" value="<?php echo e($search); ?>" placeholder="Search...">
                </form>
            </div>
        </div>
    </div>

    <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"></button>
            <strong>Success !</strong> <?php echo e(session('success')); ?>

        </div>
    <?php elseif(Session::has('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"></button>
            <strong>Error !</strong> <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div class="card shadow rounded">
        <div class="card-body text-dark">
            <table class="table table-sm table-hover table-striped table-bordered text-center rounded-2 overflow-hidden tableLJKH">
                <thead class="table-dark" style="height: 3em;">
                    <tr>
                        <th class="align-middle">#</th>
                        <th class="align-middle">DATE</th>
                        <th class="align-middle">NAME</th>
                        <th class="align-middle">ID MACHINING</th>
                        <th class="align-middle">ID SUB</th>
                        <th class="align-middle">ID JOB</th>
                        <th class="align-middle">WORK CENTER</th>
                        <th class="align-middle">TASK NAME</th>
                        <th class="align-middle">PRODUCTION HOUR</th>
                        <th class="align-middle">START</th>
                        <th class="align-middle">ITU</th>
                        <th class="align-middle">ACTION</th>
                    </tr>
                </thead>
        
                <tbody class="text-center">
                    <?php if($ljkh->count() > 0): ?>
                        <?php $__currentLoopData = $ljkh; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="align-middle"><?php echo e($ljkh->firstItem() + $loop->index); ?></td>
                                <td class="align-middle"><?php echo e($l->Date); ?></td>
                                <td class="align-middle"><?php echo e($l->name); ?></td>
                                <td class="align-middle"><?php echo e($l->id_mch); ?></td>  
                                <td class="align-middle"><?php echo e($l->sub); ?></td>  
                                <td class="align-middle"><?php echo e($l->id_job); ?></td>  
                                <td class="align-middle"><?php echo e($l->work_ctr); ?></td>  
                                <td class="align-middle"><?php echo e($l->activity_name); ?></td>  
                                <td class="align-middle"><?php echo e($l->prod_hour); ?></td>
                                <td class="align-middle"><?php echo e(substr($l->start, 0, 5)); ?></td>  
                                <td class="align-middle"><?php echo e($l->itu ?? '-'); ?></td>      
                                <td class="align-middle">
                                    <div class="row ">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <a href="<?php echo e(route('admin.editLJKH', $l->id_ljkh)); ?>" type="button" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                            <form action="<?php echo e(route('admin.deleteLJKH', $l->id_ljkh)); ?>" method="POST" type="button" class="btn btn-danger btn-group-sm p-0" onsubmit="return confirm('Delete?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-danger m-0"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="20">Tidak Ada Task Hari Ini</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                <?php echo e($ljkh->links()); ?>

            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        var alertSelector = ".alert.alert-dismissible"; 
        $(alertSelector).each(function() {
            var alert = $(this);
            setTimeout(function() {
                alert.fadeOut(500, function() {
                alert.remove(); 
                });
            }, 3000); 
        });
    });
</script>

<?php echo $__env->make('admin.importModal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                $('#searchForm').submit();
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\projek\resources\views/admin/ljkh.blade.php ENDPATH**/ ?>