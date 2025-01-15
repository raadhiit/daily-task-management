@extends('layouts.app')

@section('title', 'Edit-User')

@section('contents')

    <div class="container-fluid">

        <a href="{{ route('admin.indexUser') }}" class="btn btn-outline-primary waves-effect shadow-sm float-left">
            <i class="fas fa-arrow-left mt-1"></i>
        </a>

        <div class="container-fluid mt-4">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    <strong>Success !</strong> {{ session('success') }}
                </div>
            @elseif (Session::has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="fa fa-times"></i>
                    </button>
                    <strong>Error !</strong> {{ session('error') }}
                </div>
            @endif
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-10 col-sm-4">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.updateUser', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="card shadow-lg my-5 mx-auto">
                            <div class="card-header shadow-sm bg-info">
                                <h2 class="text-center text-light"><strong>EDIT USER</strong></h2>
                            </div>
                            <div class="card-body bg-light">
                                <div class="row  my-2">
                                    <div class="col form-group">
                                        <label class="labels"><strong>NAME</strong></label>
                                        <input type="text" name="name" class="form-control" placeholder="Name"
                                            value="{{ $user->name }}">
                                    </div>
                                    <div class="col form-group">
                                        <label class="labels"><strong>NPK</strong></label>
                                        <input type="text" name="NPK" class="form-control" placeholder="NPK"
                                            value="{{ $user->NPK }}">
                                    </div>
                                </div>
                                <div class="row justify-content-center my-2">
                                    <div class="col-md-6 form-group">
                                        <label class="labels"><strong>PASSWORD</strong></label>
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="labels"><strong>STATUS</strong></label>
                                        <input type="text" name="level" class="form-control"
                                            value="{{ $user->level }}">
                                    </div>
                                </div>
                                <div class="row justify-content-center my-2">
                                    <div class="col-md-6 form-group">
                                        <label class="labels"><strong>ID MACHINING</strong></label>
                                        <input type="text" name="id_mch" class="form-control"
                                            value="{{ $user->id_mch }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="labels"><strong>SUB</strong></label>
                                        <input type="text" name="sub" class="form-control"
                                            value="{{ $user->sub }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center bg-light">
                                <button id="btn" class="btn btn-block btn-outline-dark waves-effect"
                                    type="submit">Save Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
