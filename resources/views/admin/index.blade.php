@extends('layouts.app')

@section('title', 'Input Job/Anumber')

@section('contents')

<div class="container-fluid">
    <div class="container-flex align-items-center justify-content-center text-center mb-3">
        <h1 class="mb-0">PROJECT LIST</h1>
        <h5 class="mb-1"><i>MACHINING SECTION</i></h5>
    </div>

    <hr style="border-top-color: gray">

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"></button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"></button>
            <strong>Error !</strong> {{ session('error') }}
        </div>
    @endif

{{-- ini index tablenya --}}
    <div class="card shadow rounded">
        <div class="card-body text-dark">
            <div class="text-right mb-2">
                <button type="button" class="btn btn-primary" id="addProject">
                    <i class="fas fa-plus"></i> ADD
                </button>
                <button class="btn btn-danger importProject" id="importProject">
                    <i class="fas fa-upload"></i> IMPORT
                </button>
            </div>
            {{-- <div class="table-responsive">
                <table class="table table-sm table-bordered text-center" id="table-index">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="col-sm-1 text-center">NO</th>
                            <th scope="col" class="text-center">PROJECT</th>
                            <th scope="col" class="text-center">START DATE</th>
                            <th scope="col" class="text-center">DUE DATE</th>
                            <th scope="col" class="text-center">PART NAME</th>
                            <th scope="col" class="text-center">PART NUMBER</th>
                            <th scope="col" class="text-center">ANUMBER</th>
                            <th class="text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php
                            $previousProjectName = null;
                            $rowspan = 0;
                            $currentRow = 0;
                            $currentNo = 1; // Inisialisasi nomor urut
                        @endphp
                
                        @forelse($projects as $p)
                            @if ($previousProjectName !== $p->project)
                                @php
                                    // Hitung jumlah baris untuk project yang sama
                                    $rowspan = $projects->filter(function ($item) use ($p) {
                                        return $item->project === $p->project;
                                    })->count();
                                    $currentRow = 0; // Reset currentRow untuk project baru
                                @endphp
                            @endif
                
                            @if ($currentRow === 0)
                                <tr style="font-size: 14px;">
                                    <td class="align-middle" rowspan="{{ $rowspan }}">{{ $currentNo }}</td>
                                    <td class="align-middle" rowspan="{{ $rowspan }}">{{ $p->project }}</td>
                                    <td class="align-middle" rowspan="{{ $rowspan }}">{{ $p->part_name }}</td>
                                    <td class="align-middle" rowspan="{{ $rowspan }}">{{ $p->part_no }}</td>
                                    <td class="align-middle">{{ $p->anumber }}</td>
                                    <td>
                                        <button class="btn btn-outline-danger deleteProject" data-id="{{ $p->id_project }}"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @else
                                <tr style="font-size: 14px;">
                                    <td class="align-middle">{{ $p->anumber }}</td>
                                    <td>
                                        <button class="btn btn-outline-danger deleteProject" data-id="{{ $p->id_project }}"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @endif
                
                            @php
                                $previousProjectName = $p->project;
                                $currentRow++;
                                // Update nomor urut hanya pada baris pertama setiap project
                                if ($currentRow === 1) {
                                    $currentNo++;
                                }
                            @endphp
                        @empty
                            <tr>
                                <td class="text-center" colspan="6">Tidak Ada Project Baru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <div class="d-flex justify-content-center">
                    {{ $projects->links() }}
                </div>
            </div> --}}
            <div class="table-responsive">
                <table class="table table-sm table-bordered text-center" id="table-index">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="col-sm-1 text-center">NO</th>
                            <th scope="col" class="text-center">PROJECT</th>
                            <th scope="col" class="text-center">START DATE</th>
                            <th scope="col" class="text-center">DUE DATE</th>
                            <th scope="col" class="text-center">PART NAME</th>
                            <th scope="col" class="text-center">PART NUMBER</th>
                            <th scope="col" class="text-center">ANUMBER</th>
                            <th class="text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php
                            $previousProjectName = null;
                            $rowspan = 0;
                            $currentNo = 1; // Inisialisasi nomor urut
                        @endphp
                    
                        @forelse($projects as $p)
                            @if ($previousProjectName !== $p->project)
                                @php
                                    // Hitung jumlah baris untuk project yang sama
                                    $rowspan = $projects->filter(function ($item) use ($p) {
                                        return $item->project === $p->project;
                                    })->count();
                                @endphp
                            @endif
                    
                            @if ($previousProjectName !== $p->project)
                                <tr style="font-size: 14px;">
                                    <td class="align-middle" rowspan="{{ $rowspan }}">{{ $currentNo }}</td>
                                    <td class="align-middle" rowspan="{{ $rowspan }}">{{ $p->project }}</td>
                                    <td class="align-middle" rowspan="{{ $rowspan }}">{{ $p->Start_date }}</td>
                                    <td class="align-middle" rowspan="{{ $rowspan }}">{{ $p->Due_date }}</td>
                                    <td class="align-middle" rowspan="{{ $rowspan }}">{{ $p->part_name }}</td>
                                    <td class="align-middle" rowspan="{{ $rowspan }}">{{ $p->part_no }}</td>
                                    <td class="align-middle">{{ $p->anumber }}</td>
                                    <td>
                                        <button class="btn btn-outline-danger deleteProject" data-id="{{ $p->id_project }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @php $currentNo++; @endphp
                            @else
                                <tr style="font-size: 14px;">
                                    <td class="align-middle">{{ $p->anumber }}</td>
                                    <td>
                                        <button class="btn btn-outline-danger deleteProject" data-id="{{ $p->id_project }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                    
                            @php $previousProjectName = $p->project; @endphp
                        @empty
                            <tr>
                                <td class="text-center" colspan="8">Tidak Ada Project Baru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            
                <div class="d-flex justify-content-center">
                    {{ $projects->links() }}
                </div>
            </div>
            
        </div>
    </div>
</div>

{{-- modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 200%">
        <div class="modal-content">
            <div class="modal-header shadow bg-dark justify-content-center">
                <h3 class="modal-title text-light" id="exampleModalLabel"><strong></strong></h3>
            </div>
            <div class="modal-body">
                <!-- START FORM -->
                <form id="projectForm" name="projectForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="project_id" id="project_id">
                    <div class="mb-3 row">
                        <div class="col-sm-3">
                            <p for="project" class="form-label text-center text-dark"><b>Project</b></p>
                            <input type="text" class="form-control text-center" name='project' id="project">
                        </div>
                        <div class="col-sm-3">
                            <p for="part_name" class="form-label text-center text-dark"><b>Part-Name</b></p>
                            <input type="text" class="form-control text-center" name='part_name' id="part_name">
                        </div>
                        <div class="col-sm-3">
                            <p for="part_no" class="form-label text-center text-dark"><b>Part-Number</b></p>
                            <input type="text" class="form-control text-center" name='part_no' id="part_no">
                        </div>
                        <div class="col-sm-3">
                            <p for="anumber" class="form-label text-center text-dark"><b>Anumber</b></p>
                            <input type="text" class="form-control text-center" name='anumber' id="Anumber" onkeyup="checkAndFixAnumber()">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-sm-3">
                            <p for="startDate" class="form-label text-center text-dark"><b>Start Date</b></p>
                            <input type="date" class="form-control text-center" name='startDate' id="startDate">
                        </div>
                        <div class="col-sm-3">
                            <p for="dueDate" class="form-label text-center text-dark"><b>Due Date</b></p>
                            <input type="date" class="form-control text-center" name='dueDate' id="dueDate">
                        </div>
                        <div class="col-sm-2">
                            <p for="targetHour" class="form-label text-center text-dark"><b>Target Hour</b></p>
                            <input type="text" class="form-control text-center" name='targetHour' id="targetHour">
                        </div>
                    </div>
                </form>
                <!-- Akhir Form -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary tombol-update">Update</button>
                <button type="submit" class="btn btn-outline-primary tombol-simpan">Simpan</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

{{-- modal import project --}}
<div class="modal fade" id="modalImportProject" tabindex="-1" role="dialog" aria-labelledby="modalImportProjectLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header shadow bg-dark justify-content-center">
                <h3 class="modal-title text-center text-light" id="modalTitleId"><b>Import Project</b></h3>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form action="project.importProject" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Choose CSV File:</label>
                                <input type="file" class="form-control" id="fileProject" name="fileProject" accept=".csv">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary waves-effect" id="submitProject">Import Data</button>
                <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

@include('admin.script')

@endsection
