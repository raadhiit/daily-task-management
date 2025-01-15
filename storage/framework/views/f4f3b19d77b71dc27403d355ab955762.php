<div class="btn-gorup" role="group" aria-label="Basic example">
    <a href="<?php echo e(route('admin.editUser', $user->id)); ?>" class="btn btn-outline-dark btn-sm editUser"><i class="fas fa-edit"></i></a>
    <a href="#" data-id="<?php echo e($user->id); ?>" class="btn btn-sm btn-outline-danger delUser"><i class="fas fa-trash-alt"></i></a>
</div>

<script>
    $(document).ready(function(){
        $('.delUser').on('click', function(e){
            e.preventDefault();
            var UserId = $(this).data('id');
            Swal.fire({
                title: 'Hapus User?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus user!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengkonfirmasi, kirim permintaan AJAX untuk membatalkan pekerjaan
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "<?php echo e(route('admin.destroyUser', ':id')); ?>".replace(':id', UserId),
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                var Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "info",
                                    title: "User Berhasil Dihapus"
                                });
                                setTimeout(function () {
                                        var table = $('#table-user').DataTable();
                                        table.ajax.reload();
                                    }, 500);
                            } else {
                                Swal.fire('Gagal!', 'Gagal menghapus user.', 'error');
                            }
                        },
                        error: function(error) {
                            console.error("Error:", error);
                        }
                    });
                }
            });
        });
    });
</script><?php /**PATH C:\projek\resources\views/admin/UserBtn.blade.php ENDPATH**/ ?>