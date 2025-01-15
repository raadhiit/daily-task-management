<!-- Modal -->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header shadow bg-info justify-content-center">
                <h3 class="modal-title text-center text-light" id="modalTitleId">Import LJKH</h3>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('importLJKH')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="file" class="form-label">Choose CSV File:</label>
                                <input type="file" class="form-control" id="file" name="file" accept=".csv">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info waves-effect" id="btnSubmitImport">Import Data</button>
                <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    $('.btnImport').on('click', function(e) {
        e.preventDefault();
        $('#modalImport').modal('show');
    });

    $('#btnSubmitImport').on('click', function (e) {
        e.preventDefault();

        var fileInput = $('#file')[0]; // Menggunakan [0] untuk mengakses elemen input file
        var files = fileInput.files;

        var formData = new FormData();
        formData.append('file', files[0]);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "<?php echo e(route('importLJKH')); ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                $('#modalImport').modal('hide');
                setTimeout(function(){
                    updateLjkhView();
                }, 500);
            },
            error: function (response) {
                console.error(response);
            } 
        });
    });

    function updateLjkhView() {
        $.ajax({
            type: "GET",
            url: "<?php echo e(route('admin.ljkh')); ?>",
            success: function(response) {
                // Replace the content of the index view with the updated content
                $('.index-content').html($(response).find('.index-content').html());
            },
            error: function(error) {
                console.error("Error updating index view:", error);
            }
        });
    }

});
</script>
<?php /**PATH C:\projek\resources\views/admin/importModal.blade.php ENDPATH**/ ?>