<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Riwayat Parkir Kendaraan Tamu</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .status-parked {
            background-color: #d4edda; /* hijau muda */
        }

        .status-exited {
            background-color: #f8d7da; /* merah muda */
        }
    </style>
</head>

<body style="margin: 20px;">
    <h2 style="text-align: center; margin-bottom: 20px;">Riwayat Parkir Kendaraan Tamu</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Plat Nomor</th>
                <th>Nama</th>
                <th>Jenis Kendaraan</th>
                <th>Status</th>
                <th>Masuk</th>
                <th>Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guestVehicles as $i => $vehicle)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $vehicle->plate_number }}</td>
                    <td>{{ $vehicle->name }}</td>
                    <td>{{ $vehicle->vehicleType->name ?? '-' }}</td>
                    <td class="{{ $vehicle->status === 'parked' ? 'status-parked' : 'status-exited' }}">
                        {{ ucfirst($vehicle->status) }}
                    </td>
                    <td>{{ $vehicle->entry_time }}</td>
                    <td>{{ $vehicle->exit_time ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
