@extends('layouts.template')

@push('css')
@endpush

@section('content')
    <!-- End Navbar -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Mesin</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $totalCount }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fa fa-cog text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Ready</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $readyCount }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fa fa-check text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Break Schedule</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $breakdownscheduleCount }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fa fa-wrench text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Break Unschedule</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $breakdownunscheduleCount }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fa fa-times text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mt-3">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Standby Request</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ $standbyrequestCount }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center bmachine-radius-md">
                                <i class="fa fa-cogs text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mt-4">
            <div class="card h-100 p-3 bt-pink">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bolder pt-1 mb-2">Mesin Ready </h5>
                    <div class="pagination pagination-sm justify-content-end">
                        <nav aria-label="Page navigation example">
                        </nav>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div id="machine-table" class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kode Mesin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Mesin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ready as $rd)
                                    <tr>
                                        <td>{{ $rd->machine_code }}</td>
                                        <td>{{ $rd->name }}</td>
                                        <td>
                                            <span class="badge-custom bg-success me-2"></span>ready
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-4">
            <div class="card h-100 p-3 bt-pink">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bolder pt-1 mb-2">Mesin Breakdown Schedule </h5>
                    <div class="pagination pagination-sm justify-content-end">
                        <nav aria-label="Page navigation example">
                        </nav>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div id="machine-table" class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kode Mesin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Mesin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($breakdownschedule as $bk)
                                    <tr>
                                        <td>{{ $bk->machine_code }}</td>
                                        <td>{{ $bk->name }}</td>
                                        <td>
                                            @if ($bk->status == 11)
                                                <span class="badge-custom bg-warning me-2"></span>Breakdown Schedule
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-4">
            <div class="card h-100 p-3 bt-pink">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bolder pt-1 mb-2">Mesin Breakdown Unschedule </h5>
                    <div class="pagination pagination-sm justify-content-end">
                        <nav aria-label="Page navigation example">
                        </nav>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div id="machine-table" class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kode Mesin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Mesin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($breakdownunschedule as $bu)
                                    <tr>
                                        <td>{{ $bu->machine_code }}</td>
                                        <td>{{ $bu->name }}</td>
                                        <td>
                                            @if ($bu->status == 12)
                                                <span class="badge-custom bg-primary me-2"></span>Breakdown Unschedule
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mt-4">
            <div class="card h-100 p-3 bt-pink">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bolder pt-1 mb-2">Mesin Standby Request </h5>
                    <div class="pagination pagination-sm justify-content-end">
                        <nav aria-label="Page navigation example">
                        </nav>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div id="machine-table" class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kode Mesin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Mesin</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($standbyrequest as $sr)
                                    <tr>
                                        <td>{{ $sr->machine_code }}</td>
                                        <td>{{ $sr->name }}</td>
                                        <td>
                                            @if ($sr->status == 13)
                                                <span class="badge-custom bg-info me-2"></span>Standby Request
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('js')
    <script src="../assets/js/plugins/chartjs.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById("chart-bars");
            if (ctx) {
                ctx = ctx.getContext("2d");
                new Chart(ctx, {
                    type: "bar",
                    data: {
                        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                            label: "Sales",
                            tension: 0.4,
                            borderWidth: 0,
                            borderRadius: 4,
                            borderSkipped: false,
                            backgroundColor: "#fff",
                            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
                            maxBarThickness: 6
                        }],
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
                                    drawTicks: false,
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
                                    display: false
                                },
                            },
                        },
                    },
                });
            }

            var ctx2 = document.getElementById("chart-line");
            if (ctx2) {
                ctx2 = ctx2.getContext("2d");

                var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

                gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
                gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

                var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

                gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
                gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
                gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

                new Chart(ctx2, {
                    type: "line",
                    data: {
                        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                                label: "Mobile apps",
                                tension: 0.4,
                                borderWidth: 0,
                                pointRadius: 0,
                                borderColor: "#cb0c9f",
                                borderWidth: 3,
                                backgroundColor: gradientStroke1,
                                fill: true,
                                data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                                maxBarThickness: 6

                            },
                            {
                                label: "Websites",
                                tension: 0.4,
                                borderWidth: 0,
                                pointRadius: 0,
                                borderColor: "#3A416F",
                                borderWidth: 3,
                                backgroundColor: gradientStroke2,
                                fill: true,
                                data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
                                maxBarThickness: 6
                            },
                        ],
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
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    padding: 10,
                                    color: '#b2b9bf',
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    color: '#b2b9bf',
                                    padding: 20,
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                        },
                    }
                });
            }
        });
    </script>
@endpush
