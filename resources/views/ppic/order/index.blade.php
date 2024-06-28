@extends('layouts.template')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2/select2-bootstrap4.css') }}">

    <style>
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
    <button type="button" data-bs-toggle="modal" data-bs-target="#tambahPesanan"
        class="btn btn-sm mb-2 bg-gradient-primary"><i class="fas fa-plus fs-6 me-2"></i> Tambah
        Pesanan</button>
    <div class="card p-3 bt-primary">
        <div class="nav-wrapper position-relative end-0">
            <ul class="nav nav-pills nav-fill p-1" role="tablist" id="custom-tabs-two-tab">
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1 @if (!session('success') || session('success') == 'Pesanan Berhasil Dibuat') active @endif"
                        id="custom-tabs-two-1-tab" data-bs-toggle="tab" href="#baru" role="tab"
                        aria-controls="profile" aria-selected="true">
                        @if (count($orders) > 0)
                            Pesanan Baru <span class="badge-notif bg-danger fw-bolder">{{ count($orders) }}</span>
                        @else
                            Pesanan Baru
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1 @if (session('success') == 'Jadwal berhasil dibuat.') active @endif" data-bs-toggle="tab"
                        href="#dikerjakan" role="tab" aria-controls="dashboard" aria-selected="false">

                        @if (count($running) > 0)
                            Sedang Dikerjakan <span class="badge-notif bg-warning fw-bolder">{{ count($running) }}</span>
                        @else
                            Sedang Dikerjakan
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#approve" role="tab"
                        aria-controls="dashboard" aria-selected="false">

                        @if (count($running) > 0)
                            Approve Desain <span
                                class="badge-notif bg-warning fw-bolder">{{ count($approveCad) + count($approveCam) }}</span>
                        @else
                            Approve Desain
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#history" role="tab"
                        aria-controls="dashboard" aria-selected="false">
                        @if (count($history) > 0)
                            History <span class="badge-notif bg-info fw-bolder">{{ count($history) }}</span>
                        @else
                            History
                        @endif
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show @if (!session('success') || session('success') == 'Pesanan Berhasil Dibuat') active @endif" id="baru"
                    role="tabpanel" aria-labelledby="custom-tabs-two-1-tab">
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
                                        Status</th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $angka = 0;
                                @endphp
                                @foreach ($noDesign as $nd)
                                    <td>{{ $nd->order_number }}</td>
                                    <td>{{ $nd->client->name }}</td>
                                    <td>{{ $nd->order_name }}</td>
                                    <td>{{ $nd->created_at->format('d M Y') }}</td>
                                    <td><span class="badge-custom bg-warning me-2"></span>Setting</td>
                                    <td>
                                        <a href="{{ url('desain/cam/' . $nd->id) }}"
                                            class="text-center btn bg-primary btn-primary my-0 px-3 btn-sm accept-btn">
                                            <i class="fa-solid fa-gear fs-6"></i>
                                        </a>
                                        <a class="text-center btn btn-info btn-sm detail-btn my-0 px-3"
                                            href="{{ url('order/' . $nd->id) }}">
                                            <i class="fa-solid fa-circle-info fs-6"></i>
                                        </a>
                                    </td>
                                @endforeach
                                @foreach ($orders as $item)
                                    <tr>
                                        <td>{{ $item->order_number }}</td>
                                        <td>{{ $item->client->name }}</td>
                                        <td>{{ $item->order_name }}</td>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if ($item->status == 0)
                                                <span class="badge-custom bg-warning me-2"></span>Pending
                                            @elseif($item->status == 1)
                                                <span class="badge-custom bg-warning me-2"></span>Need Confirm
                                            @elseif($item->status == 2)
                                                <span class="badge-custom bg-secondary me-2"></span>Scheduling
                                            @elseif($item->status <= 6)
                                                <span class="badge-custom bg-info me-2"></span>Design
                                            @elseif($item->status == 7)
                                                <span class="badge-custom bg-info me-2"></span>Toolkit
                                            @elseif($item->status == 8)
                                                <span class="badge-custom bg-info me-2"></span>Production
                                            @elseif($item->status == 9)
                                                <span class="badge-custom bg-success me-2"></span>Done
                                            @elseif($item->status == 10)
                                                <span class="badge-custom bg-warning me-2"></span>Decline
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <a href="{{ url('order/konfirmasi/' . $item->id) }}"
                                                    class="text-center btn bg-success btn-success my-0 px-3 btn-sm accept-btn">
                                                    <i class="fa-solid fa-check-circle fs-6"></i>
                                                </a>
                                            @elseif ($item->status == 2)
                                                <a href="{{ url('order/jadwal/' . $item->id) }}"
                                                    class="text-center btn bg-primary btn-primary my-0 px-3 btn-sm accept-btn">
                                                    <i class="fa-solid fa-calendar-days fs-6"></i>
                                                </a>
                                            @endif
                                            <a class="text-center btn btn-info btn-sm detail-btn my-0 px-3"
                                                href="{{ url('order/' . $item->id) }}">
                                                <i class="fa-solid fa-circle-info fs-6"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Pertama -->
                                    <div class="modal fade" id="modalPertama{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="modalPertamaLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalPertamaLabel{{ $item->id }}">
                                                        Konfirmasi
                                                        Pesanan {{ $item->order_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form id="formPilihMesin{{ $item->id }}"
                                                    data-order-id="{{ $item->id }}" method="POST"
                                                    action="{{ url('order/pilih-mesin/' . $item->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $item->id }}">
                                                    <input type="hidden" name="status" value="1">
                                                    <div class="modal-body">
                                                        @if ($errors->any())
                                                            <div class="my-3">
                                                                <div class="alert alert-danger">
                                                                    <ul>
                                                                        @foreach ($errors->all() as $error)
                                                                            <li>{{ $error }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <input type="hidden" name="order_id"
                                                            value="{{ $item->id }}">
                                                        <label class="form-label">Pilih Mesin</label>
                                                        <div class="row px-3">
                                                            @php
                                                                $displayedNames = [];
                                                            @endphp
                                                            @foreach ($machines as $item)
                                                                @if (!in_array($item->name, $displayedNames))
                                                                    <div class="form-check col-sm-4">
                                                                        <input class="form-check-input"
                                                                            data-mesin="{{ $angka }}"
                                                                            type="checkbox" name="mesin[]"
                                                                            value="{{ $item->id }}"
                                                                            id="mesin{{ $item->id }}">
                                                                        <label class="form-check-label"
                                                                            for="mesin{{ $item->id }}">{{ $item->name }}</label>
                                                                    </div>
                                                                    <?php $displayedNames[] = $item->name; ?>
                                                                @endif
                                                            @endforeach


                                                        </div>

                                                    </div>


                                                    <form id="formPilihMaterial{{ $item->id }}"
                                                        data-order-id="{{ $item->id }}" method="POST"
                                                        action="{{ url('order/pilih-material/' . $item->id) }}">
                                                        @csrf
                                                        <div class="modal-body">
                                                            @if ($errors->any())
                                                                <div class="my-3">
                                                                    <div class="alert alert-danger">
                                                                        <ul>
                                                                            @foreach ($errors->all() as $error)
                                                                                <li>{{ $error }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <input type="hidden" name="order_id"
                                                                value="{{ $item->id }}">
                                                            <label class="form-label">Pilih Material</label>
                                                            <div class="row px-3">
                                                                @foreach ($materials as $material)
                                                                    <div class="form-check col-sm-4">
                                                                        <input class="form-check-input" type="radio"
                                                                            data-material="{{ $angka }}"
                                                                            name="material[]" value="{{ $material->id }}"
                                                                            id="material{{ $material->id }}">
                                                                        <label class="form-check-label"
                                                                            for="material{{ $material->id }}">{{ $material->name }}</label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="return validateForm({{ $angka }})">Next <i
                                                                    class="fas fa-angle-right"></i></button>
                                                            <button id="buttonSub{{ $angka }}" type="submit"
                                                                class="btn btn-primary d-none btn-next">Next <i
                                                                    class="fas fa-angle-right"></i></button>
                                                            @php $angka++; @endphp
                                                        </div>
                                                    </form>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show @if (session('success') == 'Jadwal berhasil dibuat.') active @endif" id="dikerjakan"
                    role="tabpanel" aria-labelledby="custom-tabs-two-2-tab">
                    <div class="table-responsive p-0">
                        <table id="example2" class="table align-items-center mb-0 text-center">
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
                                        Pengerjaan</th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($running as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->client->name }}</td>
                                        <td>{{ $order->order_name }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if ($order->status <= 6)
                                                <span class="badge-custom bg-info me-2"></span>Design
                                            @elseif($order->status == 7)
                                                <span class="badge-custom bg-info me-2"></span>Toolkit
                                            @elseif($order->status == 8)
                                                <span class="badge-custom bg-info me-2"></span>Production
                                            @endif
                                        </td>
                                        <td>
                                            <a class="text-center btn btn-secondary bg-dradient btn-sm detail-btn px-3"
                                                href="{{ url('order/' . $order->id) }}">
                                                <i class="fa-solid fa-circle-info fs-6"></i>
                                            </a>

                                            <a class="text-center btn bg-gradient btn-primary btn-sm detail-btn px-3"
                                                href="{{ route('order.pdf', $order->id) }}">
                                                <i class="fa-solid fa-print fs-6"></i>
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
                <div class="tab-pane fade show" id="approve" role="tabpanel" aria-labelledby="custom-tabs-two-2-tab">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-center">
                            <tr>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor Pesanan
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama Proyek
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Desc</th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Tanggal Upload
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                            @foreach ($approveCad as $cad)
                                <tr>
                                    <td>{{ $cad->order_number }}</td>
                                    <td>{{ $cad->order_name }}</td>
                                    <td>CAD</td>
                                    <td>
                                        @foreach ($cad->schedule as $jadwal)
                                            @if ($jadwal->desc == 'CAD')
                                                {{ $jadwal->stop_actual }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0"
                                            href="{{ url('approve-desain/' . $cad->id) }}">
                                            <i class="fa-solid fa-arrow-right fs-6"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach ($approveCam as $cam)
                                <tr>
                                    <td>{{ $cam->order_number }}</td>
                                    <td>{{ $cam->order_name }}</td>
                                    <td>CAM</td>
                                    <td>
                                        @foreach ($cam->schedule as $jadwal)
                                            @if ($jadwal->desc == 'CAM')
                                                {{ $jadwal->stop_actual }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0"
                                            href="{{ url('approve-desain/' . $cam->id) }}">
                                            <i class="fa-solid fa-arrow-right fs-6"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show" id="history" role="tabpanel" aria-labelledby="custom-tabs-two-2-tab">
                    <div class="table-responsive p-0">
                        <div class="table-responsive p-0">
                            <table id="example2" class="table align-items-center mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                            Pesanan </th>
                                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                            Client
                                        </th>
                                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                            Proyek
                                        </th>
                                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                            Tanggal</th>
                                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                            Status</th>
                                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $os)
                                        <tr>
                                            <td>{{ $os->order_number }}</td>
                                            <td>{{ $os->client->name }}</td>
                                            <td>{{ $os->order_name }}</td>
                                            <td>{{ $os->created_at->format('d M Y') }}</td>
                                            <td>
                                                @if ($os->status == 9)
                                                    <span class="badge-custom bg-success me-2"></span>Done
                                                @elseif($os->status == 10)
                                                    <span class="badge-custom bg-danger me-2"></span>Decline
                                                @endif
                                            </td>
                                            <td>
                                                <a class="text-center btn btn-secondary bg-dradient btn-sm detail-btn px-3"
                                                    href="{{ url('order/' . $os->id) }}">
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
        </div>

        <div class="card-body px-0 pt-0 pb-2 px-sm-3">

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahPesanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header text-white bg-gradient-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Form Order</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="{{ url('ppic/order') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="text" id="perusahaan" name="perusahaan" class="form-control"
                                placeholder="Nama Client" aria-label="Name Perusahaan"
                                aria-describedby="name-perusahaan-addon" required list="perusahaan-list"
                                autocomplete="off">
                        </div>
                        <datalist id="perusahaan-list">
                            @php
                                $suggestedNames = [];
                            @endphp
                            @foreach ($orders as $riwayat)
                                @if ($riwayat->client->name && !in_array($riwayat->client->name, $suggestedNames))
                                    <option value="{{ $riwayat->client->name }}"
                                        data-phone="{{ $riwayat->client->phone }}"
                                        data-address="{{ $riwayat->client->address }}">
                                        @php
                                            $suggestedNames[] = $riwayat->client->name;
                                        @endphp
                                @endif
                            @endforeach
                        </datalist>
                        <div class="mb-3">
                            <input type="text" id="phone" name="phone" class="form-control"
                                placeholder="Nomor Telepon" aria-label="Phone" aria-describedby="phone-addon" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" id="address" name="address" class="form-control"
                                placeholder="Alamat Client" aria-label="Address" aria-describedby="address-addon"
                                required>
                        </div>
                        <div class="mb-3">
                            <input type="text" id="order_name" name="order_name" class="form-control"
                                placeholder="Nama Proyek" aria-label="Order Name" aria-describedby="name-project-addon"
                                required>
                        </div>
                        <div class="mb-3">
                            <select name="material" id="material" class="form-select" required>
                                <option value="" hidden>Pilih Material</option>
                                @foreach ($materials as $mat)
                                    <option value="{{ $mat->name }}">{{ $mat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <input type="file" name="gambar[]" class="form-control" placeholder="Gambar"
                                aria-label="Gambar" aria-describedby="gambar-addon" multiple>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn bg-gradient-secondary me-2"
                                data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
    <script>
        $('#material').select2({
            theme: 'bootstrap4',
            dropdownParent: $("#tambahPesanan"),
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
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
                "columns": [{
                        "data": "column1"
                    },
                    {
                        "data": "column2"
                    },
                    {
                        "data": "column3"
                    },
                    {
                        "data": "column4"
                    },
                    {
                        "data": "column5"
                    },
                    {
                        "data": "column6"
                    }
                ]
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "columns": [{
                        "data": "column1"
                    },
                    {
                        "data": "column2"
                    },
                    {
                        "data": "column3"
                    },
                    {
                        "data": "column4"
                    },
                    {
                        "data": "column5"
                    },
                    {
                        "data": "column6"
                    }
                ]
            });
        });
    </script> --}}
    <script>
        document.getElementById("perusahaan").addEventListener("input", function() {
            var selectedOption = document.querySelector("#perusahaan-list option[value='" + this.value + "']");
            if (selectedOption) {
                var phone = selectedOption.getAttribute("data-phone");
                var address = selectedOption.getAttribute("data-address");
                document.getElementById("phone").value = phone;
                document.getElementById("address").value = address;
            }
        });
        document.getElementById("material").addEventListener("input", function() {
            var selectedOption = document.querySelector("#material-list option[value='" + this.value + "']");
            if (selectedOption) {}
        });
    </script>
    <script>
        function validateForm(id) {
            var mesinChecked = document.querySelectorAll('input[data-mesin="' + id + '"]:checked').length;
            var materialChecked = document.querySelectorAll('input[data-material="' + id + '"]:checked').length;
            if (mesinChecked === 0 && materialChecked === 0) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Silakan pilih setidaknya satu mesin dan satu material.'
                });
                return false;
            } else if (mesinChecked === 0) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Silakan pilih setidaknya satu mesin.'
                });
                return false;
            } else if (materialChecked === 0) {
                Swal.fire({
                    icon: 'warning',
                    text: 'Silakan pilih setidaknya satu material.'
                });
                return false;
            }
            var button = document.getElementById("buttonSub" + id);
            button.click();
        }
    </script>
@endpush
