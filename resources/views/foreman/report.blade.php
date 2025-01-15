<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            padding: 10px;
        }
        body, table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .header {
            display: flex; /* Aktifkan Flexbox */
            align-items: center; /* Vertikal sejajar */
            justify-content: space-between; /* Membagi ruang antara elemen */
        }
        .logo {
            height: auto; /* Sesuaikan tinggi logo sesuai kebutuhan */
            width: 200px;
        }
        h2 {
            margin: 0; /* Hapus margin default dari <h2> */
            font-size: 24px; /* Sesuaikan ukuran font sesuai kebutuhan */
            flex: 1; /* Mengisi ruang yang tersisa */
            text-align: center; /* Tengah secara horizontal */
        }
        .info-container {
            display: flex; /* Aktifkan Flexbox */
            justify-content: space-between; /* Membagi ruang secara merata */
            margin: 20px 0; /* Jarak vertikal */
        }
        .info-container p {
            margin: 0; /* Hapus margin default dari <p> */
            padding: 0 10px; /* Jarak horizontal antar elemen */
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/FTI_logo_color_horizontal_with_member_of_Astra (1).png') }}" alt="Company Logo" class="logo">
        <h2>Monitoring Working Hour</h2>
    </div>
    <hr>
    <div class="info-container">
        <p>Tahun: {{ $tahun }}</p>
        <p>Bulan: {{ $bulan }}</p>
        <p>Status: {{ $status }}</p>
    </div>
    <table class="table table-sm">
        <thead class="table-primary">
            <tr>
                <th rowspan="2">PROJECT</th>
                <th rowspan="2">TARGET HOUR</th>
                <th colspan="4">TARGET HOUR</th>
                <th rowspan="2">TOTAL JAM</th>
                <th rowspan="2">DIBUAT</th>
                <th rowspan="2">DISETUJUI</th>
            </tr>
            <tr>
                <th>W1</th>
                <th>W2</th>
                <th>W3</th>
                <th>W4</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $project => $details)
                <tr>
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

</body>
</html>
