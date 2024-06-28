<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Order UPT LOGAM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .center {
            text-align: center;
        }

        .inner-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inner-table th,
        .inner-table td {
            padding: 4px;
            text-align: left;
        }

        .inner-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2>Laporan Data Order UPT LOGAM</h2>

    <div>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <table class="inner-table">
                        <tr>
                            <th style="width: 140px;">Nomor Pesanan</th>
                            <td>{{ $order->order_number }}</td>
                        </tr>
                        <tr>
                            <th>Material</th>
                            <td>
                                @foreach ($order->materialOrders as $materialOrder)
                                    {{ $materialOrder->material->name }}@if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Mesin</th>
                            <td>
                                @foreach ($order->machineOrders as $machineOrder)
                                    {{ $machineOrder->mesin->name }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                                @if (count($order->machineOrders) > 3)
                                    dst
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @php
                                    $statuses = [
                                        0 => 'Pending',
                                        1 => 'Need Confirm',
                                        2 => 'Scheduling',
                                        6 => 'Design',
                                        7 => 'Toolkit',
                                        8 => 'Production',
                                        9 => 'Done',
                                        10 => 'Decline',
                                    ];
                                @endphp
                                <span class="badge-custom bg-{{ $order->status <= 1 ? 'warning' : ($order->status <= 2 ? 'secondary' : ($order->status == 9 ? 'success' : 'danger')) }} me-2">
                                </span>{{ $statuses[$order->status] }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table class="inner-table">
                        <tr>
                            <th>Client</th>
                            <td>{{ $order->client->name }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $order->client->phone }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $order->client->address }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" class="center">Desc</th>
                <th rowspan="2" class="center">Nama</th>
                <th colspan="2" class="center">Start</th>
                <th colspan="2" class="center">Stop</th>
                <th rowspan="2" class="center">Keterangan</th>
            </tr>
            <tr>
                <th class="center">Plan</th>
                <th class="center">Actual</th>
                <th class="center">Plan</th>
                <th class="center">Actual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwal as $schedule)
                <tr>
                    <td>{{ $schedule->desc }}</td>
                    <td>{{ $schedule->employee->name }}</td>
                    <td>{{ $schedule->start_plan }}</td>
                    <td>{{ $schedule->start_actual ? \Carbon\Carbon::parse($schedule->start_actual)->format('d/m/Y H:i:s') : '-' }}
                    </td>
                    <td>{{ $schedule->stop_plan }}</td>
                    <td>{{ $schedule->stop_actual ? \Carbon\Carbon::parse($schedule->stop_actual)->format('d/m/Y H:i:s') : '-' }}
                    </td>
                    <td>{{ $schedule->information }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="center">Jenis Tools</th>
                <th class="center">Ukuran</th>
                <th class="center">Kode Tools</th>
                <th class="center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->toolsOrder as $tool)
                    <tr>
                        <td>{{ $tool->tools->tool_name }}</td>
                        <td>{{ $tool->tools->size }}</td>
                        <td>{{ $tool->tools->tool_code }}</td>
                        <td>{{ $tool->tools->information }}</td>
                    </tr>
                @endforeach
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="center">Tanggal</th>
                <th class="center">Shift</th>
                <th class="center">Operator</th>
                <th class="center">Mesin</th>
                <th class="center">Proses</th>
                <th class="center">Start</th>
                <th class="center">Stop</th>
                <th class="center">Waktu Mesin</th>
                <th class="center">Kendala</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->machineOrders as $mo)
                @foreach ($mo->operatorProses as $item)
                    <tr>
                        <td>{{ $item->start ? date('d-m-Y', strtotime($item->start)) : '' }}</td>
                        <td>{{ $item->shift }}</td>
                        <td>{{ $item->employee ? $item->employee->name : '' }}</td>
                        <td>{{ $item->machineOrder ? $item->machineOrder->mesin->name : '' }}</td>
                        <td>{{ $item->proses_name }}</td>
                        <td>{{ $item->start ? \Carbon\Carbon::parse($item->start)->format('d/m/Y H:i:s') : '-' }}</td>
                        <td>{{ $item->stop ? \Carbon\Carbon::parse($item->stop)->format('d/m/Y H:i:s') : '-' }}</td>
                        <td>{{ $item->formatted_waktu_mesin }}</td>
                        <td>{{ $item->problem }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="center">Desc</th>
                <th class="center">Durasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->schedule as $jadwal)
                            @if ($jadwal->desc == 'CAD' || $jadwal->desc == 'CAM')
                                @php
                                    $actual_time = '';
                                    $start = new DateTime($jadwal->start_actual);
                                    $stop = new DateTime($jadwal->stop_actual);
                                    $diff = $start->diff($stop);

                                    // Format selisih waktu ke jam, menit, detik
                                    $actual_time = $diff->format('%H:%I:%S');
                                @endphp
                                @if ($jadwal->desc == 'CAD')
                                    <tr>
                                        <td class="text-sm">CAD</td>
                                        <td>{{ $actual_time }}</td>
                                    </tr>
                                @endif
                                @if ($jadwal->desc == 'CAM' && $jadwal->stop_actual != null)
                                    <tr>
                                        <td>CAM</td>
                                        <td>{{ $actual_time }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    <tr>
                        <td>Waktu Operator</td>
                        <td>{{ $waktuOp }}</td>
                    </tr>
                    <tr>
                        <td>Waktu Mesin</td>
                        <td>{{ $waktuMesin }}</td>
                    </tr>
        </tbody>
    </table>

</body>

</html>
