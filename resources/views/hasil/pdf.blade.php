<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil PDF</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>

<body>
    <h1>Hasil Data</h1>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pendonor</th>
                <th>Hasil</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasil as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->hasil }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
