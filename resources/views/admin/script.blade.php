<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function btnSimpan(){
        $('.tombol-simpan').show();
        $('.tombol-update').hide();
    }

    function btnUpdate() {
        $('.tombol-update').show();
        $('.tombol-simpan').hide();
    }

$(document).ready(function () {
    // var table = $('#table-index').DataTable({
    //     pageLength: 10,
    //     processing: true,
    //     responsive: true,
    //     serverSide: true,
    //     ajax: {
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         url: "{{ route('project.getData') }}",
    //         type: "GET",
    //     },
    //     columns: [
    //         { data: 'DT_RowIndex', name: 'DT_RowIndex' },
    //         { data: 'project', name: 'project' },
    //         { data: 'part_name', name: 'part_name' },
    //         { data: 'part_no', name: 'part_no' },
    //         { data: 'anumber', name: 'anumber'},
    //         { data: 'action', name: 'action', orderable: false, searchable: false }
    //     ],
    //     "columnDefs": [
    //         {
    //             "targets": "_all",
    //             "className": "align-middle"
    //         },
    //     ]
    // });

    var alertSelector = ".alert.alert-dismissible"; 
    $(alertSelector).each(function() {
        var alert = $(this);
        setTimeout(function() {
            alert.fadeOut(500, function() {
            alert.remove(); 
            });
        }, 3000); 
    });


    // Tambah Project
    $('#addProject').click(function () {
        btnSimpan();
        $('#projectForm').trigger("reset");
        $('.modal-title strong').text("Add Project");
        $('#exampleModal').modal('show');
    });

    // Simpan Project
    $('.tombol-simpan').click(function () {
        var formData = $('#projectForm').serialize();
        var user = {!! json_encode(Auth::user()) !!};
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            url: "{{ route('project.store') }}",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#projectForm').trigger("reset");
                $('#exampleModal').modal('hide');
                // table.ajax.reload();
                $('#table-index').load('{{ route('project.index') }} #table-index > *');
                var Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                Toast.fire({
                    title: 'Project berhasil ditambakan! ',
                    icon: "success",
                    customClass:{
                        title: 'text',
                    }
                });
            },
            error: function (data) {
                var errorMessage = data.responseJSON && data.responseJSON.error ? data.responseJSON.error : 'An error occurred';
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.log('Error:', data);
            }
        });
    });

    // $('.tombol-simpan').click(function () {
    // var formData = $('#projectForm').serialize();
    // $.ajax({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     data: formData,
    //     url: "{{ route('project.store') }}",
    //     type: "POST",
    //     dataType: 'json',
    //     success: function (data) {
    //         $('#projectForm').trigger("reset");
    //         $('#exampleModal').modal('hide');
    //         // Reload table content manually
    //         $.get("{{ route('project.index') }}", function(data) {
    //             $('#table-index tbody').empty();
    //             $.each(data.projects, function(index, project) {
    //                 $('#table-index tbody').append(
    //                     '<tr>' +
    //                         '<td>' + project.project + '</td>' +
    //                         '<td>' + project.part_name + '</td>' +
    //                         '<td>' + project.part_no + '</td>' +
    //                         '<td>' + project.anumber + '</td>' +
    //                         '<td><button class="btn btn-outline-danger deleteProject" data-id="' + project.id + '"><i class="fas fa-trash-alt"></i></button></td>' +
    //                     '</tr>'
    //                 );
    //             });
    //         });
    //         var Toast = Swal.mixin({
    //             toast: true,
    //             position: "top-end",
    //             showConfirmButton: false,
    //             timer: 3000,
    //             timerProgressBar: true,
    //         });
    //         Toast.fire({
    //             title: 'Project berhasil ditambahkan!',
    //             icon: "success",
    //             customClass: {
    //                 title: 'text',
    //             }
    //         });
    //     },
    //     error: function (data) {
    //         var errorMessage = data.responseJSON && data.responseJSON.error ? data.responseJSON.error : 'An error occurred';
    //         Swal.fire({
    //             title: 'Error!',
    //             text: errorMessage,
    //             icon: 'error',
    //             confirmButtonText: 'OK'
    //         });
    //         console.log('Error:', data);
    //     }
    //     });
    // });


    $('.tombol-update').click(function () {
        var updateData = $('#projectForm').serialize();
        var project_id = $('#project_id').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: updateData,
            url: "{{ route('project.update', ':id') }}".replace(':id', project_id),
            type: "PUT",
            dataType: 'json',
            success: function (updatedData) {
                $('#projectForm').trigger("reset");
                $('#exampleModal').modal('hide');
                table.ajax.reload();
            },
            error: function (errorData) {
                console.log('Error:', errorData);
            }
        });
    });

    // Edit Project
    // $('body').on('click', '.editProject', function () {
    //     var project_id = $(this).data('id');
    //     $.get("{{ route('project.edit', ':id') }}".replace(':id', project_id), function (data) {
    //         $('#projectForm').trigger("reset");
    //         $('.modal-title strong').text("Edit Project");
    //         $('#exampleModal').modal('show');
    //         $('#project_id').val(data.id);
    //         $('#project').val(data.project);
    //         $('#part_name').val(data.part_name);
    //         $('#part_no').val(data.part_no);
    //         $('#Anumber').val(data.Anumber);
    //         btnUpdate(); // Menampilkan tombol "Update" saat mengedit
    //     });
    // });

    // Hapus Project
    $('body').on('click', '.deleteProject', function () {
        Swal.fire({
            icon: "question",
            title: "Hapus Data?",
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: "red",
        }).then((result) => {
            if(result.isConfirmed) {
                var project_id = $(this).data("id");
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('project.destroy', ':id_project') }}".replace(':id_project', project_id),
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (data) {
                        // table.draw();
                        $('#table-index').load('{{ route('project.index') }} #table-index > *');
                        Swal.fire({
                            icon: "success",
                            title: "Data Berhasil Dihapus!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
        // if (confirm("Apakah Anda yakin ingin menghapus project ini?")) {
        // }
    });

    $('body').on('click', '.importProject',function(e) {
        e.preventDefault();
        $('#modalImportProject').modal('show');
    });

    // $('#submitProject').on('click', function(e) {
    //     e.preventDefault();
    //     var fileInput = $('#fileProject')[0];

    //     if (fileInput.files.length > 0) {
    //         var fileProject = fileInput.files[0];
    //         var formData = new FormData();
    //         formData.append('fileProject', fileProject);

    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             url: "{{ route('project.importProject') }}",
    //             type: "POST",
    //             data: formData,
    //             contentType: false,
    //             processData: false,
    //             success: function(response) {
    //                 console.log(response);
    //                 $('#modalImportProject').modal('hide');
    //                 table.draw();
    //             },
    //             error: function(response) {
    //                 console.error(response);
    //             } 
    //         });
    //     } else {
    //         console.error('File tidak dipilih.');
    //     }
    // });

});
</script>

<script>
    function checkAndFixAnumber() {
        var input = document.getElementById('Anumber');
        var value = input.value;

        if (value.length === 0 || value.charAt(0) !== 'A') {
            input.value = 'A' + value;
        }
    }

    document.getElementById('Anumber').addEventListener('blur', function () {
        var idJobInput = this.value;
        if (idJobInput.length < 7 || !idJobInput.startsWith('A')) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Anumber harus memiliki panjang minimal 7 karakter dan dimulai dengan huruf A!',
            });
            this.value = ''; // Membersihkan nilai input jika tidak memenuhi validasi
        }
    });
</script>
