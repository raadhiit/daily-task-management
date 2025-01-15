@extends('layouts.app')

@section('title', 'Tambah-User')

@section('contents')
    <a href="{{route('admin.indexUser')}}" class="d-none d-sm-inline-block btn btn-primary shadow-sm float-right" 
        style="margin-top: 15px"><i class="fas fa-arrow-left fa-sm text-white-50"></i>  BACK
    </a>

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class=" col-lg-6 col-md-8 col-sm-10">
                <div class="card o-hidden border-0 shadow-lg my-3 mx-auto">
                    <div class="card-body d-flex justify-content-center">
                        <!-- Nested Row within Card Body -->
                        <div class="row text-center">
                            <div class="col-lg ">
                                <div class="p-2">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create User!</h1>
                                </div>
                                <form action="{{ route('admin.storeUser') }}" method="POST" class="user">
                                    @csrf
                                    <div class="form-group">
                                        <input name="name" type="text" class="form-control form-control-user @error('name')is-invalid @enderror" id="exampleInputName" placeholder="Name">
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="id_mch" type="text" class="form-control form-control-user @error('id_mch')is-invalid @enderror" id="exampleInputid_mch" placeholder="ID MACHINING">
                                        @error('id_mch')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="sub" type="text" class="form-control form-control-user @error('sub')is-invalid @enderror" id="exampleInputSub" placeholder="SUB">
                                        @error('sub')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="level" type="text" class="form-control form-control-user @error('level')is-invalid @enderror" id="exampleInputLevel" placeholder="Status">
                                        @error('level')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input name="NPK" type="NPK" class="form-control form-control-user @error('NPK')is-invalid @enderror" id="exampleInputNPK" placeholder="NPK Anda">
                                        @error('NPK')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input name="password" type="password" class="form-control form-control-user @error('password')is-invalid @enderror" id="exampleInputPassword" placeholder="Password">
                                            @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6">
                                            <input name="password_confirmation" type="password" class="form-control form-control-user @error('password_confirmation')is-invalid @enderror" id="exampleRepeatPassword" placeholder="Repeat Password">
                                            @error('password_confirmation')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Add User</button>
                                </form>
                                <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection