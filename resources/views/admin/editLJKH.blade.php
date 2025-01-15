@extends('layouts.app')

@section('title', 'Edit-LJKH')

@section('contents')
    <div class="container-fluid">
        <a href="{{ route('admin.ljkh') }}" class="d-none d-sm-inline-block btn btn-primary shadow-sm float-right"
            style="margin-top: 15px">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i>BACK
        </a>
        <h1 class="mb-0 mt-4">Edit LJKH</h1>
        <hr style="border-top-color:gray">

        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        <div class="card shadow rounded">
            <div class="card-body">
                <form action="{{ route('admin.updateLJKH', $ljkh->id_ljkh) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-1">
                        <div class="col">
                            <span style="color: red">*</span>
                            <label style="color: black"><strong>PROJECT</strong></label>
                            <input class="form-control" type="text" name="project" id="project"
                                value="{{ $ljkh->project }}">
                        </div>
                        <div class="col">
                            <span style="color:red;">*</span>
                            <label style="color:black"><strong>ID MACHINING</strong></label>
                            <select class="form-control" name="id_mch" id="id_mch">
                                <option selected>{{ $ljkh->id_mch }}</option>
                                @foreach ($idMchs as $idMch)
                                    <option value="{{ $idMch }}">{{ $idMch }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col">
                            <span style="color:red;">*</span>
                            <label style="color: black"><strong>ID JOB</strong></label>
                            <input type="text" name="id_job" id="id_job" class="form-control"
                                value="{{ substr($ljkh->id_job, 0, 7) }}">
                            @error('id_job')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <span style="color:red;">*</span>
                            <label style="color: black"><strong>TASK NAME</strong></label>
                            <select class="form-control" name="activity_name" id="activity_name">
                                <option selected>{{ $ljkh->activity_name }}</option>
                                @foreach ($taskNames as $TN)
                                    <option value="{{ $TN }}">{{ $TN }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col">
                            <span style="color:red;">*</span>
                            <label style="color: black"><strong>DIE PART</strong></label>
                            <input type="text" class="form-control" name="die_part" id="die_part"
                                value="{{ $ljkh->die_part }}">
                        </div>
                        <div class="col">
                            <span style="color:red;">*</span>
                            <label style="color: black"><strong>ITU</strong></label>
                            <select class="form-control" name="itu" id="itu">
                                <option selected>{{ $ljkh->itu }}</option>
                                <option value="AT01">AT01</option>
                                <option value="AT02">AT02</option>
                                <option value="AT03">AT03</option>
                                <option value="AT04">AT04</option>
                                <option value="AT07">AT07</option>
                                <option value="AU01">AU01</option>
                                <option value="AU03">AU03</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-block btn-warning mt-5">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
