// unused script.js in 

// script for adding "A" in front of input in id_job form
    // Tambahkan event listener pada saat formulir dikirim
    // document.querySelector('form').addEventListener('submit', function(event) {
    //     var idJobInput = document.getElementById('id_job').value;
    //     if (idJobInput.length !== 7 || !idJobInput.startsWith('A')) {
    //         event.preventDefault(); // Mencegah pengiriman formulir
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Oops...',
    //             text: 'ID JOB harus memiliki panjang 6 karakter dan dimulai dengan huruf "A"!',
    //         });
    //     }
    // });

    // {{-- <script>
    //     $(document).ready(function () {
    //         // Tangani event klik pada tombol-tombol di dalam modal downtime
    //         $('#downtimeModal button').on('click', function () {
    //             var keterangan = $(this).data('keterangan'); // Ambil nilai keterangan dari tombol yang diklik
    
    //             // Kirim form menggunakan AJAX
    //             $.ajax({
    //                 url: "{{ route('downtime.submit') }}",
    //                 type: "POST",
    //                 data: {
    //                     _token: $('meta[name="csrf-token"]').attr('content'),
    //                     activity_name: keterangan
    //                 },
    //                 success: function (response) {
    //                     console.log(response); // Anda bisa melakukan sesuatu setelah sukses submit
    
    //                     // Tampilkan modal notifikasi
    //                     $('#notifModal').modal('show');
    //                 },
    //                 error: function (xhr, status, error) {
    //                     console.log(xhr.responseText); // Log pesan error jika ada
    //                 }
    //             });
    //         });
    //     });
    // </script> --}}

    // {{-- <script>
    //     $(document).ready(function() {
    //         $('#table-index').DataTable({
    //             processing: true,
    //             serverside: true,
    //             ajax: "{{ route('project.index') }}",
    //             columns: [{
    //                 data: 'DT_RowIndex',
    //                 name: 'DT_RowIndex',
    //                 orderable: false,
    //                 searchable: false
    //             }, {
    //                 data: 'project',
    //                 name: 'project'
    //             }, {
    //                 data: 'Anumber',
    //                 name: 'Anumber'
    //             }, {
    //                 data: 'aksi',
    //                 name: 'Aksi'
    //             }]
    //         });
    //     });
    
    //     // GLOBAL SETUP 
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    
    //     // 02_PROSES SIMPAN 
    //     $('body').on('click', '#addProject', function(e) {
    //         e.preventDefault();
    //         $('#exampleModal').modal('show');
    //         $('.tombol-simpan').click(function() {
    //             simpan();
    //         });
    //     });
    
    //     // 03_PROSES EDIT 
    //     $('body').on('click', '.tombol-edit', function(e) {
    //         var id = $(this).data('id');
    //         $.ajax({
    //             url: "{{ route('project.edit') }}",
    //             type: 'GET',
    //             success: function(response) {
    //                 $('#exampleModal').modal('show');
    //                 $('#project').val(response.result.project);
    //                 $('#Anumber').val(response.result.Anumber);
    //                 console.log(response.result);
    //                 $('.tombol-simpan').click(function() {
    //                     simpan(id);
    //                 });
    //             }
    //         });
    //     });
    
    
    //     // 04_PROSES Delete 
    //     $('body').on('click', '.tombol-del', function(e) {
    //         if (confirm('Yakin mau hapus data ini?') == true) {
    //             var id = $(this).data('id');
    //             $.ajax({
    //                 url: "{{ route('project.destroy',['id'=>$data->id]) }}",
    //                 type: 'DELETE',
    //             });
    //             $('#table-index').DataTable().ajax.reload();
    //         }
    //     });
    
    //     // fungsi simpan dan update
    //     function simpan(id = '') {
    //         if (id == '') {
    //             var var_url = "{{ route('project.store') }}";
    //             var var_type = 'POST';
    //         } else {
    //             var var_url = "{{ route('project.update', ['id'=>$data->id]) }}";
    //             var var_type = 'PUT';
    //         }
    //         $.ajax({
    //             url: var_url,
    //             type: var_type,
    //             data: {
    //                 project: $('#project').val(),
    //                 Anumber: $('#Anumber').val()
    //             },
    //             success: function(response) {
    //                 if (response.errors) {
    //                     console.log(response.errors);
    //                     $('.alert-danger').removeClass('d-none');
    //                     $('.alert-danger').html("<ul>");
    //                     $.each(response.errors, function(key, value) {
    //                         $('.alert-danger').find('ul').append("<li>" + value +
    //                             "</li>");
    //                     });
    //                     $('.alert-danger').append("</ul>");
    //                 } else {
    //                     $('.alert-success').removeClass('d-none');
    //                     $('.alert-success').html(response.success);
    //                 }
    //                 $('#table-index').DataTable().ajax.reload();
    //             }
    
    //         });
    //     }
    
    //     $('#exampleModal').on('hidden.bs.modal', function() {
    //         $('#project').val('');
    //         $('#Anumber').val('');
    
    //         $('.alert-danger').addClass('d-none');
    //         $('.alert-danger').html('');
    
    //         $('.alert-success').addClass('d-none');
    //         $('.alert-success').html('');
    //     });
    // </script> --}}

    // {{-- StartJob --}}
    // {{-- <script>
    //     $(document).ready(function () {
    //         $('#anForm button').click(function (e) {
    //             var activity_name = $(this).data('activity_name');
    //             var job_id = $(this).data('job_id');
    //             var user = {!! json_encode(Auth::user()) !!};
    
    //             $('#job_id').val(job_id);
        
    //             $.ajax({
    //                 url: "{{ route('member.start', ':job_id') }}".replace(':job_id', job_id),
    //                 type: "POST",
    //                 dataType: 'json',
    //                 data: {
    //                     _token: $('meta[name="csrf-token"]').attr('content'),
                        
    //                     activity_name: activity_name,
    //                     user_id_mch: user.id_mch,
    //                     user_name:user.name,
    //                     user_sub:user.sub,
    //                     job_id: job_id
    //                 },
    //                 success: function (data) {
    //                     $('#startJob').modal('hide');
    //                     $('#pesanSukses').removeClass('d-none');
        
    //                     setTimeout(function () {
    //                         $('#pesanSukses').addClass('d-none');
    //                     }, 3000);
    //                 },
    //                 error: function (errorData) {
    //                     console.log('Error:', errorData);
    //                 }
    //             });
    //         });
    //     });
    // </script> --}}

    // {{-- <script>
    //     $(document).ready(function () {
    //     // Tangani event klik pada tombol-tombol di dalam modal downtime
    //     $('#downtimeModal button').on('click', function () {
    //         var keterangan = $(this).data('keterangan'); // Ambil nilai keterangan dari tombol yang diklik
    //         var user = {!! json_encode(Auth::user()) !!}; // Ambil informasi user yang sedang login
    
    //         // Kirim form menggunakan AJAX
    //         $.ajax({
    //             url: "{{ route('downtime.submit') }}",
    //             type: "POST",
    //             data: {
    //                 _token: $('meta[name="csrf-token"]').attr('content'),
    //                 activity_name: keterangan,
    //                 user_id_mch: user.id_mch, // Menggunakan data dari user yang sedang login
    //                 user_name: user.name // Menggunakan data dari user yang sedang login
    //             },
    //             success: function (response) {
    //                 console.log(response); // Anda bisa melakukan sesuatu setelah sukses submit
    
    //                 // Tampilkan modal notifikasi
    //                 $('#notifModal').modal('show');
    //             },
    //             error: function (xhr, status, error) {
    //                 console.log(xhr.responseText); // Log pesan error jika ada
    //             }
    //         });
    //     });
    // });
    // </script> --}}


// {{-- downtime --}}
// {{-- <script>
//     $(document).ready(function () {
//         // Tangani event klik pada tombol-tombol di dalam modal downtime
//         $('#downtimeModal button').on('click', function () {
//             var idActivity = $(this).data('id-activity');
//             var keterangan = $(this).data('keterangan'); // Ambil nilai keterangan dari tombol yang diklik

//             // Setel isi modal notifikasi sesuai dengan keterangan yang dipilih
//             $('#keteranganNotifikasi').text('Saat ini sedang ' + keterangan);

//             var user = {!! json_encode(Auth::user()) !!}; // Ambil informasi user yang sedang login

//             // Kirim form menggunakan AJAX
//             $.ajax({
//                 url: "{{ route('downtime.submit') }}",
//                 type: "POST",
//                 data: {
//                     _token: $('meta[name="csrf-token"]').attr('content'),
//                     id_activity:idActivity,
//                     activity_name: keterangan,
//                     user_id_mch: user.id_mch, // Menggunakan data dari user yang sedang login
//                     user_name: user.name // Menggunakan data dari user yang sedang login
//                 },
//                 success: function (response) {
//                     console.log(response); // Anda bisa melakukan sesuatu setelah sukses submit

//                     // Tampilkan modal notifikasi
//                     $('#notifModal').modal('show');
                    
//                     // // Tangani penutupan modal notifikasi saat tombol "Selesai" ditekan
//                     $('#btnSelesai').on('click', function () {

//                         $('#notifModal').modal('hide'); // Menutup modal notifikasi
//                     });
//                 },
//                 error: function (xhr, status, error) {
//                     console.log(xhr.responseText); // Log pesan error jika ada
//                 }
//             });
//         });
//     });
// </script> --}}

// {{-- idle --}}
// {{-- <script>
//     $(document).ready(function () {
//         // Tangani event klik pada tombol-tombol di dalam modal downtime
//         $('#idleModal button').on('click', function () {
//             var idActivity = $(this).data('id-activity');
//             var keterangan = $(this).data('keterangan'); // Ambil nilai keterangan dari tombol yang diklik

//             // Setel isi modal notifikasi sesuai dengan keterangan yang dipilih
//             $('#keteranganNotifikasi').text('Saat ini sedang ' + keterangan);

//             var user = {!! json_encode(Auth::user()) !!}; // Ambil informasi user yang sedang login

//             // Kirim form menggunakan AJAX
//             $.ajax({
//                 url: "{{ route('downtime.submit') }}",
//                 type: "POST",
//                 data: {
//                     _token: $('meta[name="csrf-token"]').attr('content'),
//                     id_activity:idActivity,
//                     activity_name: keterangan,
//                     user_id_mch: user.id_mch, // Menggunakan data dari user yang sedang login
//                     user_name: user.name // Menggunakan data dari user yang sedang login
//                 },
//                 success: function (response) {
//                     console.log(response); // Anda bisa melakukan sesuatu setelah sukses submit

//                     // Tampilkan modal notifikasi
//                     $('#notifModal').modal('show');
                    
//                     // // Tangani penutupan modal notifikasi saat tombol "Selesai" ditekan
//                     $('#btnSelesai').on('click', function () {

//                         $('#notifModal').modal('hide'); // Menutup modal notifikasi
//                     });
//                 },
//                 error: function (xhr, status, error) {
//                     console.log(xhr.responseText); // Log pesan error jika ada
//                 }
//             });
//         });
//     });
// </script> --}}

//         // For Handling Job Start 
        // $('body').on('click', '.jobStart', function(e){
        //     e.preventDefault();
        //     var job_id = $(this).data('id');
        //     $.get("{{ route('member.showJob', ':id') }}".replace(':id', job_id), function(data) {
        //         $('#anForm').trigger("reset");
        //         $('#startJobModal').modal('show');
        //         $('#job_id').val(data.id);
        //         $('#project').val(data.id_mch);
        //     });
        // });

//         // $(document).on('click', '#modalAutorun button',function(e) {
        //     e.preventDefault();

        //     var activity_name = $(this).data('activity_name');
        //     var user = {!! json_encode(Auth::user()) !!};
        //     var jobId = $(this).data('id');

        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         type: "POST",
        //         url: "{{ route('member.autoRun', ':id') }}".replace(':id', jobId),
        //         data: { 
        //             _token: "{{ csrf_token() }}", 
        //             activity_name : activity_name,
        //             user_id_mch: user.id_mch,
        //             user_name: user.name
        //         }, 
        //         success: function(response) {
        //             $('#modalAutorun').modal('hide');

        //             setTimeout(function () {
        //                 updateIndexView();
        //                 startStopwatch();
        //                 startBlinkAutorun();
        //             }, 1000); 
        //             setTimeout(function () {
        //                 $('#btnJobStart strong').text('JOB AUTO RUN');
        //                 $('#btnAutoRun strong').text('RUNNING');
        //             }, 2000);
        //         },
        //         error: function(error) {
        //             console.error("Error starting job:", error.responseText);
        //         }
        //     });
        // });

        // --auto run--
        // $('.autoRun').on('click', function(e){
        //     e.preventDefault();
        //     Swal.fire({
        //         title: "Mulai Auto Run?",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Ya"
        //     }).then((result) => {
        //         if(result.isConfirmed){
        //             var id = $(this).data('id');
        //             stopBlink();
        //             stopStopwatch();
        //             $.ajax({
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 type: "POST",
        //                 url: "{{ route('member.autoRunNPK', ':id') }}".replace(':id', id),
        //                 success: function(response){
        //                     Swal.fire({
        //                         icon: "info",
        //                         title: "Auto Run Dimulai!",
        //                         showConfirmButton: false,
        //                         timer: 1500
        //                     });
        //                     setTimeout(function() {
        //                         updateIndexView();
        //                         startBlink();
        //                         startBlinkAutorun();
        //                         startStopwatch();
        //                     }, 2000);
        //                 },
        //                 error: function(error){
        //                     console.error('Error:', error);
        //                 }
        //             });
        //         }
        //     });
        // });

        // 
    // function startStopwatch() {
    //     isStopwatchRunning = true;
    //     startTime = new Date().getTime();
    //     stopwatchInterval = setInterval(function () {
    //         var currentTime = new Date().getTime();
    //         var elapsedTime = Math.floor((currentTime - startTime) / 1000); // elapsed time in seconds
    //         $("#durationTime").text(formatTime(elapsedTime));
    //     }, 1000);
    // }


//     {{-- <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
// <script src="{{ asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}


// {{-- <script src="https://unpkg.com/@popperjs/core@2"></script> --}}

// {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> --}}
// {{-- <script src="https://kit.fontawesome.com/c317e2b201.js" crossorigin="anonymous"></script> --}}
// {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"> --}}

// <!-- Custom fonts for this template-->
// {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> --}}

// <!-- Custom styles for this template-->
// {{-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
// <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
// <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
// <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css"> --}}

//     {{-- <script src="{{ asset('js/jquery.js') }}"></script>
//     <link src="{{ asset('bootstrap-4.5.3-dist/css/bootstrap.min.css') }}" rel="stylesheet"></link>
//     <script src="{{ asset('js/sweetAlert2.js') }}"></script> --}}
//     {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> --}}

// {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script> --}}
