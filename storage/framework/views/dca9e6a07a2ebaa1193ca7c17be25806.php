<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>FTI | LOGIN</title>
  <link rel="icon" href="<?php echo e(asset('img/FTI_vertikal(1).png')); ?>" type="image/x-icon" >
  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <link href="<?php echo e(asset('admin_assets/vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  
  <!-- Custom styles for this template-->
  <link href="<?php echo e(asset('admin_assets/css/sb-admin-2.min.css')); ?>" rel="stylesheet">
</head>

<body class="bg-body" id="body_login">
  <div class="container mt-5">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class=" col-lg-6 col-md-8 col-sm-10">
        <div class="card o-hidden border-0 shadow-lg my-5 mx-auto">
          <div class="card-body d-flex justify-content-center">
            <!-- Nested Row within Card Body -->
            <div class="row text-center">
              <div class="col-lg ">
                <div class="py-3">
                  <img src="<?php echo e(asset('img/FTI_vertikal.png')); ?>" alt="gambar login" width="auto" height="200px" class="mb-3">
                  
                  <form action="<?php echo e(route('login.action')); ?>" method="POST" class="user">
                    <?php echo csrf_field(); ?>
                    <?php if($errors->any()): ?>
                      <div class="alert alert-danger">
                          <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </ul>
                      </div>
                    <?php endif; ?>
                    <div class="form-group">
                      <input name="NPK" type="text" class="form-control form-control-user" id="exampleInputNPK" placeholder="Enter NPK...">
                    </div>
                    <div class="form-group">
                      <input name="password" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>
                    <hr>
                    <div class="form-group">
                      <input name="id_mch" type="text" class="form-control form-control-user" id="exampleInputId_mch" placeholder="ID MESIN" autofocus>
                    </div>
                    <hr> 
                    <button type="submit" class="btn btn-primary btn-block btn-user">Login</button>
                  </form>
                  <br>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo e(asset('admin_assets/vendor/jquery/jquery.min.js')); ?>"></script>
  <script src="<?php echo e(asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?php echo e(asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js')); ?>"></script>
  <!-- Custom scripts for all pages-->
  <script src="<?php echo e(asset('admin_assets/js/sb-admin-2.min.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\projek\resources\views/auth/login.blade.php ENDPATH**/ ?>