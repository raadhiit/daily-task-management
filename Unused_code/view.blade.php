            {{-- job status --}}
            <div class="row">
                <div class="col">
                    <div class="card shadow" style="border-color:black">
                        <div class="card-body">
                            <h4 class="card-title text-center"><strong>JOB STATUS</strong></h4>
                            <hr style="border-color:black; width:10rem; margin:auto; border-width:2px;">
                            <div class="row">
                                <div class="col" >
                                    <p class="card-text text-left mt-3">ID JOB :</p>
                                    <hr style="border-color:black">
                                    <p class="card-text text-left">ID MACHINING :</p>
                                    <hr style="border-color:black">
                                    <p class="card-text text-left">DIE PART :</p>
                                    <hr style="border-color:black">
                                    <p class="card-text text-left">TASK NAME :</p>
                                </div>
                                <div class="col">
                                    @if($ljkh)
                                    <p class="card-text text-left mt-3">TIME START : {{ $ljkh->start }}</p> 
                                    <hr style="border-color:black">
                                    <p class="card-text text-left">TIME END : {{ $ljkh->stop }}</p>
                                    @else
                                    <p class="card-tect text-left mt-3">TIME START : Belom ada job yang dimulai</p>
                                    <hr style="border-color:black">
                                    <p class="card-tect text-left mt-3">TIME END : Belom ada job yang dimulai</p>
                                    @endif
                                    <hr style="border-color:black">
                                    <p class="card-text text-left">TIME TAKEN :</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                {{-- <div class="text-between mb-3">
        <div class="row">
            <div class="col-6">
                <a href="{{ route('admin.createUser') }}" class="btn btn-primary"><i class="fas fa-plus"></i>  Add User</a>
            </div>
        </div>
    </div> --}}

                {{-- <div class="row mt-3 pl-4 pb-3">
                <div class="col-sm-2">
                    <label for="startFrom" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Tahun</label>
                    <select class="form-control form-control-sm select2" id="tahun" name="tahun" aria-controls="filter_tahun" style="width: 100%">
                        @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y') - 5; $i--)
                            @if ($i == \Carbon\Carbon::now()->format('Y'))
                                <option value={{ $i }} selected="selected">{{ $i }}</option>
                            @else
                                <option value={{ $i }}>{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="endFrom" class="form-label" style="font-size: 14px;"><span
                            class="requiredIcon">*</span>Bulan</label>
                    <select class="form-control form-control-sm select2" name="bulan" id="bulan" aria-controls="filter_bulan" style="width: 100%">
                        <option value="01" @if ('01' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Januari</option>
                        <option value="02" @if ('02' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Februari</option>
                        <option value="03" @if ('03' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Maret</option>
                        <option value="04" @if ('04' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>April</option>
                        <option value="05" @if ('05' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Mei</option>
                        <option value="06" @if ('06' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juni</option>
                        <option value="07" @if ('07' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juli</option>
                        <option value="08" @if ('08' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Agustus</option>
                        <option value="09" @if ('09' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>September</option>
                        <option value="10" @if ('10' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Oktober</option>
                        <option value="11" @if ('11' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>November</option>
                        <option value="12" @if ('12' == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Desember</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="status" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Status</label>
                    <select name="status" id="status" class="custom-select custom-select-sm">
                        <option value="Complete">Complete</option>
                        <option value="In progress">In progress</option>
                        <option value="ready">ready</option>
                    </select>
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button class="btn btn-sm btn-success" id="display">Search</button>
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button class="btn btn-sm btn-primary" id="generate-pdf">Download PDF</button>
                </div>
            </div> --}}
    {{-- <script>
        $(document).ready(function() {
            var itemsPerPage = 3;
            var currentPage = 1;
            var data = @json($data);
            var totalPages = Math.ceil(Object.keys(data).length / itemsPerPage);

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

            function updateButtons() {
                $('#prev-page').prop('disabled', currentPage === 1);
                $('#next-page').prop('disabled', currentPage === totalPages);
            }

            $('#prev-page').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });

            $('#next-page').click(function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });

            function generatePDF() {
                var images = [];
                var canvasElements = document.querySelectorAll('canvas');

                canvasElements.forEach(function(canvas, index) {
                    var imgURL = canvas.toDataURL('image/png');
                    images.push(imgURL);
                });

                $.ajax({
                    url: "{{ route('download.pdf') }}",
                    type: 'POST',
                    data: {
                        images: images,
                        _token: '{{ csrf_token() }}'
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data) {
                        console.log('PDF generated successfully'); // Debugging
                        var blob = new Blob([data], {
                            type: 'application/pdf'
                        });
                        var link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = 'dashboard.pdf';
                        link.click();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error generating PDF:', error); // Debugging
                    }
                });
            }

            $('#generate-pdf').click(function() {
                generatePDF();
            });

            renderPage(currentPage);
        });

        // $('#display').click(function() {
        //     var tahun = document.getElementById("tahun").value.trim();
        //     var bulan = document.getElementById("bulan").value.trim();
        //     var status = document.getElementById("status").value.trim();

        //     var urlRedirect = "{{ route('admin.DashboardAdmin', ['param1' => 'param1', 'param2' => 'param2', 'param3' => 'param3']) }}";
        //     urlRedirect = urlRedirect.replace('param1', tahun);
        //     urlRedirect = urlRedirect.replace('param2', bulan);
        //     urlRedirect = urlRedirect.replace('param3', status);

        //     window.location.href = urlRedirect;
        // });

        $('#display').click(function() {
            var tahun = document.getElementById("tahun").value.trim();
            var bulan = document.getElementById("bulan").value.trim();
            var status = document.getElementById("status").value.trim();

            var urlRedirect = "{{ route('admin.DashboardAdmin', ['param1' => 'param1', 'param2' => 'param2', 'param3' => 'param3']) }}";
            urlRedirect = urlRedirect.replace('param1', tahun);
            urlRedirect = urlRedirect.replace('param2', bulan);
            urlRedirect = urlRedirect.replace('param3', status);

            window.location.href = urlRedirect;
        });

    </script> --}}

    {{-- <script>
        $(document).ready(function() {
            var itemsPerPage = 3;
            var currentPage = 1;
            var data = @json($data);
            var totalPages = Math.ceil(Object.keys(data).length / itemsPerPage);

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

            function updateButtons() {
                $('#prev-page').prop('disabled', currentPage === 1);
                $('#next-page').prop('disabled', currentPage === totalPages);
            }

            $('#prev-page').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });

            $('#next-page').click(function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });

            renderPage(currentPage);
        });
    </script> --}}

    {{-- <script>
        $(document).ready(function() {
            var itemsPerPage = 3;
            var currentPage = 1;
            var data = @json($data);
            var totalPages = Math.ceil(Object.keys(data).length / itemsPerPage);
    
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
    
                    // Debugging: Cek data yang dikirim ke chart
                    // console.log('Project:', project);
                    // console.log('Project Data:', projectData);
                    // console.log('Target Hour:', targetHour);
    
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
    
            function updateButtons() {
                $('#prev-page').prop('disabled', currentPage === 1);
                $('#next-page').prop('disabled', currentPage === totalPages);
            }
    
            $('#prev-page').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });
    
            $('#next-page').click(function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });
    
            renderPage(currentPage);
        });
    </script> --}}

    {{-- <div class="card shadow">
        <div class="container-fluid">
            <div class="row mt-3 pl-4">
                <div class="col-sm-2">
                    <label for="startFrom" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Start From</label>
                    <input type="date" id="startFrom" name="startFrom" class="form-control form-control-sm">
                </div>
                <div class="col-sm-2">
                    <label for="endFrom" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>End From</label>
                    <input type="date" id="endFrom" name="endFrom" class="form-control form-control-sm">
                </div>
                <div class="col-sm-2">
                    <label for="Project" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Project</label>
                    <select name="Project" id="Project" class="custom-select custom-select-sm">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="status" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Status</label>
                    <select name="status" id="status" class="custom-select custom-select-sm">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button class="btn btn-sm btn-success">Search</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row" id="project-cards">
                    <!-- Konten akan diisi oleh JavaScript -->
                </div>
                <div class="d-flex justify-content-center">
                    <button id="prev-page" class="btn btn-sm btn-primary mx-2" disabled>Previous</button>
                    <button id="next-page" class="btn btn-sm btn-primary mx-2">Next</button>
                </div>
                <hr class="my-3" style="border-color: black; height: 3px;">
                <div class="table-repsonsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-secondary text-center small">
                            <tr class="text-center">
                                <th class="align-middle" rowspan="2">PROJECT</th>
                                <th class="align-middle col-sm-1" rowspan="2">TARGET HOUR</th>
                                <th class="align-middle" colspan="4">WEEKS</th>
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
                </div>
            </div>
        </div>
        <br>
        <div class="container-fluid">
        </div>
    </div> --}}

    {{-- <div class="card shadow">
        <div class="container-fluid">
            <div class="row mt-3 pl-4">
                <!-- Form input untuk filter data -->
                <div class="col-sm-2">
                    <label for="startFrom" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Start From</label>
                    <input type="date" id="startFrom" name="startFrom" class="form-control form-control-sm">
                </div>
                <div class="col-sm-2">
                    <label for="endFrom" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>End From</label>
                    <input type="date" id="endFrom" name="endFrom" class="form-control form-control-sm">
                </div>
                <div class="col-sm-2">
                    <label for="Project" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Project</label>
                    <select name="Project" id="Project" class="custom-select custom-select-sm">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="status" class="form-label" style="font-size: 14px;"><span class="requiredIcon">*</span>Status</label>
                    <select name="status" id="status" class="custom-select custom-select-sm">
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button class="btn btn-sm btn-success">Search</button>
                </div>
                <div class="col-sm-2 d-flex align-items-end">
                    <button class="btn btn-sm btn-primary" onclick="generatePDF()">Download PDF</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row" id="project-cards"></div>
                <div class="d-flex justify-content-center">
                    <button id="prev-page" class="btn btn-sm btn-primary mx-2" disabled>Previous</button>
                    <button id="next-page" class="btn btn-sm btn-primary mx-2">Next</button>
                </div>
                <hr class="my-3" style="border-color: black; height: 3px;">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-secondary text-center small">
                            <tr class="text-center">
                                <th class="align-middle" rowspan="2">PROJECT</th>
                                <th class="align-middle col-sm-1" rowspan="2">TARGET HOUR</th>
                                <th class="align-middle" colspan="4">WEEKS</th>
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
                </div>
            </div>
        </div>
        <br>
    </div> --}}

    // $(document).ready(function() {
        //     var itemsPerPage = 3;
        //     var currentPage = 1;
        //     var totalPages;
        //     var data = @json($data);
        //     var totalPages = Math.ceil(Object.keys(data).length / itemsPerPage);
        //     renderPage(currentPage);

        //     $('#display').click(function(e) {
        //         e.preventDefault(); // Mencegah form submission default

        //         var tahun = $('#tahun').val().trim();
        //         var bulan = $('#bulan').val().trim();
        //         var status = $('#status').val().trim();

        //         $.ajax({
        //             url: "{{ route('admin.DashboardAdmin') }}",
        //             type: 'GET',
        //             data: {
        //                 param1: tahun,
        //                 param2: bulan,
        //                 param3: status
        //             },
        //             success: function(response) {
        //                 data = response.data; // Perbarui data
        //                 totalPages = Math.ceil(Object.keys(data).length / itemsPerPage);
        //                 renderPage(currentPage);
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error("Error fetching data:", status, error);
        //             }
        //         });
        //     });

        //     function renderPage(page) {
        //         $('#project-cards').empty();
        //         var start = (page - 1) * itemsPerPage;
        //         var end = start + itemsPerPage;
        //         var items = Object.keys(data).slice(start, end);

        //         $.each(items, function(index, project) {
        //             var details = data[project];
        //             var cardHtml = `
        //                 <div class="col-md-4 mb-3 project-card" data-project="${project}">
        //                     <div class="card shadow">
        //                         <div class="card-body">
        //                             <h3 class="text-center">${project}</h3>
        //                             <p class="text-center" style="font-size: 12px;">Target Hours: ${details.targetHour}</p>
        //                             <canvas id="chart-${project}"></canvas>
        //                         </div>
        //                     </div>
        //                 </div>
        //             `;
        //             $('#project-cards').append(cardHtml);
        //         });

        //         renderCharts(items);
        //         updateButtons();
        //     }

        //     function renderCharts(items) {
        //         $.each(items, function(index, project) {
        //             var details = data[project];
        //             var ctx = document.getElementById('chart-' + project).getContext('2d');
        //             var labels = ['W1', 'W2', 'W3', 'W4'];
        //             var projectData = labels.map(function(label) {
        //                 return details[label] || 0;
        //             });

        //             var targetHour = details.targetHour;

        //             new Chart(ctx, {
        //                 type: 'bar',
        //                 data: {
        //                     labels: labels,
        //                     datasets: [{
        //                         label: 'Working Hours',
        //                         data: projectData,
        //                         backgroundColor: 'rgba(75, 192, 192, 0.2)',
        //                         borderColor: 'rgba(75, 192, 192, 1)',
        //                         borderWidth: 1
        //                     }]
        //                 },
        //                 options: {
        //                     plugins: {
        //                         annotation: {
        //                             annotations: {
        //                                 line1: {
        //                                     type: 'line',
        //                                     yMin: targetHour,
        //                                     yMax: targetHour,
        //                                     borderColor: 'rgba(255, 99, 132, 0.8)',
        //                                     borderWidth: 2,
        //                                     label: {
        //                                         enabled: true,
        //                                         content: 'Target Hour',
        //                                         position: 'center',
        //                                         backgroundColor: 'rgba(255, 99, 132, 0.8)',
        //                                         color: '#fff',
        //                                     }
        //                                 }
        //                             }
        //                         },
        //                         title: {
        //                             display: true,
        //                             text: project + ' (Target: ' + targetHour + ' hours)'
        //                         }
        //                     },
        //                     scales: {
        //                         y: {
        //                             beginAtZero: true
        //                         }
        //                     }
        //                 }
        //             });
        //         });
        //     }

        //     function updateButtons() {
        //         $('#pageInfo').text('Page ' + currentPage + ' of ' + totalPages);
        //         $('#prevPage').prop('disabled', currentPage === 1);
        //         $('#nextPage').prop('disabled', currentPage === totalPages);
        //     }

        //     $('#prevPage').click(function() {
        //         if (currentPage > 1) {
        //             currentPage--;
        //             renderPage(currentPage);
        //         }
        //     });

        //     $('#nextPage').click(function() {
        //         if (currentPage < totalPages) {
        //             currentPage++;
        //             renderPage(currentPage);
        //         }
        //     });
        // });