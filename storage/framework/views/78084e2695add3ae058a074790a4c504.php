

<?php $__env->startSection('title', 'Validasi Job'); ?>

<?php $__env->startSection('contents'); ?>

<div class="container-fluid">

    <div class="container-flex align-items-center justify-content-center text-center mb-3">
        <h1 class="mb-0">SCHEDULING</h1>
        <h6 class="mb-1"><i>MACHINING SECTION</i></h6>
    </div>
    <hr style="border-top-color: gray">
    <div id="validationSuccessMessage" class="alert alert-success d-none">
        <p><strong>Success!</strong> | Job berhasil divalidasi.</p>
    </div>  

    <div class="row" style="font-size: 12px;">
        <div class="col-4">
            <div class="row">
                <div class="col">
                    <div class="card shadow rounded">
                        <div class="card-header shadow bg-warning">
                            <h6 class="text-center mt-2"><b>NOT YET VALIDATED</b></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered text-center" id="table-validasi" style="width: 98%">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-1 text-center">NO</th>
                                            <th class="col-sm-2 text-center">ANUMBER</th>
                                            <th class="col-sm-2 text-center">STATUS</th>
                                            <th class="col-md-1 text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card shadow rounded">
                <div class="card-header shadow bg-success">
                    <h6 class="text-center text-light mt-2"><b>VALIDATED</b></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="table-validated" style="width: 98%">
                            <thead>
                                <tr class="align-middle">
                                    <th class="col-sm-1 text-center">NO</th>
                                    <th class="col-sm-1 text-center">PROJECT</th>
                                    <th class="col-sm-1 text-center">ANUMBER</th>
                                    <th class="col-sm-2 text-center">ID MACHINING</th>
                                    <th class="col-sm-2 text-center">MAIN TASK</th>
                                    <th class="col-sm-2 text-center">LEAD TIME</th>
                                    <th class="col-sm-2 text-center">TARGET HOUR</th>
                                    <th class="col-sm-2 text-center">DIE PART</th>
                                    <th class="col-sm-1 text-center">PRIORITY</th>
                                    <th class="col-sm-1 text-center">ACTION</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="validasiModal" tabindex="-1" role="dialog" aria-labelledby="validasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header shadow d-flex justify-content-center bg-primary">
                <h5 class="heading text-center text-light mt-2" id="validasiModalLabel" style="color: black; font-size:25px"><strong>VALIDASI JOB</strong></h5>
            </div>
            <div class="modal-body">
                <form id="validasiForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="project_id" id="project_id">
                    <div id="validationErrorMessage" class="alert alert-danger d-none" style="font-size: 15px">
                        <p>Job belum bisa divalidasi, Lengkapi semua kebutuhan terlebih dahulu!.</p>
                    </div>                                      
                    <div class="mb-4 row">
                        <div class="col-sm-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="text-center"><b>PROJECT</b></h5>
                                    <hr style="border-color: black; border-width:1px">
                                    <input type="text" class="form-control-plaintext text-center text-dark" id="project" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="text-center"><b>ANUMBER</b></h5>
                                    <hr style="border-color: black; border-width:1px">
                                    <input type="text" class="form-control-plaintext text-center text-dark" id="id_job" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="text-center"><b>PART NAME</b></h5>
                                    <hr style="border-color: black; border-width:1px">
                                    <input type="text" class="form-control-plaintext text-center text-dark" id="part_name"
                                    style="overflow-y: auto;" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <div class="col-sm-3">
                            <p class="form-label text-center text-dark"><b>DIE PART</b></p>
                            <input type="text" class="form-control text-center" name='die_part' id="die_part" placeholder="Masukan Die Part" required>
                        </div>
                        <div class="col-sm-3">
                            <p class="form-label text-center text-dark"><b>LEAD TIME</b></p>
                            <input type="text" class="form-control text-center" name='lead_time' id="lead_time" placeholder="Masukan Lead Time" required>
                        </div>
                        <div class="col-sm-3">
                            <p class="form-label text-center text-dark"><b>WORKSTATION</b></p>
                            <select class="custom-select" id="id_mch" name="id_mch">
                                <option selected disabled class="text-center">Pilih Mesin</option>
                                <?php $__currentLoopData = $idMchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idMch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($idMch); ?>"><?php echo e($idMch); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <p class="form-label text-center text-dark"><b>MAIN TASK</b></p>
                            <select class="custom-select" id="main_task" name="main_task">
                                <option selected disabled class="text-center">Pilih Main Task</option>
                                <option value="Mach-1">Machining 1</option>
                                <option value="Mach-2">Machining 2</option>
                                <option value="Mach-Surface-Top">Machining Surface Top</option>
                                <option value="Mach-Surface-Bottom">Machining Surface Bottom</option>
                                <option value="Pref-1">Prefiting 1</option>
                                <option value="Pref-2">Prefiting 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group text-center mt-3">
                        <label><b>Wajib Di Centang:</b></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="ncSheet" name="options[]" value="ncSheet">
                            <label class="form-check-label" for="ncSheet">NC SHEET/GAMBAR</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="casting" name="options[]" value="casting">
                            <label class="form-check-label" for="casting">CASTING</label>
                        </div>
                    </div>
                    <div class="row mt-2 justify-content-center">
                        <div class="col-6">
                            <button type="submit" class="btn btn-block btn-primary" id="btnValidasi">Validasi</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-block btn-outline-secondary waves-effect" id="closeBtnValidasi" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalChangeMainTask" tabindex="-1" role="dialog" aria-labelledby="modalChangeMainTaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header shadow d-flex justify-content-center">
                <h5 class="heading text-center text-dark mt-2" style="color: black; font-size:25px"><strong>CHANGE MAIN TASK</strong></h5>
            </div>
            <div class="modal-body">
                <form id="changeMainTaskForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="project_id" id="project_id">
                    <div class="mb-4 row">
                        <div class="col-sm-6">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="text-center"><b>PROJECT</b></h5>
                                    <hr style="border-color: black; border-width:1px">
                                    <input type="text" class="form-control-plaintext text-center text-dark" id="project1" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="text-center"><b>ANUMBER</b></h5>
                                    <hr style="border-color: black; border-width:1px">
                                    <input type="text" class="form-control-plaintext text-center text-dark" id="id_job1" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 d-flex justify-content-center">
                        <div class="col">
                            <p class="form-label text-center text-dark"><b>MAIN TASK</b></p>
                            <select class="custom-select" id="main_task" name="main_task">
                                <option selected disabled class="text-center">Pilih Main Task</option>
                                <option value="Mach-1">Machining 1</option>
                                <option value="Mach-2">Machining 2</option>
                                <option value="Pref-1">Prefiting 1</option>
                                <option value="Pref-2">Prefiting 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2 mb-2 justify-content-center">
                        <div class="col-6">
                            <button type="submit" class="btn btn-block btn-primary" id="btnMainTask">UBAH</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-block btn-outline-secondary waves-effect" id="closeBtnMainTask" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('foreman.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\projek\resources\views/foreman/validasi.blade.php ENDPATH**/ ?>