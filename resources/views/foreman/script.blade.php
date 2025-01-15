<style>
    .badge-medium {
        /* font-size: 10px;  */
        padding: 2px 6px;
        margin-top: 2px; 
    }
</style>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        var tableValidasi = $('#table-validasi').DataTable({
            pagingType: "simple_numbers",
            processing: true,
            serverSide: true,
            // colReorder: {
            //     realtime: false
            // },
            pageLength: 3,
            ajax: "{{ route('foreman.ListValidasiJob') }}",
            columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'id_job', name: 'id_job' },
            { data: 'validasi',  name: 'validasi' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            rowCallback: function(row, data) {
                if (data.validasi === 'Belum Divalidasi') {
                    var badgeContent = '<span class="badge badge-warning badge-medium" style="white-space: pre-wrap; color: black;">' + data.validasi + '</span>';
                    $('td:eq(2)', row).html(badgeContent);
                }
            },
            columnDefs: [
                {
                    "targets": "_all",
                    "className": "align-middle"
                },
            ],
        });

        var tableValidated = $('#table-validated').DataTable({
            pagingType: "simple_numbers",
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: "{{ route('foreman.jobValidated') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'project.project', name: 'project' },
                { data: 'id_job', name: 'id_job' },
                { data: 'id_mch', name: 'id_mch' },
                { data: 'main_task', name: 'main_task'},
                { 
                    data: 'lead_time',  
                    name: 'lead_time',
                    render: function(data, type, row) 
                    {
                        if (type === 'display') {
                            return data + ' Jam';
                        }
                        return data;
                    }
                },
                { data: 'project.targetHour',  name: 'project.targetHour' },
                { data: 'die_part',  name: 'die_part' },
                { data: 'priority',  name: 'priority'},
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function(row, data) {
                if (data.priority === 'High') {
                    $('td:eq(8)', row).html('<span class="badge badge-danger badge-medium">' + data.priority + '</span>');
                } else if (data.priority === 'Medium') {
                    $('td:eq(8)', row).html('<span class="badge badge-warning badge-medium">' + data.priority + '</span>');
                } else if (data.priority === 'Low') {
                    $('td:eq(8)', row).html('<span class="badge badge-secondary badge-medium">' + data.priority + '</span>');
                } 
            },
            columnDefs: [
                {
                    targets: "_all", className: "align-middle"
                }
            ]
        });

        // Button for showing ValidationModal
        $('body').on('click', '.validasiProject', function () {
            var project_id = $(this).data('id');
            $.get("{{ route('foreman.showValidasiJob', ':id_jobList') }}".replace(':id_jobList', project_id), function (data) {
                $('#validasiForm').trigger("reset");
                $('#validasiModal').modal('show');
                $('#project_id').val(data.project.id_project);
                $('#id_job').val(data.id_job);
                $('#part_name').val(data.project.part_name);
                $('#project').val(data.project.project);
            });
        });

        // Button Validasi
        $('#btnValidasi').click(function (e) {
            e.preventDefault();
            var checkboxes = $('input[name="options[]"]:checked');

            if (checkboxes.length === 0|| checkboxes.length !== 2) {
                $('#validationErrorMessage').removeClass('d-none'); // Tampilkan pesan error
                $('#validationSuccessMessage').addClass('d-none'); // Sembunyikan pesan sukses
            } else {
                $('#validationErrorMessage').addClass('d-none'); // Sembunyikan pesan error jika ada yang dicentang
                var validasiData = $('#validasiForm').serialize();
                var project_id = $('#project_id').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: validasiData,
                    url: "{{ route('foreman.validasiJob', ':id_jobList') }}".replace(':id_jobList', project_id),
                    type: "PUT",
                    dataType: 'json',
                    success: function (validasiData) {
                        $('#validasiForm').trigger("reset");
                        $('#validasiModal').modal('hide');
                        tableValidasi.draw();
                        tableValidated.draw();
                        $('#validationSuccessMessage').removeClass('d-none'); // Tampilkan pesan sukses

                        // Menghilangkan pesan sukses setelah 3 detik
                        setTimeout(function () {
                            $('#validationSuccessMessage').addClass('d-none');
                        }, 3000);
                    },
                    error: function (errorData) {
                        console.log('Error:', errorData);
                    }
                });
            }
        });

        // btn for closing modal
        $('#closeBtnValidasi').click(function (e) {
            e.preventDefault(); 
            $('#validasiModal').modal('hide');
        });

        $(document).on('click','.priority', function(e) {
            e.preventDefault();
            var rowId = $(this).data('id');
            var priority = $(this).data('priority');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('foreman.priorityJob', ':id_jobList') }}".replace(':id_jobList', rowId),
                type: "POST",
                data: {
                    priority: priority
                },
                dataType: 'json',
                success: function(response) {
                    tableValidated.draw();
                },
                error: function(error) {
                    console.log("Error:", error);
                }
            });
        });

    });
</script>

