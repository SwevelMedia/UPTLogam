@extends('layouts.template')

@push('css')
    <link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <!-- End Navbar -->
    <div class="row">
        <div class="col-md-8">

            <div class="card bt-primary mb-4">
                <div class="card-body p-3">
                    <div class="d-flex flex-column h-100">
                        <h6 class="font-weight-bolder">Proyek Siap Dikerjakan</h6>
                        <table class="table">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor
                                    Pesanan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Proyek</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Estimasi Selesai
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    Aksi
                                </th>
                            </tr>

                            @forelse ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->order_name }}</td>
                                    <td>
                                        @foreach ($order->schedule as $deadl)
                                            @if ($loop->iteration == count($order->schedule))
                                                {{ $deadl->stop_plan }}
                                            @endif
                                        @endforeach
                                    </td>

                                    <td class="text-center">
                                        <a class="text-center btn btn-primary btn-sm detail-btn my-0 px-3"
                                            href="{{ url('operator/produksi/' . $order->id) }}">
                                            <i class="fa-solid fa-circle-info fs-6"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum Ada Proyek</td>
                                </tr>
                            @endforelse
                        </table>

                        <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto"
                            href="{{ url('operator/produksi') }}">
                            Read More
                            <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                        </a>
                    </div>

                </div>
            </div>

            <div class="card bt-pink mb-4">
                <div class="card-body p-3">
                    <div class="d-flex flex-column h-100">
                        <h6 class="font-weight-bolder">Sedang Dikerjakan</h6>
                        <table class="table">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor
                                    Pesanan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                    Proyek</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Estimasi Selesai
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                    Aksi
                                </th>
                            </tr>

                            @forelse ($running as $run)
                                <tr>
                                    <td>{{ $run->order_number }}</td>
                                    <td>{{ $run->order_name }}</td>
                                    <td>
                                        @foreach ($run->schedule as $dl)
                                            @if ($loop->iteration == count($run->schedule))
                                                {{ $dl->stop_plan }}
                                            @endif
                                        @endforeach
                                    </td>

                                    <td class="text-center">
                                        <a class="text-center btn btn-primary btn-sm detail-btn my-0 px-3"
                                            href="{{ url('operator/produksi/' . $run->id) }}">
                                            <i class="fa-solid fa-arrow-right fs-6"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum Ada Proyek</td>
                                </tr>
                            @endforelse
                        </table>

                        <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto"
                            href="{{ url('operator/produksi') }}">
                            Read More
                            <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    {{-- <script>
        var ctx = document.getElementById("chart-bars").getContext("2d");

        var data = {!! json_encode($dataChart) !!};

        var labels = [];
        var itemCounts = [];

        // Loop melalui data bulan
        for (var month in data) {
            labels.push(month); // Tambahkan label bulan ke array
            itemCounts.push(data[month]); // Tambahkan jumlah item ke array
        }

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Perform",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "#f1c",
                    data: itemCounts,
                    maxBarThickness: 6
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: true,
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 15,
                            font: {
                                size: 14,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#fff"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false
                        },
                        ticks: {
                            display: true,
                            font: {
                                size: 14,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#fff"
                        },
                    },
                },
            },
        });
    </script> --}}
@endpush
