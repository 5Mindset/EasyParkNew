<!DOCTYPE html>

<html>



<head>

    <meta charset="utf-8">

    <title>Riwayat Parkir</title>

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

    </style>

</head>



<body style="margin: 20px;">

    <h2 style="text-align: center; margin-bottom: 20px;">Riwayat Parkir Kendaraan Mahasiswa</h2>

    <table>

        <thead>

            <tr>

                <th>#</th>

                <th>Plat Nomor</th>

                <th>Merek</th>

                <th>Model</th>

                <th>Jenis</th>

                <th>Mahasiswa</th>

                <th>Status</th>

                <th>Masuk</th>

                <th>Keluar</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($parkingRecords as $i => $record)

                <tr>

                    <td>{{ $i + 1 }}</td>

                    <td>{{ $record->vehicle->plate_number ?? '-' }}</td>

                    <td>{{ $record->vehicle->model->vehicleBrand->name ?? '-' }}</td>

                    <td>{{ $record->vehicle->model->name ?? '-' }}</td>

                    <td>{{ $record->vehicle->model->vehicleType->name ?? '-' }}</td>

                    <td>{{ $record->vehicle->user->name ?? '-' }}</td>

                    <td style="background-color: {{ $record->status == 'parked' ? '#d4edda' : '#f8d7da' }}">

                        {{ $record->status == 'parked' ? 'Parkir' : 'Keluar' }}

                    </td>

                    <td>{{ $record->entry_time }}</td>

                    <td>{{ $record->exit_time ?? '-' }}</td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>



</html>

