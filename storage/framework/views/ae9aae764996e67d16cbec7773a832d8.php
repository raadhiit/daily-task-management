<style>
    .badge-medium {
        font-size: 12px;
        /* Sesuaikan dengan ukuran yang diinginkan */
        padding: 5px 10px;
        margin-top: 5px;
        /* Sesuaikan dengan padding yang diinginkan */
    }
</style>


<script>
    var isStopwatchRunning = false;
    var startTime;
    var stopwatchInterval;
    var isBlinking;
    var blinkInterval;
    var autoRunBlinkInterval = false;
    var isAlertShown = false;
    var leadTime = <?php echo json_encode($jobList->lead_time); ?>;
    var leadTimeHour = leadTime * 3600;
    var autoRun = "<?php echo e(Session::get('task_' . Session::get('id_mch'))); ?>";
    var statusJob = "<?php echo e(Session::get('status_' . Session::get('id_mch'))); ?>";

    function handleModalButtonClick(idActivity, keterangan) {
        $('#keteranganNotifikasi').text(keterangan);
        var user = <?php echo json_encode(Auth::user()); ?>;
        $.ajax({
            url: "<?php echo e(route('downtime.submit')); ?>",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id_activity: idActivity,
                activity_name: keterangan,
                user_id_mch: user.id_mch,
                user_name: user.name
            },
            success: function(response) {
                console.log(response);
                $('#notifModal').modal('show');
                $('#btnSelesai').on('click', function() {
                    $('#notifModal').modal('hide');
                    stopBlink();
                    stopBlinkAutorun();
                    stopStopwatch();
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Oppsss...",
                    text: "Terjadi kesalahan sistem!",
                    showConfirmButton: true
                });
            }
        });
    }

    function updateStopAndProdHour() {
        $.ajax({
            url: "<?php echo e(route('downtime.submitStop', ['id_ljkh' => $ljkh->id_ljkh])); ?>",
            type: "POST",
            dataType: "json",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                $('#notifModal').modal('hide');
                updateIndexView();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    function updateIndexView() {
        $.ajax({
            type: "GET",
            url: "<?php echo e(route('member.index')); ?>",
            success: function(response) {
                // Replace the content of the index view with the updated content
                $('.index-content').html($(response).find('.index-content').html());
            },
            error: function(error) {
                console.error("Error updating index view:", error.responseText);
            }
        });
    }

    function formatTime(seconds) {
        var hours = Math.floor(seconds / 3600);
        var minutes = Math.floor((seconds % 3600) / 60);
        var secs = seconds % 60;
        return (
            (hours < 10 ? "0" : "") +
            hours +
            ":" +
            (minutes < 10 ? "0" : "") +
            minutes +
            ":" +
            (secs < 10 ? "0" : "") +
            secs
        );
    }

    function startStopwatch() {
        isStopwatchRunning = true;
        // Periksa apakah ada waktu mulai stopwatch yang tersimpan dalam sessionStorage
        var storedStartTime = sessionStorage.getItem('startTime');
        if (storedStartTime) {
            var elapsedSeconds = Math.floor((new Date().getTime() - parseInt(storedStartTime)) / 1000);
            stopwatchInterval = setInterval(function() {
                var currentTime = new Date().getTime();
                var elapsedTime = Math.floor((currentTime - parseInt(storedStartTime)) / 1000);
                $("#durationTime").text(formatTime(elapsedTime));
                if (elapsedTime == (leadTimeHour - 3600)) {
                    console.log('xixixi');
                    Swal.fire({
                        icon: "warning",
                        title: "PERINGATAN!",
                        text: "Waktu pengerjaan tersisa 1 jam!",
                        showConfirmButton: true
                    });
                }
            }, 1000);
        } else {
            // Jika tidak ada waktu mulai yang tersimpan, mulai stopwatch dari awal
            startTime = new Date().getTime();
            sessionStorage.setItem('startTime', startTime);
            stopwatchInterval = setInterval(function() {
                var currentTime = new Date().getTime();
                var elapsedTime = Math.floor((currentTime - startTime) / 1000);
                $("#durationTime").text(formatTime(elapsedTime));
                if (elapsedTime == (leadTimeHour - 3600)) {
                    console.log('xixixi');
                    Swal.fire({
                        icon: "warning",
                        title: "PERINGATAN!",
                        text: "Waktu pengerjaan tersisa 1 jam!",
                        showConfirmButton: true
                    });
                }
            }, 1000);
        }
    }

    function stopStopwatch() {
        isStopwatchRunning = false;
        clearInterval(stopwatchInterval);
        sessionStorage.removeItem('startTime');
        $('#durationTime').text('00:00:00');
    }

    function breakTimer() {
        startBreak = new Date().getTime();
        breakTimeInterval = setInterval(function() {
            var now = new Date().getTime();
            var diff = Math.floor((now - startBreak) / 1000);
            $("#breakTime").text(formatTime(diff));
        }, 1000);
    }

    function startBlink() {
        blinkInterval = setInterval(function() {
            if (!autoRunBlinkInterval) {
                $('#btnJobStart strong').text('RUNNING');
                $('.jobStart').toggleClass('btn-blink');
            } else {
                $('#btnJobStart strong').text('NPK');
                $('.jobStart').toggleClass('btn-blinkAutoRun');
            }
        }, 500);
    }

    function stopBlink() {
        clearInterval(blinkInterval);
        $('.jobStart').removeClass('btn-blink');
    }

    function startBlinkAutorun() {
        if (!autoRunBlinkInterval) {
            autoRunBlinkInterval = setInterval(function() {
                setTimeout(function() {
                    $('.autoRun').toggleClass('btn-blinkAutoRun');
                    $('.jobStart').removeClass('btn-blink');
                }, 500);
            }, 500);
        }
    }

    function stopBlinkAutorun() {
        clearInterval(autoRunBlinkInterval);
        clearInterval(blinkInterval);
        $('.autoRun').removeClass('btn-blinkAutoRun');
        $('.jobStart').removeClass('btn-blinkAutoRun');
    }

    function tampilkanModal() {
        $('#autoidle').modal('show');
    }

    function setModalInterval() {
        var targetTime = new Date();
        targetTime.setHours(7, 15, 0, 0);

        var now = new Date();
        var delay = targetTime - now;

        if (delay < 0) {
            // Jika waktu target sudah lewat hari ini, atur untuk besok
            targetTime.setDate(targetTime.getDate() + 1);
            delay = targetTime - now;
        }

        setTimeout(function() {
            tampilkanModal();
            setInterval(function() {
                tampilkanModal();
            }, 24 * 60 * 60 * 1000); // Set interval setiap 24 jam
        }, delay);
    }

    function NPKNULL(id_ljkh, selectedActivity) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "<?php echo e(route('member.autoRunNPK', ':id_ljkh')); ?>".replace(':id_ljkh', id_ljkh),
            data: {
                activity_name: selectedActivity
            },
            success: function(response) {
                Swal.fire({
                    icon: "info",
                    title: "Auto Run Dimulai!",
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function() {
                    updateIndexView();
                }, 500);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    function status() {
        var id = $('#status').data('id');
        $.get("<?php echo e(route('member.showJobMember', ':id_ljkh')); ?>".replace(':id_ljkh', id), function(data) {
            var status = data.status;
            var badgeColor = "";

            if (status === "ready") {
                badgeColor = "success";
            } else if (status === "In progress") {
                badgeColor = "warning";
            } else if (status === "Idle/Downtime") {
                badgeColor = "danger";
            } else if (status === "Hold") {
                badgeColor = "secondary";
            }

            var spanElement = '<span class="badge bg-' + badgeColor + '">' + '<i>' + status + '</i>' +
                '</span>';
            $('#statusValue').html(spanElement);
            $('#status').data('status', status);
        });
    }

    function setShift() {
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var shiftValue = '';
        if ((hours === 7 && minutes >= 0) || (hours > 7 && hours < 16) || (hours === 16 && minutes < 30)) {
            shiftValue = "Pagi";
        } else if ((hours === 16 && minutes >= 30) || (hours > 16 && hours < 19) || (hours === 19 && minutes < 0) || (
                hours === 4 && minutes >= 30) || (hours > 4 && hours < 7)) {
            shiftValue = "Overtime";
        } else {
            shiftValue = "Malam";
        }
        $('#shiftValue').text(shiftValue);
    }

    function autoRunRef() {
        clearInterval(blinkInterval);
        if (autoRun === 'NPK') {
            startBlink();
            startStopwatch();
            startBlinkAutorun();
        }
    }

    function statusSession() {
        if (statusJob) {
            startBlink();
            startStopwatch();
        }
    }

    function checkNPKActivity() {
        var containsNPKInProgress = false;
        var inProgressActivities = <?php echo json_encode($ljkh->where('status', 'In progress')->pluck('activity_name')->toArray()); ?>;
        inProgressActivities.forEach(function(activity) {
            if (activity.startsWith('NPK')) {
                containsNPKInProgress = true;
            }
        });
        if (containsNPKInProgress) {
            $('.changeTask, .endTask, .jobHold, .jobEnd, .idle, .downtime, .istirahat, .shift').prop('disabled', true);
        }
    }

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#table-jobList').DataTable({
            pagingType: "simple_numbers",
            pageLength: 5,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: "<?php echo e(route('member.indexJob')); ?>",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'project.project',
                    name: 'project.project'
                },
                {
                    data: 'id_job',
                    name: 'id_job'
                },
                {
                    data: 'main_task',
                    name: 'main_task'
                },
                {
                    data: 'die_part',
                    name: 'die_part'
                },
                {
                    data: 'priority',
                    name: 'priority'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data) {
                if (data.priority === 'High') {
                    $('td:eq(5)', row).html('<span class="badge badge-danger badge-medium">' + data
                        .priority + '</span>');
                } else if (data.priority === 'Medium') {
                    $('td:eq(5)', row).html('<span class="badge badge-warning badge-medium">' + data
                        .priority + '</span>');
                } else if (data.priority === 'Low') {
                    $('td:eq(5)', row).html('<span class="badge badge-secondary badge-medium">' +
                        data.priority + '</span>');
                }
            },
            columnDefs: [{
                targets: '_all',
                className: 'align-middle'
            }]
        });

        setModalInterval();
        status();
        setShift();
        autoRunRef();
        statusSession();

        checkNPKActivity();

        // Fungsi untuk menonaktifkan tombol-tombol ketika ada perubahan pada aktivitas
        $('#btnJobStart, #btnAutoRun').click(function() {
            checkNPKActivity();
        });

        $('.idle').on('click', function(e) {
            e.preventDefault();
            $('#idleModal').modal('show');
        });

        $('.downtime').on('click', function(e) {
            e.preventDefault();
            $('#downtimeModal').modal('show');
        });

        $('#downtimeModal button').on('click', function() {
            var idActivity = $(this).data('id-activity');
            var keterangan = $(this).data('keterangan');
            handleModalButtonClick(idActivity, keterangan);
            setTimeout(function() {
                stopBlink();
                stopBlinkAutorun();
                stopStopwatch();
            }, 1000);
        });

        $('#idleModal button').on('click', function() {
            var idActivity = $(this).data('id-activity');
            var keterangan = $(this).data('keterangan');
            handleModalButtonClick(idActivity, keterangan);
            setTimeout(function() {
                stopBlink();
                stopBlinkAutorun();
                stopStopwatch();
            }, 1000);
        });

        $('#btnSelesai').on('click', function() {
            updateStopAndProdHour();
        });

        // For Handling Job start
        $("#anForm button").click(function(e) {
            e.preventDefault();
            var activity_name = $(this).data('activity_name');
            var user = <?php echo json_encode(Auth::user()); ?>;
            $.ajax({
                type: "POST",
                url: "<?php echo e(route('member.start', ['id_ljkh=> $ljkh->id_ljkh'])); ?>",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    activity_name: activity_name,
                    user_id_mch: user.id_mch,
                    user_name: user.name
                },
                success: function(response) {
                    $('#startJobModal').modal('hide');
                    setTimeout(function() {
                        Swal.fire({
                            title: "Job Dimulai!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }, 1000);
                    setTimeout(function() {
                        updateIndexView();
                    }, 2000);
                },
                error: function(error) {
                    console.error("Error starting job:", error.responseText);
                    Swal.fire('Gagal!', 'Gagal mulai pekerjaan!', 'error');
                }
            });
        });

        $('.jobStart').on('click', function(e) {
            e.preventDefault();
            $('#settingModal').modal('show');
        });

        // For Handling Job End
        $('.jobEnd').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Akhiri Pekerjaan?',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak!",
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "<?php echo e(route('member.stop', ':id_ljkh')); ?>".replace(':id_ljkh', id),
                        type: 'POST',
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Pekerjaan Berakhir!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function() {
                                updateIndexView();
                                stopBlink();
                                stopStopwatch();
                                $('#btnJobStart strong').text('JOB START');
                            }, 2000);
                        },
                        error: function(error) {
                            console.error('Error :', error);
                        }
                    });
                }
            });
        });

        // For Handling auto run
        $('.autoRun').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.get("<?php echo e(route('member.showJobMember', ':id_ljkh')); ?>".replace(':id_ljkh', id), function(data) {
                var activity_name = data['activity_name'];
                if (activity_name === null) {
                    Swal.fire({
                        title: "PILIH TASK",
                        text: "*Pilih Task Untuk Memulai Auto Run!",
                        showCancelButton: true,
                        showDenyButton: true,
                        cancelButtonText: 'Mach 3D',
                        confirmButtonText: 'Mach 2D',
                        denyButtonText: 'Miling Machine Work',
                        cancelButtonColor: '#3085d6',
                        confirmButtonColor: '#3085d6',
                        denyButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            NPKNULL(id, 'Milling Machine Work');
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            NPKNULL(id, 'Mach 2D');
                        } else if (result.isDenied) {
                            NPKNULL(id, 'Mach 3D');
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Mulai Auto Run?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya"
                    }).then((result) => {
                        stopBlink();
                        stopStopwatch();
                        if (result.isConfirmed) {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                type: "POST",
                                url: "<?php echo e(route('member.autoRunNPK', ':id_ljkh')); ?>".replace(':id_ljkh', id),
                                success: function(response) {
                                    Swal.fire({
                                        icon: "info",
                                        title: "Auto Run Dimulai!",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    setTimeout(function() {
                                        updateIndexView();
                                    }, 2000);
                                },
                                error: function(error) {
                                    console.error('Error:', error);
                                    Swal.fire('Gagal!',
                                        'Gagal ambil pekerjaan.',
                                        'error');
                                }
                            });
                        }
                    });
                }
            });
        });

        $('.EndNpk').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Masukan Waktu Berhenti",
                html: `
                <label class="text-muted" style="font-size: 12px">jika waktu berhenti tidak pada waktu reguler</label>
                <input id="stop-swal" name="stop" class="swal2-input">`,
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: "Stop Otomatis",
                confirmButtonText: "Stop Manual"
            }).then((result) => {
                var id = $(this).data('id');
                var stopInput;
                if (result.isConfirmed) {
                    stopInput = $('#stop-swal').val();
                } else {
                    stopInput = null;
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "<?php echo e(route('member.autoRunEnd', ':id_ljkh')); ?>".replace(':id_ljkh', id),
                    type: 'POST',
                    data: {
                        stop: stopInput
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Auto Run Berakhir!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        updateIndexView();
                        stopBlink();
                        stopStopwatch();
                        stopBlinkAutorun();
                    },
                    error: function(error) {
                        console.error('Error :', error);
                    }
                });
            });
        });

        // For Handling Hold Job
        $('.jobHold').on('click', function(e) {
            e.preventDefault();
            table.draw();
            var jobId = $(this).data('id');
            Swal.fire({
                title: 'Tunda Pekerjaan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "<?php echo e(route('member.hold', ':id_ljkh')); ?>".replace(':id_ljkh', jobId),
                        type: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Pekerjaan telah ditunda',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            stopBlink();
                            stopStopwatch();
                            stopBlinkAutorun();
                            setTimeout(function() {
                                updateIndexView();
                            }, 500);
                        },
                        error: function(error) {
                            console.error("Error:", error.responseText);
                            Swal.fire('Gagal!', 'Gagal Tunda pekerjaan.', 'error');
                        }
                    });
                }
            });
        });

        $('.jobList').on('click', function(e) {
            e.preventDefault();
            $('#jobListModal').modal('show');
            table.draw();
        });

        // For Handling Take Job
        $(document).on('click', '.takeJob', function(e) {
            e.preventDefault();
            var jobId = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(route('job.take', ':id_ljkh')); ?>".replace(':id_ljkh', jobId),
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    $('#jobListModal').modal('hide');
                    setTimeout(function() {
                        updateIndexView();
                    }, 500);
                    setTimeout(function() {
                        var Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        Toast.fire({
                            title: 'Pekerjaan Berhasil Diambil ',
                            icon: "success",
                            customClass: {
                                title: 'text',
                            }
                        });
                    }, 1000);
                },
                error: function(error) {
                    console.error("Error:", error.responseText);
                    Swal.fire('Gagal!', 'Gagal ambil pekerjaan.', 'error');
                }
            });
        });

        $('.btnCloseJob').on('click', function(e) {
            e.preventDefault();
            $('#jobListModal').modal('hide');
        });

        $('.changeTask').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                template: "#my-template"
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "<?php echo e(route('member.changeTask', ':id_ljkh')); ?>".replace(':id_ljkh', id),
                        method: "POST",
                        success: function(response) {
                            stopStopwatch();
                            Swal.fire({
                                icon: "success",
                                title: "Task Berhasil Diubah!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function() {
                                updateIndexView();
                                stopBlink();
                                stopStopwatch();
                            }, 500);
                        },
                        error: function(error) {
                            console.error('Error:', error);
                            Swal.fire('Gagal!', 'Gagal mengubah task.', 'error');
                        }
                    });
                }
            });
        });

        $('.endTask').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Ingin Mengakhiri Task?",
                icon: "question",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Ya",
                confirmButtonColor: "red"
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "<?php echo e(route('member.endTask', ':id_ljkh')); ?>".replace(':id_ljkh', id),
                        method: "POST",
                        success: function(response) {
                            stopStopwatch();
                            Swal.fire({
                                icon: "success",
                                title: "Task Berakhir!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function() {
                                updateIndexView();
                                stopBlink();
                                // stopStopwatch();
                            }, 500);
                        },
                        error: function(error) {
                            console.error('Error:', error);
                            Swal.fire('Gagal!', 'Gagal mengakhiri task.', 'error');
                        }
                    });
                }
            });
        });

        $('.shift').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Ingin Auto Run?",
                icon: "question",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Ya"
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    stopBlink();
                    stopStopwatch();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "<?php echo e(route('member.autoRunNPK', ':id_ljkh')); ?>".replace(':id_ljkh', id),
                        success: function(response) {
                            Swal.fire({
                                icon: "info",
                                title: "Auto Run Dimulai!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function() {
                                updateIndexView();
                            }, 2000);
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "Akhiri Shift?",
                        icon: "question",
                        input: "text",
                        inputLabel: "Masukan informasi untuk shift berikutnya",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var id = $(this).data('id');
                            var note = result.value;
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                type: "POST",
                                data: {
                                    note: note
                                },
                                url: "<?php echo e(route('member.shift', ':id_ljkh')); ?>".replace(':id_ljkh', id),
                                success: function(response) {
                                    setTimeout(function() {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Shift Berakhir!",
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }, 1000);
                                    setTimeout(function() {
                                        updateIndexView();
                                        stopBlink();
                                        stopBlinkAutorun();
                                        stopStopwatch();
                                    }, 2000);
                                }
                            });
                        }
                    });
                }
            });

        });

        $('#idleSelesai').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(route('downtime.autoIdle')); ?>",
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    $('#autoidle').modal('hide');
                    Swal.fire({
                        title: 'Idlle Berakhir',
                        icon: 'success',
                        confirmButtonText: `<i class="fa fa-thumbs-up"></i>`,
                    }).then((result) => {
                        setTimeout(function() {
                            updateIndexView();
                        }, 500);
                    });
                },
                error: function(error) {
                    console.error("Error:", error.responseText);
                    Swal.fire('Gagal!', 'Terjadi Kesalahan', 'error');
                }
            });
        });

        $('.cancel').on('click', function(e) {
            e.preventDefault();
            $('#settingModal').modal('hide');
            $('#startJobModal').modal('show');
        });

        $('.settingYes').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(route('member.setting')); ?>",
                type: "POST",
                dataType: 'JSON',
                success: function(response) {
                    $('#settingModal').modal('hide');
                    $('#notifSetting').modal('show');
                },
                error: function(error) {
                    console.error("Error:", error.responseText);
                }
            });
        });

        $('.settingSelesai').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "<?php echo e(route('member.settingDone')); ?>",
                type: "POST",
                dataType: 'JSON',
                success: function(response) {
                    $('#notifSetting').modal('hide');
                    var job_id = $this.data('id');
                    $.get("<?php echo e(route('member.showJobMember', ':id_ljkh')); ?>".replace(':id_ljkh', job_id), function(data) {
                    console.log(data);
                            $('#anForm').trigger("reset");
                            $('#startJobModal').modal('show');
                            $('#job_id').val(data.id_ljkh);
                            $('#project').val(data.id_mch);
                        });
                },
                error: function(error) {
                    console.error("Error:", error.responseText);
                }
            });
        });

        $('.istirahat').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Ingin Auto Run?",
                icon: "question",
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: "Ya"
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    stopBlink();
                    stopStopwatch();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "<?php echo e(route('member.autoRunNPK', ':id_ljkh')); ?>".replace(':id_ljkh', id),
                        success: function(response) {
                            Swal.fire({
                                icon: "info",
                                title: "Auto Run Dimulai!",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(function() {
                                updateIndexView();
                            }, 2000);
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "<?php echo e(route('member.break')); ?>",
                        type: "POST",
                        success: function(response) {
                            stopBlink();
                            stopStopwatch();
                            if (autoRunBlinkInterval) {
                                stopBlinkAutorun();
                            }
                            updateIndexView();
                            breakTimer();
                            Swal.fire({
                                icon: "info",
                                title: "Istirahat Dimulai",
                                html: `<span id="breakTime"></span>`,
                                confirmButtonText: 'Selesai',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        headers: {
                                            'X-CSRF-TOKEN': $(
                                                'meta[name="csrf-token"]'
                                            ).attr(
                                                'content')
                                        },
                                        url: "<?php echo e(route('member.breakDone')); ?>",
                                        type: "POST",
                                        success: function(
                                            response) {
                                            clearInterval(
                                                breakTimeInterval
                                            );
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Istirahat Selesai!',
                                                showConfirmButton: false,
                                                timer: 2500
                                            });
                                            setTimeout(
                                                function() {
                                                    updateIndexView
                                                        ();
                                                }, 3000);
                                        },
                                        error: function(response) {
                                            console.error(
                                                "Error:",
                                                response
                                                .responseText
                                            );
                                        }
                                    });
                                }
                            });
                        },
                        error: function(error) {
                            console.error("Error:", error.responseText);
                        }
                    });
                }
            });
        });

    });
</script>
<?php /**PATH C:\projek\resources\views/member/script.blade.php ENDPATH**/ ?>