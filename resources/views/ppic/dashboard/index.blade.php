@extends('layouts.template')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div id="content-container">
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Pesanan Baru</p>
                            <h5 class="font-weight-bolder mb-0" id="count-order">
                                {{ $countOrder }}
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
                            <h5 class="font-weight-bolder mb-0" id="tot-order">
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
    <div class="col-lg-5 mb-lg-0 mb-4">
        <div class="card bt-primary">
            <div class="card-body p-3">
                <div class="d-flex flex-column h-100">
                    @if ($countOrder > 0)
                    <h5 class="font-weight-bolder pt-1 mb-2">Pesanan Perlu Diproses <span class="badge-notif bg-danger" id="perOrder">{{ $countOrder }}</span></h5>
                    @else
                    <h5 class="font-weight-bolder pt-1 mb-2">Belum Ada Pesanan Baru</h5>
                    @endif
    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nomor Pesanan</th>
                                    <th>Nama Proyek</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody id="order-body">
                                @foreach ($order->newPpic() as $item)
                                <tr>
                                    <td>{{ $item->order_number }}</td>
                                    <td>{{ $item->order_name }}</td>
                                    <td>
                                        <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0" href="{{ url('order/' . $item->id) }}">
                                            <i class="fa-solid fa-circle-info fs-6"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="{{ url('ppic/order') }}">
                        Semua Data
                        <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>    
    <div class="col-lg-7">
        <div class="card bt-pink">
            <div class="card-body p-3 pb-2">
                <h5 class="font-weight-bolder pt-1 mb-2">Approval</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No Pesanan</th>
                            <th class="text-center">Desc</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="order-table-body">
                        @foreach ($orderSelesai as $os)
                        <tr>
                            <td>{{ $os->order_number }}</td>
                            <td class="text-center text-success">Selesai Produksi</td>
                            <td class="text-center">{{ date('d/m/Y | H:i:s', strtotime($os->updated_at)) }}</td>
                            <td class="text-center">
                                <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0" href="{{ url('approve-produksi/' . $os->id) }}">
                                    <i class="fa-solid fa-arrow-right fs-6"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @foreach ($desainCad as $cad)
                        <tr>
                            <td>{{ $cad->order_number }}</td>
                            <td>CAD</td>
                            <td>
                                @foreach ($cad->schedule as $jadwal)
                                @if ($jadwal->desc == 'CAD')
                                {{ date('d/m/Y | H:i:s', strtotime($jadwal->stop_actual)) }}
                                @endif
                                @endforeach
                            </td>
                            <td>
                                <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0" href="{{ url('approve-desain/' . $cad->id) }}">
                                    <i class="fa-solid fa-arrow-right fs-6"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
    
                        @foreach ($desainCam as $cam)
                        <tr>
                            <td>{{ $cam->order_number }}</td>
                            <td>CAM</td>
                            <td>
                                @foreach ($cam->schedule as $jadwal)
                                @if ($jadwal->desc == 'CAM')
                                {{ date('d/m/Y | H:i:s', strtotime($jadwal->stop_actual)) }}
                                @endif
                                @endforeach
                            </td>
                            <td>
                                <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0" href="{{ url('approve-desain/' . $cam->id) }}">
                                    <i class="fa-solid fa-arrow-right fs-6"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    
                @if (count($desainCad) == 0 && count($desainCam) == 0 && count($orderSelesai) == 0)
                <p class="h5 text-center my-3">Belum ada Proyek untuk di approve</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-12 mt-4">
        <div class="card h-100 p-3 bt-pink">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="font-weight-bolder pt-1 mb-2">Capaian Proyek </h5>
                <div class="pagination pagination-sm justify-content-end">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item {{ $order->orders1()->previousPageUrl() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $order->orders1()->previousPageUrl() }}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @for ($i = 1; $i <= $order->orders1()->lastPage(); $i++)
                                <li class="page-item {{ $order->orders1()->currentPage() == $i ? 'active' : '' }}">
                                    @if ($order->orders1()->currentPage() == $i)
                                    <span class="page-link">{{ $i }}</span>
                                    @else
                                    <a class="page-link" href="{{ $order->orders1()->url($i) }}">{{ $i }}</a>
                                    @endif
                                </li>
                                @endfor
                                <li class="page-item {{ $order->orders1()->nextPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link next" href="{{ $order->orders1()->nextPageUrl() }}"
                                        aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                        </ul>
                    </nav>
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
                            $perPage = $order->orders1()->perPage(); // Dapatkan jumlah item per halaman
                            $offset = ($page - 1) * $perPage; // Hitung offset untuk nomor urut
                            @endphp
                            @foreach ($order->orders1() as $key => $item)
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
                                                            <div class="progress-bar bg-success" role="progressbar"
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
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-4">
        <div class="card ">
            <div class="card-header pb-0">
                <h6>Sales overview</h6>
            </div>
            <div class="card-body p-3">
                <div class="chart">
                    <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
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
gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

// Dapatkan data bulan dan jumlah item dari controller
var data = {
    !!json_encode($order - > monthly()) !!
};
var data2 = {
    !!json_encode($client - > monthly()) !!
};


// Buat array untuk menyimpan label bulan
var labels = [];
var labelClients = Object.keys(data2);;
// Buat array untuk menyimpan jumlah item per bulan
var itemCounts = [];
var clientCounts = Object.values(data2);

// Loop melalui data bulan
for (var month in data) {
    labels.push(month); // Tambahkan label bulan ke array
    itemCounts.push(data[month].length); // Tambahkan jumlah item ke array
}

for (var month2 in data2) {
    labelClients.push(month2); // Tambahkan label bulan ke array
    clientCounts.push(data[month2].length); // Tambahkan jumlah item ke array
}

new Chart(ctx2, {
    type: "line",
    data: {
        labels: labels,
        datasets: [{
                label: "Pesanan",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#cb0c9f",
                borderWidth: 3,
                backgroundColor: gradientStroke1,
                fill: true,
                data: itemCounts,
                maxBarThickness: 6

            },
            {
                label: "Client",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#3A416F",
                borderWidth: 3,
                backgroundColor: gradientStroke2,
                fill: true,
                data: clientCounts,
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
    },
});
</script>
<script>
    function refreshContent() {
        $.ajax({
            url: '{{ url("ppic/dashboard") }}',
            type: 'GET',
            success: function(data) {
                $('#count-order').text(data.countOrder);
                $('#perOrder').text(data.countOrder);
                $('#tot-order').text(data.semuaOrder);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    setInterval(function() {
        console.log("Refreshing content...");
        refreshContent();
        console.log("Content refreshed.");
    }, 10000);
</script>
<script>
    function refreshApprovalContent() {
        $.ajax({
            url: '{{ url("ppic/dashboard") }}',
            type: 'GET',
            success: function(data) {
                let tableContent = '';

                data.desainCad.forEach(function(cad) {
                    let orderNumber = cad.order_number || 'N/A';
                    let updatedAt = cad.updated_at ? new Date(cad.updated_at).toLocaleString() : 'N/A';
                    tableContent += `<tr>
                        <td>${orderNumber}</td>
                        <td class="text-center">CAD</td>
                        <td class="text-center">${updatedAt}</td>
                        <td class="text-center">
                            <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0" href="{{ url('approve-desain/') }}/${cad.id}">
                                <i class="fa-solid fa-arrow-right fs-6"></i>
                            </a>
                        </td>
                    </tr>`;
                });

                data.desainCam.forEach(function(cam) {
                    let orderNumber = cam.order_number || 'N/A';
                    let updatedAt = cam.updated_at ? new Date(cam.updated_at).toLocaleString() : 'N/A';
                    tableContent += `<tr>
                        <td>${orderNumber}</td>
                        <td class="text-center">CAM</td>
                        <td class="text-center">${updatedAt}</td>
                        <td class="text-center">
                            <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0" href="{{ url('approve-desain/') }}/${cam.id}">
                                <i class="fa-solid fa-arrow-right fs-6"></i>
                            </a>
                        </td>
                    </tr>`;
                });

                if (data.desainCad.length === 0 && data.desainCam.length === 0 && data.orderSelesai.length === 0) {
                    $('#no-project-message').show();
                    $('#order-table-body').html('');
                } else {
                    $('#no-project-message').hide();
                    $('#order-table-body').html(tableContent);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    setInterval(function() {
        console.log("Refreshing approval content...");
        refreshApprovalContent();
        console.log("Approval content refreshed.");
    }, 10000);
</script>
<script>
    function refreshOrderTable() {
        $.ajax({
            url: '{{ url("ppic/dashboard") }}',
            type: 'GET',
            success: function(data) {
                let tableContent = '';

                data.orders.forEach(function(order) {
                    tableContent += `<tr>
                        <td>${order.order_number}</td>
                        <td>${order.order_name}</td>
                        <td>
                            <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0" href="{{ url('order/') }}/${order.id}">
                                <i class="fa-solid fa-circle-info fs-6"></i>
                            </a>
                        </td>
                    </tr>`;
                });

                $('#order-body').html(tableContent);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    setInterval(function() {
        console.log("Refreshing order table...");
        refreshOrderTable();
        console.log("Order table refreshed.");
    }, 10000);
</script>

@endpush