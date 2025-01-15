@extends('auth.app')

@section('title', 'Reset Password')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-5 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        Reset Password
                    </div>
                    <div class="card-body">
                        <form action="{{ route('storePass') }}" method="POST">
                            @csrf
                            <div id="resetPasswordMessage"></div>
                            <div class="form-group">
                                <label for="resetPasswordUsername">Username</label>
                                <input type="text" class="form-control" id="resetPasswordUsername" name="resetUsername" value="{{ old('resetUsername') }}">
                                @if ($errors->has('resetUsername'))
                                    <span class="text-danger">{{ $errors->first('resetUsername') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="resetPasswordPassword1">New Password</label>
                                <input type="password" class="form-control" id="resetPasswordPassword1" name="resetPassword1">
                            </div>
                            <div class="form-group">
                                <label for="resetPasswordPassword2">Confirm New Password</label>
                                <input type="password" class="form-control" id="resetPasswordPassword2" name="resetPassword2">
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                            <a href="{{ route('registerUser') }}" class="btn btn-success">Register</a>
                            <button type="submit" class="btn btn-warning">Reset Password</button>
                            <button type="reset" class="btn">Clear</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
