<!DOCTYPE html>
<html lang="en">

<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top" style="background-color: whitesmoke">  
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
    <!-- Topbar -->
    <?php echo $__env->make('member.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- End of Topbar -->

    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid mb-3 mt-4 pt-5 index-content">
            <?php echo $__env->yieldContent('member-content'); ?>
        </div>
    </div>
    <!-- End of Main Content -->
    
    <!-- Footer -->
    <?php echo $__env->make('member.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
    
    <?php echo $__env->make('layouts.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html><?php /**PATH C:\projek\resources\views/member/Main.blade.php ENDPATH**/ ?>