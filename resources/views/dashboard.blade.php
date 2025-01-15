@extends('layouts.app')

@section('title', 'Dashboard')

@section('contents')
<style>
    .card{
        border-radius: 10px
    }
</style>
<div class="container-fluid">
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center"><strong><i>DASHBOARD MACHINING</i></strong></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mb-3 justify-content-center">
            @foreach($machines as $machineId)
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center"><strong>OKUMA {{ $machineId }}</strong></h5>
                            <hr style="border-color: black">
                            @php
                                $proses = $currentProcesses[$machineId];
                            @endphp
                            @if($proses)
                            <p class="text-center">{{ $proses->id_job }}</p>
                            <p class="text-center">{{ $proses->task_name }}</p>
                            <p class="text-center">{{ $proses->die_part }}</p>
                                <a href="#" class="btn btn-block btn-primary">Detail</a>
                            @else
                                <p class="text-center">Tidak ada job saat ini</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    {{-- <div class="container">
        <div class="row justify-content-center">
            @foreach($currentProcesses as $machineId=>$proses)
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center"><strong>OKUMA 1 ({{ $machineId }})</strong></h5>
                        <hr style="border-color: black">
                        @if($proses)
                        <p class="text-center">{{ $proses->id_job }}</p>
                        <p class="text-center">{{ $proses->task_name }}</p>
                        <a href="" class="btn btn-block btn-primary">detail</a>
                        @else
                        <p class="text-center">Tidak Ada Job Saat Ini</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center"><strong>OKUMA 2</strong></h5>
                        <hr style="border-color: black">
                        <p class="text-center"></p>
                        <p class="text-center"></p>
                        <a href="" class="btn btn-block btn-primary"></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center"><strong>OKUMA 3</strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center"><strong>MPF</strong></h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center"><strong>KURAKI</strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center"><strong>KAOMING I</strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center"><strong>KAOMING II</strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center"><strong>SETTING</strong></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center"><strong>VOM</strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center"><strong>HOWA</strong></h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center"><strong>OKUMA 4</strong></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}


</body>
</html>
@endsection