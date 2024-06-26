<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Perhitungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
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
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Riwayat Perhitungan</h1>
    
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
            @foreach ($hasil as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->pendonor->user->name }}</td>
                    <td>
                        <table class="subtable">
                            <thead>
                                <tr>
                                    <th>Kriteria</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->pendonor->pemeriksaan as $pemeriksaan)
                                    <tr>
                                        <td>{{ $pemeriksaan->kriteria->nama }}</td>
                                        <td>{{ $pemeriksaan->nilai }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td>{{ number_format($item->hasil, 5) }}</td>
                    <td>
                        <span class="badge {{ $item->status ? 'bg-primary' : 'bg-danger' }}">
                            {{ $item->status ? 'Terpilih' : 'Tidak Terpilih' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
