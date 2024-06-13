<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Perhitungan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
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
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    {{-- <td>{{ $item->created_at }}</td> --}}
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
                    <td>{{ $item->hasil }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
