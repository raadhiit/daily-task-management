@extends('layouts.app')

@section('title', 'DASHBOARD')

@section('contents')
    <style>
        .requiredIcon {
            color: red;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center text-dark"><strong><i>DASHBOARD MACHINING</i></strong></h2>
        </div>
    </div>
    <hr style="border-color: black">

    <div class="card shadow">
        <div class="container-fluid">
            <div class="row mt-3 pl-4 pb-3">
                <div class="col-sm-2">
                    <label for="startFrom" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Tahun</label>
                    <select class="form-control form-control-sm select2" id="tahun" name="tahun" aria-controls="filter_tahun" style="width: 100%">
                        @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y') - 5; $i--)
                            <option value="{{ $i }}" @if ($i == $selectedYear) selected="selected" @endif>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="endFrom" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Bulan</label>
                    <select class="form-control form-control-sm select2" name="bulan" id="bulan" aria-controls="filter_bulan" style="width: 100%">
                        @foreach (range(1, 12) as $month)
                            @php $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT); @endphp
                            <option value="{{ $monthFormatted }}" @if ($monthFormatted == $selectedMonth) selected="selected" @endif>
                                {{ \Carbon\Carbon::createFromFormat('m', $monthFormatted)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="status" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Status</label>
                    <select name="status" id="status" class="custom-select custom-select-sm">
                        <option value="Complete" @if ($selectedStatus == 'Complete') selected="selected" @endif>Complete</option>
                        <option value="In progress" @if ($selectedStatus == 'In progress') selected="selected" @endif>In progress</option>
                        <option value="ready" @if ($selectedStatus == 'ready') selected="selected" @endif>ready</option>
                    </select>
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button class="btn btn-sm btn-success" id="display">Display</button>
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button class="btn btn-sm btn-primary" id="generate-pdf">Download PDF</button>
                </div>
            </div>
            
            <hr class="my-3" style="border-color: black; height: 3px;">
            <div class="card-body">
                <div class="row" id="project-cards">
                    <!-- Konten akan diisi oleh JavaScript -->
                </div>
                <div class="d-flex justify-content-center">
                    <button id="prev-page" class="btn btn-sm btn-primary mx-2" disabled>Previous</button>
                    <button id="next-page" class="btn btn-sm btn-primary mx-2">Next</button>
                </div>
                <hr class="my-3" style="border-color: black; height: 3px;">

                {{-- <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-secondary text-center small">
                            <tr class="text-center">
                                <th class="align-middle" rowspan="2">PROJECT</th>
                                <th class="align-middle col-sm-1" rowspan="2">TARGET HOUR</th>
                                <th class="align-middle" colspan="4">WEEKS</th>
                                <th class="align-middle" rowspan="2">TOTAL HOURS</th>
                                <th class="align-middle" rowspan="2">DIBUAT</th>
                                <th class="align-middle" rowspan="2">DISETUJUI</th>
                            </tr>
                            <tr class="text-center">
                                <th>W1</th>
                                <th>W2</th>
                                <th>W3</th>
                                <th>W4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $project => $details)
                                <tr class="text-center">
                                    <td>{{ $project }}</td>
                                    <td>{{ $details['targetHour'] }}</td>
                                    <td>{{ $details['W1'] }}</td>
                                    <td>{{ $details['W2'] }}</td>
                                    <td>{{ $details['W3'] }}</td>
                                    <td>{{ $details['W4'] }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> --}}

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-secondary text-center small">
                            <tr class="text-center">
                                <th class="align-middle" rowspan="2">PROJECT</th>
                                <th class="align-middle col-sm-1" rowspan="2">TARGET HOUR</th>
                                <th class="align-middle" colspan="4">WEEKS</th>
                                <th class="align-middle col-sm-2" rowspan="2">TOTAL HOURS</th>
                                <th class="align-middle" rowspan="2">DIBUAT</th>
                                <th class="align-middle" rowspan="2">DISETUJUI</th>
                            </tr>
                            <tr class="text-center">
                                <th>W1</th>
                                <th>W2</th>
                                <th>W3</th>
                                <th>W4</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $project => $details)
                                <tr class="text-center">
                                    <td>{{ $project }}</td>
                                    <td>{{ $details['targetHour'] }}</td>
                                    <td>{{ $details['W1'] }}</td>
                                    <td>{{ $details['W2'] }}</td>
                                    <td>{{ $details['W3'] }}</td>
                                    <td>{{ $details['W4'] }}</td>
                                    <td>{{ $details['totalHours'] }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                
            </div>
        </div>
        <br>
    </div>

    <script>
        $(document).ready(function() {
            var itemsPerPage = 3;
            var currentPage = 1;
            var data = @json($data);
            var totalPages = Math.ceil(Object.keys(data).length / itemsPerPage);
            renderPage(currentPage);

            $('#display').click(function(e) {
                e.preventDefault();

                var tahun = $('#tahun').val().trim();
                var bulan = $('#bulan').val().trim();
                var status = $('#status').val().trim();

                $.ajax({
                    url: "{{ route('admin.DashboardAdmin') }}",
                    type: 'GET',
                    data: {
                        param1: tahun,
                        param2: bulan,
                        param3: status
                    },
                    success: function(response) {
                        data = response.data;
                        totalPages = Math.ceil(Object.keys(data).length / itemsPerPage);
                        currentPage = 1;
                        renderPage(currentPage);
                        updateTable();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", status, error);
                    }
                });
            });

            function renderPage(page) {
                $('#project-cards').empty();
                var start = (page - 1) * itemsPerPage;
                var end = start + itemsPerPage;
                var items = Object.keys(data).slice(start, end);

                $.each(items, function(index, project) {
                    var details = data[project];
                    var cardHtml = `
                        <div class="col-md-4 mb-3 project-card" data-project="${project}">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h3 class="text-center">${project}</h3>
                                    <p class="text-center" style="font-size: 12px;">Target Hours: ${details.targetHour}</p>
                                    <canvas id="chart-${project}"></canvas>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#project-cards').append(cardHtml);
                });

                renderCharts(items);
                updateButtons();
            }

            function renderCharts(items) {
                $.each(items, function(index, project) {
                    var details = data[project];
                    var ctx = document.getElementById('chart-' + project).getContext('2d');
                    var labels = ['W1', 'W2', 'W3', 'W4'];
                    var projectData = labels.map(function(label) {
                        return details[label] || 0;
                    });

                    var targetHour = details.targetHour;

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Working Hours',
                                data: projectData,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                annotation: {
                                    annotations: {
                                        line1: {
                                            type: 'line',
                                            yMin: targetHour,
                                            yMax: targetHour,
                                            borderColor: 'rgba(255, 99, 132, 0.8)',
                                            borderWidth: 2,
                                            label: {
                                                enabled: true,
                                                content: 'Target Hour',
                                                position: 'center',
                                                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                                                color: '#fff',
                                            }
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: project + ' (Target: ' + targetHour + ' hours)'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            }

            function updateTable() {
                var tableBody = $('table tbody');
                tableBody.empty();

                $.each(data, function(project, details) {
                    var rowHtml = `
                        <tr class="text-center">
                            <td>${project}</td>
                            <td>${details.targetHour}</td>
                            <td>${details.W1}</td>
                            <td>${details.W2}</td>
                            <td>${details.W3}</td>
                            <td>${details.W4}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    `;
                    tableBody.append(rowHtml);
                });
            }

            function updateButtons() {
                $('#pageInfo').text('Page ' + currentPage + ' of ' + totalPages);
                $('#prevPage').prop('disabled', currentPage === 1);
                $('#nextPage').prop('disabled', currentPage === totalPages);
            }

            $('#prevPage').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });

            $('#nextPage').click(function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });

            $('#generate-pdf').click(function(e) {
                e.preventDefault();

                var tahun = $('#tahun').val().trim();
                var bulan = $('#bulan').val().trim();
                var status = $('#status').val().trim();

                window.location.href = "{{ route('download.pdf') }}" + "?param1=" + tahun + "&param2=" + bulan + "&param3=" + status;
            });
        });
    </script>
@endsection
