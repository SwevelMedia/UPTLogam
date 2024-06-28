@extends('layouts.template')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> --}}
    <style>
        ul.inline-list {
            padding: 0;
            /* Menghapus padding default */
            margin: 0;
            /* Menghapus margin default */
        }

        ul.inline-list li {
            display: inline;
            /* Membuat elemen <li> tampil secara inline */
            margin-right: 10px;
            /* Memberi jarak antara elemen <li> */
        }

        .nav-item .nav-link.active {
            background-color: #007bff;
            /* Warna biru untuk background saat nav link active */
            color: white;
            /* Warna teks menjadi putih */
        }
    </style>
@endpush

@section('content')
    <div class="swal" data-swal="{{ session('success') }}"></div>
    <div class="card p-2 mb-5">
        <div class="nav-wrapper position-relative end-0 ">
            <ul class="nav nav-pills nav-fill p-1" role="tablist" id="custom-tabs-two-tab">
                <li class="nav-item active">
                    <a class="nav-link mb-0 px-0 py-1 active" id="custom-tabs-two-1-tab" data-bs-toggle="tab" href="#baru"
                        role="tab" aria-controls="profile" aria-selected="true">
                        @if (count($orders) > 0)
                            Daftar Produksi <span class="badge-notif bg-danger">{{ count($orders) }}</span>
                        @else
                            Daftar Produksi
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#dikerjakan" role="tab"
                        aria-controls="dashboard" aria-selected="false">

                        @if (count($running) > 0)
                            Sedang Dikerjakan <span class="badge-notif bg-warning">{{ count($running) }}</span>
                        @else
                            Sedang Dikerjakan
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#selesaidikerjakan" role="tab"
                        aria-controls="dashboard" aria-selected="false">

                        @if (count($history) > 0)
                            Selesai Dikerjakan <span class="badge-notif bg-info">{{ count($history) }}</span>
                        @else
                            Selesai Dikerjakan
                        @endif
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show active" id="baru" role="tabpanel"
                    aria-labelledby="custom-tabs-two-1-tab">
                    <div class="table-responsive p-0">
                        <table id="example" class="table align-items-center mb-0 text-center">
                            <thead>
                                <tr>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                        Pesanan
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                        Client
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama Proyek
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Tanggal
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->client->name }}</td>
                                        <td>{{ $order->order_name }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a class="text-center btn btn-primary btn-sm detail-btn px-3"
                                                href="{{ url('order/' . $order->id) }}">
                                                <i class="fa-solid fa-circle-info fs-6"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show" id="dikerjakan" role="tabpanel" aria-labelledby="custom-tabs-two-2-tab">
                    <div class="table-responsive p-0">
                        <table id="example" class="table align-items-center mb-0 text-center">
                            <thead>
                                <tr>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                        Pesanan
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                        Client
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama Proyek
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Proses
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($running as $item)
                                    <tr>
                                        <td>{{ $item->order_number }}</td>
                                        <td>{{ $item->client->name }}</td>
                                        <td>{{ $item->order_name }}</td>
                                        <td>
                                            {{ $item->desc }}

                                        </td>
                                        <td>
                                            <a class="text-center btn btn-secondary btn-sm detail-btn px-3"
                                                href="{{ url('operator/produksi/' . $item->id) }}">
                                                <i class="fa-solid fa-circle-info fs-6"></i>
                                            </a>
                                            @foreach ($item->machineOrders as $mo)
                                                @if ($item->desc == $mo->mesin->machine_code)
                                                    <a class="text-center btn btn-primary btn-sm detail-btn px-3"
                                                        href="{{ url('operator/produksi/' . $mo->id) }}">
                                                        <i class="fa-solid fa-arrow-right fs-6"></i>
                                                    </a>
                                                @endif
                                            @endforeach

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade show" id="selesaidikerjakan" role="tabpanel"
                    aria-labelledby="custom-tabs-two-2-tab">
                    <div class="table-responsive p-0">
                        <table id="example" class="table align-items-center mb-0 text-center">
                            <thead>
                                <tr>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                        Pesanan
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                        Client
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama Proyek
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Proses
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $idx)
                                    <tr>
                                        <td>{{ $idx->order_number }}</td>
                                        <td>{{ $idx->client->name }}</td>
                                        <td>{{ $idx->order_name }}</td>
                                        <td>
                                            {{ $idx->desc }}

                                        </td>
                                        <td>
                                            @foreach ($idx->machineOrders as $mo)
                                                @if ($idx->desc == $mo->mesin->machine_code)
                                                    <a class="text-center btn btn-primary btn-sm detail-btn px-3"
                                                        href="{{ url('operator/produksi/' . $mo->id) }}">
                                                        <i class="fa-solid fa-circle-info fs-6"></i>
                                                    </a>
                                                @endif
                                            @endforeach

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body px-0 pt-0 pb-2 px-sm-3">

        </div>
    </div>
    <div class="card p-2">
        <div class="nav-wrapper position-relative end-0 ">
            <p class="h4 ms-4">Jadwal Produksi</p>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show active" id="baru" role="tabpanel"
                    aria-labelledby="custom-tabs-two-1-tab">
                    <div class="table-responsive p-0">
                        <table id="example" class="table align-items-center mb-0 text-center">
                            <thead>
                                <tr>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                        Pesanan
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                        Client
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama Proyek
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Pengerjaan
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Jadwal
                                        Pengerjaan
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($waitingorders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->client->name }}</td>
                                        <td>{{ $order->order_name }}</td>
                                        <td>
                                            @if ($order->status == 0)
                                                <span class="badge-custom bg-warning me-2"></span>Pending
                                            @elseif($order->status == 1)
                                                <span class="badge-custom bg-warning me-2"></span>Need Confirm
                                            @elseif($order->status == 2)
                                                <span class="badge-custom bg-secondary me-2"></span>Scheduling
                                            @elseif($order->status <= 5)
                                                <span class="badge-custom bg-info me-2"></span>Design
                                            @elseif($order->status == 6)
                                                <span class="badge-custom bg-info me-2"></span>Toolkit
                                            @elseif($order->status == 7)
                                                <span class="badge-custom bg-info me-2"></span>Production
                                            @elseif($order->status == 8)
                                                <span class="badge-custom bg-success me-2"></span>Done
                                            @elseif($order->status == 9)
                                                <span class="badge-custom bg-warning me-2"></span>Decline
                                            @endif
                                        </td>

                                        <td>
                                            @foreach ($jadwal as $index)
                                                @if ($order->order_number == $index->order_number)
                                                    {{ \Carbon\Carbon::createFromFormat('d/m/Y', $index->start_plan)->format('d M Y') }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <a class="text-center btn btn-primary btn-sm detail-btn px-3"
                                                href="{{ url('order/' . $order->id) }}">
                                                <i class="fa-solid fa-circle-info fs-6"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-body px-0 pt-0 pb-2 px-sm-3">

        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script>
        const swal = $('.swal').data('swal');
        if (swal) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Success',
                text: swal,
                showConfirmButton: false,
                timer: 2000
            })
        }
    </script>
    <script>
        $(function() {
            $('#example').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endpush
