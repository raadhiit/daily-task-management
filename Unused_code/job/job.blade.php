@extends('layouts.app')

@section('title', 'JOB LIST')

@section('contents')


<div class="container-fluid">    
    <a href="{{route('member.index')}}" class="d-none d-sm-inline-block btn btn-primary shadow-sm float-right" 
    style="margin-top: 15px"><i class="fas fa-arrow-left fa-sm text-white-50"></i>  BACK
    </a>

    <div class="container-flex align-items-center justify-content-center text-center mb-3">
        <h1 class="mb-0">JOB LIST</h1>
        <h1 class="mb-1">MACHINING SECTION</h1>
    </div>
    <hr style="border-top-color:gray">

    <div class="text-between mb-3">
        <div class="row">
            <div class="col-6">
                <form id="searchForm" action="{{ route('member.indexJob') }}" method="GET"> 
                    <input type="text" id="searchInput" class="form-control" name="search" value="{{ $search }}" placeholder="Search...">
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-primary text-center">
                <tr>
                    {{-- <th width="10px">#</th> --}}
                    <th>PROJECT</th>
                    <th>ANUMBER</th>
                    <th>ID MACHINING</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @if($jobList->count() > 0)
                @foreach($jobList as $l)
                    @if ($l->status_job === 'queued' || $l->status_job === 'ready')
                        <tr>
                            {{-- <td class="align-middle">{{ $loop->iteration }}</td> --}}
                            <td class="align-middle">{{ $l->project }}</td>
                            <td class="align-middle">{{ $l->id_job }}</td>  
                            <td class="align-middle">{{ $l->id_mch }}</td>
                            <td class="align-middle status-cell" data-status="{{ $l->status_job }}">{{ $l->status_job }}</td>
                            <td class="align-middle">
                                <div class="row mb-1">
                                    <!-- Tombol untuk ambil job -->
                                    {{-- <form action="{{ route('job.take', ['id' =>$l->id]) }}" method="POST" type="button">
                                        @csrf --}}
                                        @if($l->status_job === 'queued')
                                        <button class="btn btn-primary text-center">Ambil Job</button>
                                        @else
                                        <button class="btn btn-primary text-center" disabled>Ambil Job</button>
                                        @endif
                                    {{-- </form> --}}
                                </div
                            </td>
                        </tr>
                    @endif
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="15">There's Nothing In Here</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $jobList->links() }}
        </div>
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
