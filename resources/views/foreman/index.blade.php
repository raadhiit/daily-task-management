@extends('layouts.app')

@section('title', 'REPORT WORKSTATION')

@section('contents')

<div class="container-flex align-items-center justify-content-center text-center mb-3">
    <h1 class="mb-1">REPORT WORKSTATION</h1>
    <h4 class="mb-1">MACHINING SECTION</h4>
</div>
<hr style="border-top-color:gray">

<div class="container-fluid mb-3">
    <form action="{{ route('workstaion.showByMch') }}" method="POST">
        <div class="row mt-2 align-items-center">
            @csrf
            <div class="col-6">
                <select class="form-select" name="selected_mch" id="selected_mch" required>
                    <option value="" selected disabled>Select an ID MCH</option>
                    <!-- Populate dropdown options with available id_mch values -->
                    @foreach ($idMchs as $idMch)
                    <option value="{{ $idMch }}">{{ $idMch }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-2 mb-2 text-start">
                <button type="submit" class="btn btn-primary mt-2">Show Job List</button>
            </div>
            <div class="col-4">
                <input type="text" id="searchInput" class="form-control" name="search" value="" placeholder="Search...">
            </div>
        </div>
    </form>
</div>

@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>Success !</strong> {{ session('success') }}
    </div>
@endif

<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-primary text-center">
                <tr>
                    <th width="10px">#</th>
                    <th>ID MACHINING</th>
                    <th>ID JOB</th>
                    <th>TASK NAME</th>
                    <th>DIE PART</th>
                    <th>PART NUMBER</th>
                    <th>TIME START</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @if($WS->count() > 0 )
                    @foreach($WS as $ws)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $ws->id_mch }}</td>
                            <td class="align-middle">{{ $ws->id_job }}</td>
                            <td class="align-middle">{{ $ws->task_name }}</td>  
                            <td class="align-middle">{{ $ws->die_part }}</td>
                            <td class="align-middle">{{ $ws->part_number }}</td>
                            <td class="align-middle">{{ $ws->time_start }}</td>   
                            <td class="align-middle">
                                <div class="row mb-1">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        <a href="{{ route('workstation.edit', $ws->id) }}" type="button" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('workstation.destroy', $ws->id) }}" method="POST" type="button" class="btn btn-danger btn-group-sm p-0" onsubmit="return confirm('Delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger m-0"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="15">There's Nothing In Here</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {{-- <div class="d-flex justify-content-center">
            {{ $jobLists->links() }}
        </div> --}}
    </div>
</div>
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

