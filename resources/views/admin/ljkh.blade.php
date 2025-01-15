@extends('layouts.app')

@section('title', 'LJKH')

@section('contents')

<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-center">
        <h1 class="text-center badge badge-dark fs-2 mt-3"><i>LEMBAR JAM KERJA HARIAN</i></h1>
    </div>
    <hr style="border-top-color:gray">
    
    <div class="text-between mb-3">
        <div class="row justify-content-center">
            <div class="col-8">
                <a href="{{ route('admin.exportLJKH') }}" class="btn btn-success"><i class="fas fa-download"></i><b>  Export</b></a>
            </div>

            {{-- Search bar --}}
            <div class="col-4">
                <form id="searchForm" action="{{ route('admin.ljkh') }}" method="GET">
                    <input type="text" id="searchInput" class="form-control" name="search" value="{{ $search }}" placeholder="Search...">
                </form>
            </div>
        </div>
    </div>

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"></button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @elseif(Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"></button>
            <strong>Error !</strong> {{ session('error') }}
        </div>
    @endif

    {{-- table LJKH --}}
    <div class="card shadow rounded">
        <div class="card-body text-dark">
            <table class="table table-sm table-hover table-striped table-bordered text-center rounded-2 overflow-hidden tableLJKH">
                <thead class="table-dark" style="height: 3em;">
                    <tr>
                        <th class="align-middle">#</th>
                        <th class="align-middle">DATE</th>
                        <th class="align-middle">NAME</th>
                        <th class="align-middle">ID MACHINING</th>
                        <th class="align-middle">ID SUB</th>
                        <th class="align-middle">ID JOB</th>
                        <th class="align-middle">WORK CENTER</th>
                        <th class="align-middle">TASK NAME</th>
                        <th class="align-middle">PRODUCTION HOUR</th>
                        <th class="align-middle">START</th>
                        <th class="align-middle">ITU</th>
                        <th class="align-middle">ACTION</th>
                    </tr>
                </thead>
        
                <tbody class="text-center">
                    @if($ljkh->count() > 0)
                        @foreach($ljkh as $l)
                            <tr>
                                <td class="align-middle">{{ $ljkh->firstItem() + $loop->index }}</td>
                                <td class="align-middle">{{ $l->Date }}</td>
                                <td class="align-middle">{{ $l->name }}</td>
                                <td class="align-middle">{{ $l->id_mch }}</td>  
                                <td class="align-middle">{{ $l->sub }}</td>  
                                <td class="align-middle">{{ $l->id_job }}</td>  
                                <td class="align-middle">{{ $l->work_ctr }}</td>  
                                <td class="align-middle">{{ $l->activity_name }}</td>  
                                <td class="align-middle">{{ $l->prod_hour }}</td>
                                <td class="align-middle">{{ substr($l->start, 0, 5) }}</td>  
                                <td class="align-middle">{{ $l->itu ?? '-' }}</td>      
                                <td class="align-middle">
                                    <div class="row ">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <a href="{{ route('admin.editLJKH', $l->id_ljkh) }}" type="button" class="btn btn-sm btn-outline-secondary"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.deleteLJKH', $l->id_ljkh) }}" method="POST" type="button" class="btn btn-danger btn-group-sm p-0" onsubmit="return confirm('Delete?')">
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
                            <td class="text-center" colspan="20">Tidak Ada Task Hari Ini</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $ljkh->links() }}
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        var alertSelector = ".alert.alert-dismissible"; 
        $(alertSelector).each(function() {
            var alert = $(this);
            setTimeout(function() {
                alert.fadeOut(500, function() {
                alert.remove(); 
                });
            }, 3000); 
        });
    });
</script>

@include('admin.importModal')
    
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