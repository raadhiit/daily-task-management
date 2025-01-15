

<?php $__env->startSection('title', 'HOME'); ?>

<?php $__env->startSection('member-content'); ?>

    <style>
        .btn-blink {
            background-color: #4CAF50;
            color: white;
            animation: blink 1s linear infinite;
        }

        .btn-blinkAutoRun {
            background-color: #0275d8;
            color: white;
            animation: blink 1s linear infinite;
        }

        p {
            font-size: 18px;
        }

        p strong {
            font-style: italic;
            font-size: 20px;
            text-decoration: underline;
        }

        .badge {
            vertical-align: middle;
            font-size: 18px;
        }

        #namaMesin {
            font-size: 40px;
        }
    </style>

    <div class="container-fluid">
        <div class="container d-flex justify-content-center pt-4">
            <h1 class="text-center badge badge-dark" id="namaMesin"><b><i><?php echo e($machineName); ?></i></b></h1>
        </div>
        <hr style="border-color: black">

        <div class="row">
            
            <div class="col-md-2">
                <div class="row mb-3">
                    <div class="col">
                        <div class="card shadow" style="border-color:rgb(49, 43, 43)">
                            <button id="btnJobStart"
                                class="btn btn-lg btn-light btn-block text-center py-5 jobStart btn-blink">
                                <strong>JOB START</strong>
                            </button>
                        </div>
                    </div>
                </div>
                <hr style="border-width: 2px; border-color:black">
                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-lg btn-dark text-center changeTask"
                                    data-id="<?php echo e($ljkh->id_ljkh); ?>"><b>Change Task</b></button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-lg btn-danger text-center endTask"
                                    data-id="<?php echo e($ljkh->id_ljkh); ?>"><b>End Task</b></button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border-width: 2px; border-color:black">
                <div class="row mb-4">
                    <div class="col">
                        <div class="card shadow" style="border-color: black">
                            <button href="#" class="btn btn-lg btn-light text-center py-5 jobList"
                                style="color: black" data-id="<?php echo e($ljkh->job_id); ?>">
                                <strong>JOB LIST</strong></button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                
                <?php if($ljkh->status === 'ready' || $ljkh->status === 'In progress' || $ljkh->status === 'Hold'): ?>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="card shadow" style="border-color:black">
                                <div class="card-body">
                                    <h4 class="card-title text-center"><strong>CURRENT JOB</strong></h4>
                                    <hr style="border-color:black; width:50%; margin:auto; border-width:2px;">
                                    <p class="card-text text-left mt-3">PROJECT : <strong><?php echo e($ljkh->project); ?></strong>
                                    </p>
                                    <hr style="border-color:black;">
                                    <p class="card-text text-left mt-3">ID JOB : <strong><?php echo e($ljkh->id_job); ?></strong></p>
                                    <hr style="border-color:black;">
                                    <p class="card-text text-left">ID MACHINING : <strong><?php echo e($ljkh->id_mch); ?></strong></p>
                                    <hr style="border-color:black;">
                                    <p class="card-text text-left">SHIFT : <strong id="shiftValue"></strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow" style="border-color:black; height:100%">
                                <div class="card-body ">
                                    <h4 class="card-title text-center"><strong>JOB DESC</strong></h4>
                                    <hr style="border-color:black; width:50%; margin:auto; border-width:2px;">
                                    <p class="card-text text-left mt-3">DIE PART : <strong><?php echo e($ljkh->die_part); ?></strong>
                                    </p>
                                    <hr style="border-color:black;">
                                    <p class="card-text text-left" data-id="<?php echo e($jobList->id_jobList); ?>">MAIN TASK :
                                        <strong><?php echo e($jobList->main_task); ?></strong></p>
                                    <hr style="border-color:black;">
                                    <p class="card-text text-left">TASK NAME : <strong><?php echo e($ljkh->activity_name); ?></strong>
                                    </p>
                                    <hr style="border-color:black;">
                                    <p class="card-text text-left" id="status" data-id="<?php echo e($ljkh->id_ljkh); ?>">STATUS
                                        : <strong id="statusValue" style="font-size: 20px;"></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 text-center">
                        <?php if($jobList->note): ?>
                            <div class="col-3">
                                <div class="card shadow" style="border-color:black;">
                                    <div class="card-body">
                                        <h7 class="card-title text-center"><strong>INFORMASI SHIFT</strong></h7>
                                        <hr style="border-color:black; margin:auto; width:50%; border-width:2px;">
                                        <p class="card-text text-center mt-3" style="font-size: 15px"
                                            data-id="<?php echo e($jobList->id_jobList); ?>"><?php echo e($jobList->note); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-3">
                                <div class="card shadow" style="border-color:black;">
                                    <div class="card-body">
                                        <h7 class="card-title text-center"><strong>INFORMASI SHIFT</strong></h7>
                                        <hr style="border-color:black; margin:auto; width:50%; border-width:2px;">
                                        <p class="card-text text-center mt-3" style="font-size: 15px">Tidak ada</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-3">
                            <div class="card shadow" style="border-color:black;">
                                <div class="card-body">
                                    <h7 class="card-title text-center"><strong>LEAD TIME</strong></h7>
                                    <hr style="border-color:black; margin:auto; width:50%; border-width:2px;">
                                    <p class="card-text text-center mt-3" style="font-size: 15px"
                                        data-id="<?php echo e($jobList->id_jobList); ?>"><?php echo e($jobList->lead_time); ?> Jam</p>
                                </div>
                            </div>
                        </div>
                        <?php if($ljkh->start): ?>
                            <div class="col-3">
                                <div class="card shadow" style="border-color:black;">
                                    <div class="card-body">
                                        <h7 class="card-title text-center"><strong>TIME START</strong></h7>
                                        <hr style="border-color:black; margin:auto; width:50%; border-width:2px;">
                                        <p class="card-text text-center mt-3" style="font-size: 15px">
                                            <?php echo e(substr($ljkh->start, 0, 5)); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-3">
                                <div class="card shadow" style="border-color:black;">
                                    <div class="card-body">
                                        <h7 class="card-title text-center"><strong>TIME START</strong></h7>
                                        <hr style="border-color:black; margin:auto; width:50%; border-width:2px;">
                                        <p class="card-text text-center mt-3" style="font-size: 15px">-</p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-3">
                            <div class="card shadow" style="border-color:black;">
                                <div class="card-body">
                                    <h7 class="card-title text-center"><strong>DURATION</strong></h7>
                                    <hr style="border-color:black; margin:auto; width:50%; border-width:2px;">
                                    <p id="durationTime" class="card-text text-center mt-3" style="font-size: 15px">
                                        00:00:00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="card shadow" style="border-color: black">
                                <div class="card-body">
                                    <h4 class="card-title text-center"><strong>CURRENT JOB</strong></h4>
                                    <hr style="border-color:black; margin:auto; width:50%; border-width:2px;">
                                    <p class="card-text text-center mt-3">TIDAK ADA PEKERJAAN SAAT INI</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow" style="border-color:black">
                                <div class="card-body ">
                                    <h4 class="card-title text-center"><strong>STATUS</strong></h4>
                                    <hr style="border-color:black; width:50%; margin:auto; border-width:2px;">
                                    <p class="card-text text-center mt-3">TIDAK ADA PEKERJAAN SAAT INI</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="col-md-2">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button id="btnAutoRun" class="btn btn-light btn-block text-center autoRun py-4 btn-blinkAutoRun"
                            data-id="<?php echo e($ljkh->id_ljkh); ?>" style="border-color: black; font-size: 17px;"><strong>AUTO
                                RUN</strong>
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-danger btn-block text-center py-4 EndNpk"
                            style="border-color: black; font-size: 17px;" data-id="<?php echo e($ljkh->id_ljkh); ?>">
                            <strong>END NPK</strong>
                        </button>
                    </div>
                </div>
                <hr style="border-width: 2px; border-color:black">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-warning btn-block text-center py-4 jobHold"
                                    data-id="<?php echo e($ljkh->id_ljkh); ?>" style="color: black; border-color:black">
                                    <strong>HOLD</strong>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-danger btn-block text-center py-4 jobEnd"
                                    data-id="<?php echo e($ljkh->id_ljkh); ?>" style="border-color:black">
                                    <strong>JOB END</strong>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-secondary text-center py-4 btn-block idle"
                                    style="color: white; border-color:black" data-toggle="modal"
                                    data-target="#idleModal">
                                    <strong>IDLE</strong>
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-danger btn-block text-center py-4 downtime"
                                    style="color: white; border-color:black; padding: 0;" data-toggle="modal"
                                    data-target="#downtimeModal">
                                    <strong>DOWNTIME</strong>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border-width: 2px; border-color:black">
                <div class="row mb-4">
                    <div class="btn-group">
                        <button class="btn btn-secondary text-center text-light py-3 border border-dark istirahat"
                            style="color: black;" data-id="<?php echo e($ljkh->id_ljkh); ?>">
                            <strong>ISITRAHAT</strong>
                        </button>
                        <button class="btn btn-lg btn-info text-center text-light py-3 border border-dark shift"
                            style="color: black;" data-id="<?php echo e($ljkh->id_ljkh); ?>">
                            <strong>END SHIFT</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php echo $__env->make('member.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('member.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('member.Main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\projek\resources\views/member/index.blade.php ENDPATH**/ ?>