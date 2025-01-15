<!-- Modal Downtime -->
<div class="modal fade" id="downtimeModal" tabindex="-1" role="dialog" aria-labelledby="downtimeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header shadow d-flex justify-content-center bg-danger">
                <h5 class="modal-title text-light"><strong>DOWNTIME</strong></h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-danger text-center py-2" data-dismiss="modal" data-id-activity="G000001" data-keterangan="CRANE TROUBLE">Crane Trouble</button>
                            <button type="button" class="btn btn-outline-danger text-center py-2" data-dismiss="modal" data-id-activity="G000002" data-keterangan="MACHINE TROUBLE">Machine Trouble</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-danger text-center py-2" data-dismiss="modal" data-id-activity="G000003" data-keterangan="TOOL TROUBLE">Tool Trouble</button>
                            <button type="button" class="btn btn-outline-danger text-center py-2" data-dismiss="modal" data-id-activity="G000004" data-keterangan="PROGRAM TROUBLE">Program Trouble</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-danger text-center py-2" data-dismiss="modal" data-id-activity="G000005" data-keterangan="SUPPORT SUBCONTRACT">Support Subcontract</button>
                            <button type="button" class="btn btn-outline-danger text-center py-2" data-dismiss="modal" data-id-activity="G000006" data-keterangan="PROJECT PREPERATION">Project Preparation</button>
                            <button type="button" class="btn btn-outline-danger text-center py-2" data-dismiss="modal" data-id-activity="G000007" data-keterangan="DESIGN & LAIN-LAIN">Design & lain-lain</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal idle --}}
<div class="modal fade" id="idleModal" tabindex="-1" role="dialog" aria-labelledby="idleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header shadow d-flex justify-content-center bg-secondary">
                <h5 class="modal-title text-light"><strong>IDLE</strong></h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-2" data-dismiss="modal" data-id-activity="N000001" data-keterangan="MEETING">Meeting</button>
                            <button type="button" class="btn btn-outline-secondary py-2" data-dismiss="modal" data-id-activity="N000002" data-keterangan="TRAINING">Training</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-2" data-dismiss="modal" data-id-activity="N000004" data-keterangan="5S(Cleaning Area)">5S(Cleaning Area)</button>
                            <button type="button" class="btn btn-outline-secondary py-2" data-dismiss="modal" data-id-activity="N000006" data-keterangan="MANAGEMMENT WORK">Management Work</button>
                            <button type="button" class="btn btn-outline-secondary py-2" data-dismiss="modal" data-id-activity="N000007" data-keterangan="TECHNICAL SUPPORT">Technical Support</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary py-2" data-dismiss="modal" data-id-activity="N000003" data-keterangan="SS">SS</button>
                            <button type="button" class="btn btn-outline-secondary py-2" data-dismiss="modal" data-id-activity="N000003" data-keterangan="QCC">QCC</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Notifikasi -->
<div class="modal fade" id="notifModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="notifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <i class="fa-solid fa-bell fa-3x fa-beat mt-3 mb-4 text-dark"></i>
                <strong><p style="font-size: 25px" class="text-center text-danger" id="keteranganNotifikasi"></p></strong>
            </div>
            <div class="container-fluid">
                <div class="row mb-3 justify-content-center">
                    <div class="col">
                        <button type="submit" class="btn btn-block btn-outline-dark" id="btnSelesai">Selesai</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Start Job -->
<div class="modal fade" id="startJobModal" tabindex="-1" role="dialog" aria-labelledby="startJobModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header shadow d-flex justify-content-center bg-info">
                <h4 class="modal-title text-light" id="taskName"><strong>PILIH TASK</strong></h4>
            </div>
            <div class="modal-body">
                {{-- mch --}}
                @if(Auth()->user()->sub === 'MCH')
                <form id="anForm">
                    @csrf
                    <input type="hidden" name="job_id" id="job_id">

                    <div class="row justify-content-center mb-3">
                        <div class="row">
                            <div class="col">
                                <div class="card" style="border-color: rgb(209, 209, 209)">
                                    <label for="project" class="form-label text-center mt-2" style="font-size: 22px; color:black">PROJECT</label>
                                    <p class="text-center">{{ $ljkh->project }}</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card" style="border-color: rgb(209, 209, 209)">
                                    <label for="Anumber" class="form-label text-center mt-2" style="font-size: 22px; color:black">ANUMBER</label>
                                    <p class="text-center">{{ $ljkh->id_job }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="row mb-3">
                            <div class="col-6">
                                <button type="button" class="btn btn-block btn-outline-info waves-effect" data-dismiss="modal" data-activity_name="BOBOK">BOBOK</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-block btn-outline-info waves-effect" data-dismiss="modal" data-activity_name="Milling Machine Work">Milling Machine Work</button>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <button type="button" class="btn btn-block btn-outline-info" data-dismiss="modal" data-activity_name="Mach 2D">Mach 2D</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-block btn-outline-info" data-dismiss="modal" data-activity_name="Mach 3D">Mach 3D</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-block btn-outline-info" data-dismiss="modal" data-activity_name="Bubut & Grinding">Bubut & Grinding</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-block btn-outline-info" data-dismiss="modal" data-activity_name="NIGASHI">NIGASHI</button>
                            </div>
                        </div>
                    </div>
                    @else
                    {{-- pref --}}
                    <div class="row justify-content-center">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-lg btn-block btn-outline-info" data-dismiss="modal" data-activity_name="Drill">Drill</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-lg btn-block btn-outline-info" data-dismiss="modal" data-activity_name="Setting">Setting</button>
                            </div>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan Job List -->
<div class="modal fade" id="jobListModal" tabindex="-1" role="dialog" aria-labelledby="jobListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content text-center">
            <div class="modal-header shadow justify-content-center bg-info">
                <h1 class="modal-title text-light" id="jobListModalLabel"><strong>JOB LIST</strong></h1>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover text-center" id="table-jobList" style="width: 100%">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center align-middle">NO</th>
                                <th class="text-center align-middle">PROJECT</th>
                                <th class="text-center align-middle">ANUMBER</th>
                                <th class="text-center align-middle">MAIN TASK</th>
                                <th class="text-center align-middle">DIE PART</th>
                                <th class="text-center align-middle">PRIORITY</th>
                                <th class="text-center align-middle">ACTION</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnCloseJob" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- auto idle --}}
<div class="modal fade" id="autoidle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="autoidleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <!--Content-->
        <div class="modal-content text-center">
            <!--Header-->
            <div class="modal-header d-flex justify-content-center">
                <h3 class="modal-title" style="color: black"><b>IDLE TIME!</b></h3>
            </div>
            <!--Body-->
            <div class="modal-body">
                <i class="fa-regular fa-clock fa-5x fa-beat-fade my-3" style="color:darkorange"></i>
            </div>
            <!--Footer-->
            <div class="modal-footer flex-center">
                <a type="button" class="btn btn-block btn-dark" data-dismiss="modal" id="idleSelesai">Selesai</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>

{{-- modal setting --}}
<div class="modal-box">
    <!-- Modal -->
    <div class="modal fade" id="settingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-body">
                    <h3 class="title">hold up!</h3>
                    <div class="modal-icon mb-3">
                        <i class="fas fa-hand fa-beat fa-1x"></i>
                    </div>
                    <p class="description">Ingin Melakukan Setting?</p>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-block btn-dark settingYes">YA</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-block btn-outline-secondary waves-effect cancel" data-dismiss="modal">TIDAK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- notif setting --}}
<div class="modal fade" id="notifSetting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="notifSettingLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header shadow d-flex justify-content-center bg-warning">
                <h4 class="modal-title" style="color: black"><strong>PREP TIME!</strong></h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid text-center">
                    <label for="project" class="form-label text-center mt-2" style="font-size: 22px; color:black">ANUMBER</label>
                    <p class="text-center">{{ $ljkh->id_job }}</p>
                </div>
                <div class="container text-center">
                    <i class="fas fa-gear fa-spin fa-4x my-2"></i>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="btn btn-block btn-outline-warning waves-effect settingSelesai" data-id="{{ $ljkh->id_ljkh }}">Selesai</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- change task --}}
<template id="my-template">
    <swal-title>
        ingin mengubah task?
    </swal-title>
    <swal-icon type="warning" color="blue"></swal-icon>
    <swal-button type="confirm">
        Ya
    </swal-button>
    <swal-button type="cancel">
        Tidak
    </swal-button>
    <swal-param name="allowEscapeKey" value="true" />
</template>