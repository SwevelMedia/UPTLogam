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
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Pesanan Baru</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $order->thisMonth() }}
                                @if ($order->percentage() > 0)
                                <span
                                    class="text-success text-sm font-weight-bolder">+{{ $order->percentage() }}%</span>
                                @else
                                <span class="text-danger text-sm font-weight-bolder">{{ $order->percentage() }}%</span>
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
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
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pesanan</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $order->amount() }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-collection text-lg opacity-10" aria-hidden="true"></i>
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
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Client Baru</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $client->thisMonth() }}
                                @if ($client->percentage() > 0)
                                <span
                                    class="text-success text-sm font-weight-bolder">+{{ $client->percentage() }}%</span>
                                @else
                                <span class="text-danger text-sm font-weight-bolder">{{ $client->percentage() }}%</span>
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-circle-08 text-lg opacity-10" aria-hidden="true"></i>
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
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Client</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $client->amount() }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                            <i class="ni ni-badge text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card z-index-2">
            <div class="card-header pb-0">
                <h6>Grafik Pesanan</h6>
                <p class="text-sm">
                    @if ($order->percentage() > 0)
                    <i class="fa fa-arrow-up text-success"></i>
                    @else
                    <i class="fa fa-arrow-down text-danger"></i>
                    @endif
                    <span class="font-weight-bold">{{ $order->percentage() }}% lebih @if ($order->percentage() > 0)
                        banyak
                        @else
                        sedikit
                        @endif </span> dari bulan sebelumnya
                </p>
            </div>
            <div class="card-body p-3">
                <div class="chart">
                    <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row my-4">
    <div class="col-lg-8 col-md-6 mb-md-0 mb-4 ">
        <div class="card pt-4" style="min-height: 100%">
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Capaian Proyek</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-check text-info" aria-hidden="true"></i>
                            <span class="font-weight-bold ms-1">{{ count($order->finish()) }} Selesai</span> bulan ini
                        </p>
                    </div>
                    <div class="col-lg-6 col-5 my-auto text-end">
                        <div class="dropdown float-lg-end pe-4">
                            <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa fa-ellipsis-v text-secondary"></i>
                            </a>
                            <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Another
                                        action</a></li>
                                <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else
                                        here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div id="order-table" class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Client</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Pesanan</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Tanggal Pemesanan</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Penyelesaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $page = request()->get('page', 1); // Dapatkan nomor halaman saat ini dari URL
                            $perPage = $order->orders()->perPage(); // Dapatkan jumlah item per halaman
                            $offset = ($page - 1) * $perPage; // Hitung offset untuk nomor urut
                            @endphp
                            @foreach ($order->orders() as $key => $item)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1 ms-2">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $key + 1 + $offset }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1 ms-2">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $item->client->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{ $item->order_name }}
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-xs font-weight-bold">
                                        {{ $item->updated_at->format('Y-m-d') }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <div class="progress-wrapper w-75 mx-auto">
                                        <div class="progress-info">
                                            <div class="progress-percentage">
                                                <span class="text-xs font-weight-bold">
                                                    @if ($item->status == 0)
                                                    <span class="me-2 text-xs">0%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 0%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 1)
                                                    <span class="me-2 text-xs">5%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 5%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 2)
                                                    <span class="me-2 text-xs">10%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                aria-valuenow="10" aria-valuemin="0" aria-valuemax="40"
                                                                style="width: 10%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 3)
                                                    <span class="me-2 text-xs">20%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 20%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 4)
                                                    <span class="me-2 text-xs">30%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"
                                                                style="width:30%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 5)
                                                    <span class="me-2 text-xs">40%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 40%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 6)
                                                    <span class="me-2 text-xs">50%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 50%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 7)
                                                    <span class="me-2 text-xs">60%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 60%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 8)
                                                    <span class="me-2 text-xs">70%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 70%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 9)
                                                    <span class="me-2 text-xs">100%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                aria-valuenow="100" aria-valuemin="0"
                                                                aria-valuemax="100" style="width: 100%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 10)
                                                    <span class="me-2 text-xs">ditolak</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-danger" role="progressbar"
                                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                                                style="width: 100%;"></div>
                                                        </div>
                                                    </div>
                                                    @elseif($item->status == 9)
                                                    <span class="me-2 text-xs">100%</span>
                                                    <div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                aria-valuenow="100" aria-valuemin="0"
                                                                aria-valuemax="100" style="width: 100%;"></div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Letakkan tombol pagination di bagian bawah tabel -->
                    <div class="pagination justify-content-center mt-4">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item {{ $order->orders()->previousPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $order->orders()->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $order->orders()->lastPage(); $i++)
                                    <li class="page-item {{ $order->orders()->currentPage() == $i ? 'active' : '' }}">
                                        @if ($order->orders()->currentPage() == $i)
                                        <span class="page-link">{{ $i }}</span>
                                        @else
                                        <a class="page-link" href="{{ $order->orders()->url($i) }}">{{ $i }}</a>
                                        @endif
                                    </li>
                                    @endfor
                                    <li class="page-item {{ $order->orders()->nextPageUrl() ? '' : 'disabled' }}">
                                        <a class="page-link next" href="{{ $order->orders()->nextPageUrl() }}"
                                            aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card h-100">
            <div class="card-header pb-0">
                <h6>Ringkasan Pemesanan</h6>
                <p class="text-sm">
                    @if ($order->percentage() > 0)
                    <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                    @else
                    <i class="fa fa-arrow-down text-danger" aria-hidden="true"></i>
                    @endif
                    <span class="font-weight-bold">
                        {{ $order->percentage() }}%
                    </span> Bulan ini
                </p>
            </div>
            <div class="card-body p-3">
                <div class="timeline timeline-one-side">
                    <div class="timeline-block mb-3">
                        <span class="timeline-step">
                            <i class="ni ni-check-bold text-success text-gradient"></i>
                        </span>
                        <div class="timeline-content">
                            <h6 class="text-dark text-sm font-weight-bold mb-0"><span
                                    class="text-pink">{{ count($order->finish()) }}</span> Selesai</h6>
                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                {{ optional($order->finish()->last())->updated_at ? $order->finish()->last()->updated_at->format('j M g:i A') : '0 MON 0:00 MM' }}
                            </p>
                        </div>
                    </div>
                    <div class="timeline-block mb-3">
                        <span class="timeline-step">
                            <i class="ni ni-box-2 text-info text-gradient"></i>
                        </span>
                        <div class="timeline-content">
                            <h6 class="text-dark text-sm font-weight-bold mb-0"><span
                                    class="text-pink">{{ count($order->operator()) }}</span> Produksi</h6>
                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                {{ optional($order->operator()->last())->updated_at ? $order->operator()->last()->updated_at->format('j M g:i A') : '0 MON 0:00 MM' }}
                            </p>
                        </div>
                    </div>
                    <div class="timeline-block mb-3">
                        <span class="timeline-step">
                            <i class="ni ni-settings text-info text-gradient"></i>
                        </span>
                        <div class="timeline-content">
                            <h6 class="text-dark text-sm font-weight-bold mb-0"><span
                                    class="text-pink">{{ count($order->toolman()) }}</span> Penyiapan Alat</h6>
                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                {{ optional($order->toolman()->last())->updated_at ? $order->toolman()->last()->updated_at->format('j M g:i A') : '0 MON 0:00 MM' }}
                            </p>
                        </div>
                    </div>
                    <div class="timeline-block mb-3">
                        <span class="timeline-step">
                            <i class="ni ni-album-2 text-info text-gradient"></i>
                        </span>
                        <div class="timeline-content">
                            <h6 class="text-dark text-sm font-weight-bold mb-0"><span
                                    class="text-pink">{{ count($order->programmer()) }}</span> Programmer</h6>
                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                {{ optional($order->programmer()->last())->updated_at ? $order->programmer()->last()->updated_at->format('j M g:i A') : '0 MON 0:00 MM' }}
                            </p>
                        </div>
                    </div>
                    <div class="timeline-block mb-3">
                        <span class="timeline-step">
                            <i class="ni ni-image text-warning text-gradient"></i>
                        </span>
                        <div class="timeline-content">
                            <h6 class="text-dark text-sm font-weight-bold mb-0"><span
                                    class="text-pink">{{ count($order->drafter()) }}</span> Drafter
                            </h6>
                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                {{ optional($order->drafter()->last())->updated_at ? $order->drafter()->last()->updated_at->format('j M g:i A') : '0 MON 0:00 MM' }}
                            </p>
                        </div>
                    </div>
                    <div class="timeline-block mb-3">
                        <span class="timeline-step">
                            <i class="ni ni-calendar-grid-58 text-warning text-gradient"></i>
                        </span>
                        <div class="timeline-content">
                            <h6 class="text-dark text-sm font-weight-bold mb-0"><span
                                    class="text-pink">{{ count($order->accept()) }}</span> Pesanan Diterima
                            </h6>
                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                {{ optional($order->accept()->last())->updated_at ? $order->accept()->last()->updated_at->format('j M g:i A') : '0 MON 0:00 MM' }}
                            </p>
                        </div>
                    </div>
                    <div class="timeline-block">
                        <span class="timeline-step">
                            <i class="ni ni-email-83 text-primary text-gradient"></i>
                        </span>
                        <div class="timeline-content">
                            <h6 class="text-dark text-sm font-weight-bold mb-0"><span
                                    class="text-pink">{{ count($order->new()) }}</span> Pesanan Baru</h6>
                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                {{ optional($order->new()->last())->updated_at ? $order->new()->last()->updated_at->format('j M g:i A') : '0 MON 0:00 MM' }}
                            </p>
                        </div>

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
var ctx2 = document.getElementById("chart-line").getContext("2d");

var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)');

// Dapatkan data bulan dan jumlah item dari controller
var data = {
    !!json_encode($order - > monthly()) !!
};


// Buat array untuk menyimpan label bulan
var labels = [];
// Buat array untuk menyimpan jumlah item per bulan
var itemCounts = [];

// Loop melalui data bulan
for (var month in data) {
    labels.push(month); // Tambahkan label bulan ke array
    itemCounts.push(data[month].length); // Tambahkan jumlah item ke array
}

new Chart(ctx2, {
    type: "line",
    data: {
        labels: labels, // Gunakan label bulan dari data
        datasets: [{
            label: "Pesanan",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#cb0c9f",
            borderWidth: 3,
            backgroundColor: gradientStroke1,
            fill: true,
            data: itemCounts, // Gunakan jumlah item per bulan dari data
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
    },
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on('click', '.pagination a.page-link', function(e) {
        e.preventDefault();

        var url = $(this).attr('href');
        var currentPage = $('.pagination .active .page-link')
            .text(); // Mendapatkan nomor halaman saat ini
        var targetPage = $(this).text(); // Mendapatkan nomor halaman target
        var direction = currentPage < targetPage ? 'left' : 'right';
        if (!/\d/.test(targetPage)) {
            if (targetPage.includes("Next")) {
                direction = 'left';
            } else {
                direction = 'right';
            }
        }

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (direction === 'right') {
                    $('#order-table').animate({
                        marginLeft: '100%',
                        opacity: 0
                    }, 200, function() {
                        $('#order-table').html($(response).find('#order-table')
                            .html()).css({
                            marginLeft: '-100%'
                        }).animate({
                            marginLeft: 0,
                            opacity: 1
                        }, 200);
                    });
                } else {
                    $('#order-table').animate({
                        marginLeft: '-100%',
                        opacity: 0
                    }, 200, function() {
                        $('#order-table').html($(response).find('#order-table')
                            .html()).css({
                            marginLeft: '100%'
                        }).animate({
                            marginLeft: 0,
                            opacity: 1
                        }, 200);
                    });
                }
            }
        });
    });
});
</script>
@endpush