

<?php $__env->startSection('title', 'USER'); ?>

<?php $__env->startSection('contents'); ?>
<div class="container-fluid">
    <div class="container-flex align-items-center justify-content-center text-center mb-3 mt-1">
        <h1 class="mb-0">USER</h1>
        <h5 class="mb-1"><i>MACHINING SECTION</i></h5>
    </div>
    <hr style="border-top-color:gray">
    


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
        <div class="card-body">
            <a href="<?php echo e(route('admin.createUser')); ?>" class="btn btn-primary mb-3"><i class="fas fa-plus"></i>  Add User</a>
            <table class="table table-bordered text-center table-sm" id="table-user" style="color: black;">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">NO</th>
                        <th class="text-center">NAMA</th>
                        <th class="text-center">SECTION</th>
                        <th class="text-center">NPK</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-center">LAST LOGIN</th>
                        <th class="text-center">ACTION</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        var tableUser = $('#table-user').DataTable({
            pagingType:"simple_numbers",
            processing: true,
            serverSide: true,
            ajax:"<?php echo e(route('admin.indexUser')); ?>",
            columns:[
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'sub', name: 'sub'},
                {data: 'NPK', name: 'NPK'},
                {data: 'level', name: 'level'},
                {data: 'last_login_at', name: 'last_login_at'},
                {data: 'action', name: 'action', orderable: false, searchable:false},
            ],
            rowCallback: function(row, data) {
                if(data.level === 1){
                    $('td:eq(4)', row).html('<span class="badge badge-info">' + 'Admin'+ '</span>');
                } else if (data.level === 2){
                    $('td:eq(4)', row).html('<span class="badge badge-secondary">' + 'Foreman'+ '</span>');
                } else if (data.level === 3){
                    $('td:eq(4)', row).html('<span class="badge badge-primary">' + 'Member'+ '</span>');
                }

                if (data.last_login_at) {
                    var lastLogin = moment(data.last_login_at);
                    var output = lastLogin.fromNow(); // Menghitung perbedaan waktu dalam format yang mudah dibaca manusia
                    $('td:eq(5)', row).html('<span class="badge badge-dark">' + output + '</span>');
                } else {
                    $('td:eq(5)', row).html('<span class="badge badge-danger">Never Logged In</span>' ); // Jika pengguna belum pernah login
                }
            },
            columnDefs: [{ targets: '_all', className: 'align-middle'}]
        });

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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\projek\resources\views/admin/indexUser.blade.php ENDPATH**/ ?>