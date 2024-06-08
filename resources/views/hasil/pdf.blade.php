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
    </style>
</head>
<body>
    <h1>Riwayat Perhitungan</h1>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Pendonor</th>
                <th>Hasil Perhitungan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->hasil }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
