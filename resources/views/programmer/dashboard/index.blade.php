@extends('layouts.template')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <!-- End Navbar -->
    <div id="content-container">

    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Selesai Bulan ini</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ count($proyekSelesaiBlnIni) }}
                                    @if ($persentaseSelesai > 0)
                                        <span class="text-success text-sm font-weight-bolder">
                                            @if (floor($persentaseSelesai) != $persentaseSelesai)
                                                {{ number_format($persentaseSelesai, 2) }}%
                                            @else
                                                {{ $persentaseSelesai }}%
                                            @endif
                                        </span>
                                    @elseif ($persentaseSelesai == 0)
                                        <span class="text-warning text-sm font-weight-bolder">
                                            @if (floor($persentaseSelesai) != $persentaseSelesai)
                                                {{ number_format($persentaseSelesai, 2) }}%
                                            @else
                                                {{ $persentaseSelesai }}%
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-danger text-sm font-weight-bolder">
                                            @if (floor($persentaseSelesai) != $persentaseSelesai)
                                                {{ number_format($persentaseSelesai, 2) }}%
                                            @else
                                                {{ $persentaseSelesai }}%
                                            @endif
                                        </span>
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
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
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Proyek Selesai</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ count($proyekSelesai) }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
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
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Proyek Bulan ini</p>
                                <h5 class="font-weight-bolder mb-0" id="count_bulan">
                                    {{ count($proyekBlnIni) }}
                                    @if ($persentasePerubahan > 0)
                                        <span class="text-success text-sm font-weight-bolder">
                                            @if (floor($persentasePerubahan) != $persentasePerubahan)
                                                {{ number_format($persentasePerubahan, 2) }}%
                                            @else
                                                {{ $persentasePerubahan }}%
                                            @endif
                                        </span>
                                    @elseif ($persentasePerubahan == 0)
                                        <span class="text-warning text-sm font-weight-bolder">
                                            @if (floor($persentasePerubahan) != $persentasePerubahan)
                                                {{ number_format($persentasePerubahan, 2) }}%
                                            @else
                                                {{ $persentasePerubahan }}%
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-danger text-sm font-weight-bolder">
                                            @if (floor($persentasePerubahan) != $persentasePerubahan)
                                                {{ number_format($persentasePerubahan, 2) }}%
                                            @else
                                                {{ $persentasePerubahan }}%
                                            @endif
                                        </span>
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
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
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Proyek</p>
                                <h5 class="font-weight-bolder mb-0" id="count_proyek">
                                    {{ count($proyek) }}
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
    </div>
    <div class="row mt-4">
        <div class="col-lg-5 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="font-weight-bolder">Pesanan Baru
                        <span class="badge-notif bg-danger" id="pesan-order" style="display:none;">0</span>
                    </h5>
                    <table class="table">
                        <tr>
                            <th>Nomor Pesanan</th>
                            <th>Nama Proyek</th>
                            <th>Detail</th>
                        </tr>
                        <tbody id="order-body">
                        @foreach ($orders as $item)
                            <tr>
                                <td>{{ $item->order_number }}</td>
                                <td>{{ $item->order_name }}</td>
                                <td>
                                    <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2"
                                        href="{{ url('order/' . $item->id) }}">
                                        <i class="fa-solid fa-circle-info fs-6"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                        Read More
                        <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>        
        <div class="col-lg-7">
            <div class="card bt-pink">
                <div class="card-body p-3 pb-2">
                    <h5 class="font-weight-bolder">Revisi Desain</h5>
                    <table class="table">
                        <tr>
                            <th>Nomor Pesanan</th>
                            <th>Desc</th>
                            <th>Tanggal Update</th>
                            <th>Aksi</th>
                        </tr>
                        <tbody id="order-table-body">
                        @foreach ($revisi as $rev)
                            <tr>
                                <td>
                                    {{ $rev->order_number }}
                                </td>
                                <td> Revisi</td>
                                <td>
                                    {{ date('d/m/Y | H:i:s', strtotime($rev->updated_at)) }}
                                </td>
                                <td>
                                    <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0"
                                        href="{{ url('prog/revisi/'. $rev->id ) }}">
                                        <i class="fa-solid fa-arrow-right fs-6"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if (count($revisi) == 0 )
                        <p class="h5 text-center my-3">Tidak ada revisi desain</p>
                    @endif
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
        gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)');

        // Dapatkan data bulan dan jumlah item dari controller
        var data = {!! json_encode($order->monthlyDesign()) !!};


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
    <script>
        function refreshContent() {
            $.ajax({
                url: '{{ url("prog/dashboard") }}',
                type: 'GET',
                success: function(data) {
                    var count = data.count; // Mengakses elemen 'count' dari data JSON
                    var $pesanOrder = $('#pesan-order');
                    
                    if (count > 0) {
                        $pesanOrder.text(count);
                        $pesanOrder.show();
                    } else {
                        $pesanOrder.hide();
                    }
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
        }, 5000);
    </script>
      
    <script>
        function refreshBulan() {
            $.ajax({
                url: '{{ url("prog/dashboard") }}',
                type: 'GET',
                success: function(data) {
                    $('#count_bulan').text(data.proyekBlnIni.length);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    
        setInterval(function() {
            console.log("Refreshing content...");
            refreshBulan();
            console.log("Content refreshed.");
        }, 5000);
    </script>
    <script>
        function refreshTotProyek() {
            $.ajax({
                url: '{{ url("prog/dashboard") }}',
                type: 'GET',
                success: function(data) {
                    $('#count_proyek').text(data.proyek.length);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    
        setInterval(function() {
            console.log("Refreshing content...");
            refreshTotProyek();
            console.log("Content refreshed.");
        }, 5000);
    </script>
    <script>
        function refreshOrderTable() {
            $.ajax({
                url: '{{ url("prog/dashboard") }}',
                type: 'GET',
                success: function(data) {
                    let tableContent = '';
    
                    // Periksa apakah 'orders' ada dan merupakan array
                    if (data.orders && Array.isArray(data.orders) && data.orders.length > 0) {
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
                    } else {
                        tableContent = '<tr><td colspan="3">No orders found</td></tr>';
                    }
    
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
        }, 5000);
    </script>
    <script>
        function refreshRevisiContent() {
            $.ajax({
                url: '{{ url("prog/dashboard") }}',
                type: 'GET',
                success: function(data) {
                    let tableContent = '';
    
                    data.revisi.forEach(function(rev) {
                        let orderNumber = rev.order_number || 'N/A';
                        let updatedAt = rev.updated_at ? new Date(rev.updated_at).toLocaleString() : 'N/A';
                        tableContent += `<tr>
                            <td>${orderNumber}</td>
                            <td>Revisi</td>
                            <td>${updatedAt}</td>
                            <td>
                                <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0" href="{{ url('prog/revisi/') }}/${rev.id}">
                                    <i class="fa-solid fa-arrow-right fs-6"></i>
                                </a>
                            </td>
                            @if (count($revisi) == 0 )
                        <p class="h5 text-center my-3">Tidak ada revisi desain</p>
                    @endif
                        </tr>`;
                    });
    
                    if (data.revisi.length === 0) {
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
            refreshRevisiContent();
            console.log("Approval content refreshed.");
        }, 5000);
    </script>
@endpush
