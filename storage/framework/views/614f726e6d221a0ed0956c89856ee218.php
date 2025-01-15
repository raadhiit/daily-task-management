<ul class="navbar-nav sidebar siderbar-dark bg-dark text-white shadow" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
      <div class="icon" id="imgNonCollapsed">
        <img src="<?php echo e(asset('img/FTI_vertikal(1).png')); ?>" alt="" style="width: 55px; height:auto">
      </div>
      <div class="sidebar-brand-text mx-1 text-light"><i>FUJI TECHNICA INDONESIA</i></div>
      <div class="icon d-none" id="imgCollapsed">
        <img src="<?php echo e(asset('img/FTI_vertikal(1).png')); ?>" alt="" style="width: 55px; height:auto">
      </div>
    </a>
    
    <!-- Divider -->
    <hr class="sidebar-divider my-2" style="border-color: whitesmoke; border-width: 2px;">

    
      
      <?php if(auth()->user()->level == 1): ?>
      
      <li class="nav-item <?php echo e(request()->routeIs('project.index') ? 'active' : ''); ?>" >
          <a href="<?php echo e(route('project.index')); ?>" class="nav-link">
              <i class="fas fa-list-alt" style="font-size: 16px"></i>
              <span class="sidebar-text" style="font-size: 16px">PROJECT</span>
          </a>
      </li>

      <form action="<?php echo e(route('project.index')); ?>"></form>
      
      <li class="nav-item <?php echo e(request()->routeIs('admin.ljkh') ? 'active' : ''); ?>" >
          <a class="nav-link" href="<?php echo e(route('admin.ljkh')); ?>">
              <i class="fas fa-table" style="font-size: 16px"></i>
              <span class="sidebar-text" style="font-size: 16px">LJKH</span>
          </a>
      </li>
      
      <li class="nav-item <?php echo e(request()->routeIs('admin.indexUser') ? 'active' : ''); ?>" >
          <a class="nav-link" href="<?php echo e(route('admin.indexUser')); ?>">
            <i class="fas fa-solid fa-users" style="font-size: 16px"></i>
              <span class="sidebar-text" style="font-size: 16px">USERS</span>
          </a>
      </li>
      <?php endif; ?>
    

    
      
      <?php if(auth()->user()->level == 2): ?>
      <li class="nav-item <?php echo e(request()->routeIs('admin.DashboardAdmin') ? 'active' : ''); ?>" >
        <a class="nav-link" href="<?php echo e(route('admin.DashboardAdmin')); ?>" id="Dashboard_Admin">
            <i class="fas fa-tachometer-alt" style="font-size: 16px"></i>
            <span class="sidebar-text" style="font-size: 16px">DASHBOARD</span>
        </a>
      </li>
      <li class="nav-item <?php echo e(request()->routeIs('foreman.DashboardForeman') ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('foreman.DashboardForeman')); ?>" id="Dashboard_Foreman">
          <i class="fas fa-tachometer-alt" style="font-size: 16px"></i>
          <span class="sidebar-text" style="font-size: 16px">CURRENT PROCESS</span></a>
      </li>
      
      <li class="nav-item <?php echo e(request()->routeIs('foreman.ListValidasiJob') ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('foreman.ListValidasiJob')); ?>">
          <i class="fas fa-user-check" style="font-size: 16px"></i>
          <span class="sidebar-text" style="font-size: 16px">SCHEDULIING</span></a>
      </li>
      
      
      <?php endif; ?>
    

    <li class="nav-item">
      <form id="logoutForm" action="<?php echo e(route('logout')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <a class="nav-link" href="#" id="logoutAlert">
          <i class="fas fa-sign-out-alt" style="font-size: 16px"></i>
          <span style="font-size: 16px">LOGOUT</span>
        </a>
      </form>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" style="border-color: whitesmoke; border-width: 2px;">
    
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

<script>
  $(document).ready(function(){

    $('#logoutAlert').on('click', function(e){
      e.preventDefault();
      Swal.fire({
        title: 'Logout',
        text: 'Are you sure you want to logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, logout',
        confirmButtonColor: '#ff0000',
        cancelButtonText: 'Cancel',
      }).then((result) => {
        if (result.isConfirmed) {
          $('#logoutForm').submit();
        }
      });
    });

  });
</script>
<?php /**PATH C:\projek\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>