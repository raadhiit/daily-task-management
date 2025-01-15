@extends('layouts.app')

@section('title', 'IMPORT')

@section('contents')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Import Data</div>

                <div class="card-body">
                    <form action="{{ route('job.importJob') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Choose CSV File:</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".csv">
                        </div>
                        <button type="submit" class="btn btn-primary">Import Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
