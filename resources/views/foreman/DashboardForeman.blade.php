@extends('layouts.app')

@section('title', 'Current-Process')

@section('contents')
    <div class="container-fluid">
        <div class="container mb-4">
            <div class="row justify-content-center text-dark">
                <div class="col-md-6">
                    <h2 class="text-center"><strong>CURRENT PROCESS</strong></h2>
                    <h3 class="text-center"><strong><i>MACHINING</i></strong></h3>
                </div>
            </div>
        </div>
        <hr style="border-color: black">
        <div class="card shadow">
            <div class="card-body">
                <div class="row justify-content-center mb-3">
                    @forelse ($machines as $machine)
                        <div class="col-sm-4">
                            <div class="card border-dark mb-2">
                                <div class="card-body shadow text-center">
                                    <h3 class="card-title text-center"><strong>{{ $machine->id_mch }}</strong></h3>
                                    <hr style="border-color: black">
                                    @if ($machine->status)
                                    <h5 class="text-center">{{ $machine->id_job }}</h5>
                                    <p class="text-center" style="font-size: 18px">{{ $machine->activity_name }}</p>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4">
                                            <p class="text-center">{{ substr($machine->start, 0, 5) }}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-center">{{ $jobList->lead_time }} Jam</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-center" id="duration">00:00:00</p>
                                        </div>
                                    </div>
                                    <span class="badge badge-medium {{ $machine->status === 'In progress' ? 'badge-success' : 'badge-danger' }}" style="font-size: 16px;">
                                        <i>{{ $machine->status }}</i>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <span class="badge badge-danger text-light shadow mt-4 fs-5"><b><i>TIDAK ADA PEKERJAAN YANG SEDANG BERJALAN</i></b></span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
            startStopwatch();
        
    });

    function startStopwatch() {
        var storedStartTime = sessionStorage.getItem('startTime');
        if (storedStartTime) {
            var elapsedSeconds = Math.floor((new Date().getTime() - parseInt(storedStartTime)) / 1000);
            stopwatchInterval = setInterval(function () {
                var currentTime = new Date().getTime();
                var elapsedTime = Math.floor((currentTime - parseInt(storedStartTime)) / 1000); 
                $("#duration").text(formatTime(elapsedTime));
            }, 1000);
        } else {
            // Jika tidak ada waktu mulai yang tersimpan, mulai stopwatch dari awal
            startTime = new Date().getTime();
            sessionStorage.setItem('startTime', startTime);
            stopwatchInterval = setInterval(function () {
                var currentTime = new Date().getTime();
                var elapsedTime = Math.floor((currentTime - startTime) / 1000); 
                $("#duration").text(formatTime(elapsedTime));
            }, 1000);
        }
    }

    function formatTime(seconds) {
        var hours = Math.floor(seconds / 3600);
        var minutes = Math.floor((seconds % 3600) / 60);
        var secs = seconds % 60;
        return (
            (hours < 10 ? "0" : "") +
            hours +
            ":" +
            (minutes < 10 ? "0" : "") +
            minutes +
            ":" +
            (secs < 10 ? "0" : "") +
            secs
        );
    }
</script>
@endsection