<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Perhitungan</title>
    <style>
        @page {
            size: A4;
            margin: 20mm 10mm;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .subtable {
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .subtable th, .subtable td {
            border: 1px solid #ddd;
            padding: 5px;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
            display: inline-block;
            width: 80px;
            text-align: center;
        }
        .bg-primary {
            background-color: #007bff;
            color: #fff;
        }
        .bg-danger {
            background-color: #dc3545;
            color: #f7e5e5;
        }
    </style>
</head>
<body>

    <h1>Riwayat Perhitungan</h1>
    <p>Tanggal : {{$datetime}}</p>
    <p>Event: {{ $event_name }}</p>
    
    
    <table>
        <thead>
            <tr>
                <th>Rangking</th>
                <th>Nama Pendonor</th>
                <th>Pemeriksaan</th>
                <th>Hasil Perhitungan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil as $index => $hasil)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $hasil->pendonor->user->name }}</td>
                <td>
                    <table class="subtable">
                        <thead>
                            <tr>
                                <th>Kriteria</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (json_decode($hasil->kriteria_nilai, true) as $kriteria)
                                <tr>
                                    <td>{{ $kriteria['nama'] }}</td>
                                    <td>{{ $kriteria['nilai'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td>{{ number_format($hasil->hasil, 5) }}</td>
                <td>
                    <span class="badge text-white p-2 {{ $hasil->status ? 'bg-primary' : 'bg-danger' }}">
                        {{ $hasil->status ? 'Terpilih' : 'Tidak Terpilih' }}
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
