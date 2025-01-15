@extends('layouts.app')

@section('title', 'REPORT-WORKSTATION')

@section('contents')
    <div class="container-flex align-items-center justify-content-center text-center mb-3">
        <h1 class="mb-0">REPORT-WORKSTATION</h1>
        <h1 class="mb-1">MACHINING SECTION</h1>
    </div>
    <hr style="border-top-color:gray">
    
    <div class="text-between mb-3">
        <div class="row">
            @if (auth()->user()->level == 2)
            <div class="col-6">
                <a href="#" class="btn btn-primary">OKUMA 1</a>
            </div>
            <div class="col-3">
                <form id="searchForm" action="#" method="GET">
                    <input type="text" id="searchInput" class="form-control" name="search" value="" placeholder="Search...">
                </form>
            </div>
            @endif
            
        </div>
    </div>

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <i class="fa fa-times"></i>
            </button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-primary text-center">
                <tr>
                    <th width="10px">#</th>
                    <th>ID MACHINING</th>
                    <th>ID JOB</th>
                    <th>TASK NAME</th>
                    <th>DIE PART</th>
                    <th>TIME START</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>  
                            <td></td>
                            <td></td>   
                            <td>
                                <div class="row mb-1">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        <a href="#" type="button" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                        <form action="#" method="POST" type="button" class="btn btn-danger btn-group-sm p-0" onsubmit="return confirm('Delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger m-0"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
                                
                            </td>
                        </tr>
            </tbody>
        </table>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                $('#searchForm').submit();
            });
        });
    </script>
@endpush
