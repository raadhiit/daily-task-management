@extends('layouts.app')

@section('title','Add Task')

@section('contents')
    <a href="{{route('workstation.index')}}" class="d-none d-sm-inline-block btn btn-primary shadow-sm float-right" 
        style="margin-top: 15px"><i class="fas fa-arrow-left fa-sm text-white-50"></i>  BACK
    </a>
    <h1 class="mb-0">Add Job</h1>
    <hr style="border-top-color:gray">
    
    <form action="{{ route('workstation.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="row mb-3">
                <div class="col">
                    <span style="color:red;">*</span>ID MACHINING</label>
                    <select class="form-control" name="id_mch" id="id_mch">
                        <option selected disabled>Select ID Machining</option>
                        @foreach($idMchs as $idMch)
                            <option value="{{ $idMch }}">{{ $idMch }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <span style="color:red;">*</span>ID JOB</label>
                    <select class="form-control" name="id_job" id="id_job">
                        <option selected disabled>Select ID JOB</option>
                        @foreach($idJobs as $idJob)
                            <option value="{{ $idJob }}">{{ $idJob }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <span style="color:red;">*</span>die_part</label>
                    <select class="form-control" name="die_part" id="die_part">
                        <option value="Upper">Upper</option>
                        <option value="Lower">Lower</option>
                        <option value="Pad">Pad</option>
                    </select>
                </div>
                <div class="col">
                    <span style="color:red;">*</span>TASK NAME</label>
                    <select class="form-control" name="task_name" id="task_name">
                        <option selected disabled>Select Your Task</option>
                        @foreach($activity as $a)
                            <option value="{{ $a }}">{{ $a }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-block btn-primary">Submit</button>
    </form>
@endsection