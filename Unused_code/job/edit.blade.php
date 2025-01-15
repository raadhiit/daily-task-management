@extends('layouts.app')

@section('title', 'Edit Job')

@section('contents')

<a href="{{ route('job.index') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm float-right" 
style="margin-top: 15px"><i
class="fas fa-arrow-left fa-sm text-white-50"></i>  
BACK
</a>
<h1 class="mb-0">Edit Job</h1>
<hr style="border-top-color:gray">

<div class="container-fluid">
    <form action="{{ route('job.update',$ListJob->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col">
                <span style="color:red;">*</span>PROJEK</label>
                <input type="text" class="form-control" name="project" id="project" value="{{ $ListJob->project }}">
            </div>
            <div class="col">
                <span style="color:red;">*</span>
                <label style="color:black"><strong>ID MACHINING</strong></label>
                <select class="form-control" name="id_mch" id="id_mch">
                    <option selected>{{ $ListJob->id_mch }}</option>
                    @foreach($idMchs as $idMch)
                        <option value="{{ $idMch }}">{{ $idMch }}</option>
                    @endforeach
                </select>
            </div>            
        </div>

        <div class="row mb-3">
            <div class="col">
                <span style="color:red;">*</span>
                <label style="color: black"><strong>ID JOB</strong></label>
                <input type="text" name="id_job" id="id_job" class="form-control" 
                value="{{ substr($ListJob->id_job, 0, 7) }}">
                @error('id_job')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <span style="color:red;">*</span><strong>TASK NAME</strong></label>
                <select class="form-control" name="activity_name" id="activity_name">
                    <option selected>{{ $ListJob->activity_name }}</option>
                    @foreach($taskNames as $tn)
                        <option value="{{ $tn }}">{{ $tn }}</option>
                    @endforeach
                </select>
            </div>
            
        </div>

        <div class="row mb-3">
            <div class="col">
                <span style="color: red">*</span>WORK CENTER</label>
                <select name="work_ctr" id="work_ctr" class="form-control">
                    <option value="ENDCADCAM" {{ $ListJob->work_ctr == 'ENDCADCAM' ? 'selected' : '' }}>ENDCADCAM\</option>
                    <option value="MCH-SML" {{ $ListJob->work_ctr == 'MCH-SML' ? 'selected' : '' }}>MCH-SML</option>
                    <option value="MCH-MED" {{ $ListJob->work_ctr == 'MCH-MED' ? 'selected' : '' }}>MCH-MED</option>
                    <option value="MCH-BIG" {{ $ListJob->work_ctr == 'MCH-BIG' ? 'selected' : '' }}>MCH-BIG</option>
                    <option value="PATTERN" {{ $ListJob->work_ctr == 'PATTERN' ? 'selected' : '' }}>PATTERN</option>
                </select>
            </div>
            <div class="col">
                <span style="color:red;">*</span>
                <label style="color: black"><strong>DIE PART</strong></label>
                <select class="form-control" name="die_part" id="die_part">
                    <option value="70" {{ $ListJob->die_part == '70' ? 'selected' : '' }}>Upper</option>
                    <option value="71" {{ $ListJob->die_part == '71' ? 'selected' : '' }}>Lower</option>
                    <option value="72" {{ $ListJob->die_part == '72' ? 'selected' : '' }}>Pad</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-block btn-warning">Update</button>
    </form>
</div>


@endsection