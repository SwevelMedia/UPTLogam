@extends('layouts.template')

@push('css')
    <style>
        .nav-item .nav-link.active {
            background-color: #007bff;
            /* Warna biru untuk background saat nav link active */
            color: white;
            /* Warna teks menjadi putih */
        }

        @media screen and (min-width: 768px) {
            .gambar {
                width: 600px;
                height: 400px;
            }

            .dropdown-menu-width {
                width: 500px;
            }

            .input-proses {
                border: none;
                text-align: center;
                width: 150px;
            }
        }

        /* Style untuk layar mobile */
        @media screen and (max-width: 767px) {
            .gambar {
                width: 100%;
                /* Gambar akan mengisi lebar layar penuh */
                height: auto;
                /* Tinggi gambar disesuaikan secara otomatis sesuai dengan aspek rasio */
            }

            .dropdown-menu-width {
                width: 250px;
            }

            .input-proses {
                border: none;
                text-align: center;
                width: 100px;
            }
        }
    </style>
    <link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2/select2-bootstrap4.css') }}">
@endpush

@section('content')
    <div class="card mb-4">
        <div class="card-header border-bottom mb-3 pb-0 bg-gradient-primary">
            <div class="d-flex justify-content-between">
                <a href="{{ url()->previous() }}">
                    <h6 class="text-info"><i class="fas fa-chevron-left"></i> Kembali</h6>
                </a>
                <p class="h4 fw-bolder text-uppercase text-white mx-0 mx-sm-5 mx-md-5 mx-lg-5 mx-xl-5 ">
                    {{ $order->order_number }}</p>
            </div>

        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="swal2" data-swal="{{ session('warning') }}"></div>

        <div class="card-body px-0 pt-0 p-3">
            @if ($errors->any())
                <div class="my-2 mx-2">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-white">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="row mb-3">
                <div class="col-md-6">
                    <table class="table align-items-center mb-0 px-sm-3">
                        <tr>
                            <th style="width: 30%">Nama Projek</th>
                            <td class="text-wrap">: {{ $order->order_name }}</td>
                        </tr>
                        <tr>
                            <th>Material</th>
                            <td class="text-wrap">:
                                {{ $order->material }}
                            </td>
                        </tr>

                        <tr>
                            <th>Mesin</th>
                            <td class="text-wrap">:
                                @foreach ($order->machineOrders as $mcOrd)
                                    {{ $mcOrd->mesin->machine_code }}
                                    @if (count($order->machineOrders) > 1 && $loop->iteration != count($order->machineOrders))
                                        ,
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr></tr>

                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table mb-0 px-sm-3">
                        <tr>
                            <th>File Desain</th>
                            <td class="text-wrap">:
                                @if (count($gambarUpload) > 0)
                                    @foreach ($gambarUpload as $gu)
                                        <a class="text-pink" href="{{ asset('storage/image/order/' . $gu->path) }}"
                                            target="_blank">
                                            {{ $gu->path }}
                                        </a>
                                        @if (count($gambarUpload) > 1 && $loop->iteration != count($gambarUpload))
                                            |
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-secondary"> Tidak ada File dari Programmer</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>File Client</th>

                            <td class="text-wrap">:
                                @if (count($gambarclient) < 1)
                                    <span class="text-secondary"> Tidak ada File dari client</span>
                                @else
                                    @foreach ($gambarclient as $gambar)
                                        @if (pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) == 'jpg' ||
                                                pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) == 'png' ||
                                                pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) == 'jpeg')
                                            <a class="text-pink" style="cursor: pointer" data-bs-toggle="modal"
                                                data-bs-target="#modal{{ $gambar->id }}">
                                                File
                                                {{ $loop->iteration }}.{{ pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) }}
                                            </a>
                                            @if (count($gambarclient) > 1 && $loop->iteration != count($gambarclient))
                                                |
                                            @endif
                                        @else
                                            <a class="text-pink" href="{{ asset('storage/image/order/' . $gambar->path) }}"
                                                target="_blank">
                                                File
                                                {{ $loop->iteration }}.{{ pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) }}
                                            </a>
                                            @if (count($gambarclient) > 1 && $loop->iteration != count($gambarclient))
                                                |
                                            @endif
                                        @endif

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal{{ $gambar->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="staticBackdropLabel" data-bs-backdrop="static"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary">
                                                        <button type="button" class="btn-close text-dark"
                                                            data-bs-dismiss="modal" aria-label="Close">

                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed class="gambar"
                                                            src="{{ asset('storage/image/order/' . $gambar->path) }}"
                                                            type="application/pdf" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr></tr>
                    </table>
                </div>

            </div>


        </div>
    </div>

    <div class="card mb-4">
        <ul class="nav nav-pills nav-fill mx-sm-3 mt-2 mx-2">
            @foreach ($order->machineOrders as $mo)
                <li class="nav-item">
                    <a class="nav-link nav-x @if ($loop->first) active @endif"
                        id="fill-tab-{{ $loop->iteration }}" data-bs-toggle="pill" href="#mo{{ $mo->id }}"
                        role="tab" aria-controls="fill-tabpanel-0"
                        aria-selected="true">{{ $mo->mesin->machine_code }}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content mt-3" id="tab-content">
            @php
                $opName = [];
            @endphp
            @foreach ($order->machineOrders as $mo2)
                <div class="tab-pane @if ($loop->first) active @endif" id="mo{{ $mo2->id }}"
                    role="tabpanel" aria-labelledby="fill-tab-{{ $loop->iteration }}">

                    @include('operator.produksi.produksi_tambah_sp')

                    <div class="table-responsive px-sm-3">
                        <table class="table" style="max-height: 100% !important;">
                            <thead>
                                <tr class="bg-light ">
                                    <th class="text-center px-2">No</th>
                                    <th class="text-center">Proses</th>
                                    <th class="text-center">Start</th>
                                    <th class="text-center">Stop</th>
                                    <th class="text-center">Waktu Mesin</th>
                                    <th class="text-center">Info</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $firstStart = true;
                                    $firstStop = true;

                                @endphp

                                @foreach ($mo2->operatorProses as $key => $op)
                                    <tr class="">
                                        <td class="text-center">
                                            {{ $op->urutan }}
                                        </td>
                                        <td class="py-1 text-center" style="width: 15%;">
                                            @if ($op->proses_name == 'Setting')
                                                {{ $op->proses_name }}
                                            @else
                                                <form action="{{ url('produksi/update-nama-proses/' . $op->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="text" class="input-proses" name="proses_name"
                                                        value="{{ $op->proses_name }}" autocomplete="off">
                                                </form>
                                            @endif
                                        </td>
                                        <td class="py-1 text-center">
                                            @if ($op->start != null && $firstStart)
                                                {{ date('H:i:s', strtotime($op->start)) }}
                                            @elseif($firstStart && $firstStop)
                                                <form action="{{ url('proses-start') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="operator_proses_id"
                                                        value="{{ $op->id }}">

                                                    <input type="hidden" name="key" value="{{ $loop->iteration }}">

                                                    <input type="hidden" name="order_number"
                                                        value="{{ $order->order_number }}">

                                                    <input type="hidden" name="desc"
                                                        value="{{ $mo2->mesin->machine_code }}">

                                                    <button type="submit"
                                                        class="btn btn-sm bg-gradient-primary my-0">Start</button>
                                                    @php
                                                        $firstStart = false;
                                                    @endphp
                                                </form>
                                            @endif
                                        </td>
                                        <td class="py-1 text-center">
                                            @if ($op->stop != null)
                                                {{ date('H:i:s', strtotime($op->stop)) }}
                                            @elseif($op->start != null)
                                                <form action="{{ url('proses-stop') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="operator_proses_id"
                                                        value="{{ $op->id }}">

                                                    @if (count($mo2->operatorProses) == $loop->iteration)
                                                        <input type="hidden" name="keyMax" value="1">
                                                    @else
                                                        <input type="hidden" name="keyMax" value="0">
                                                    @endif

                                                    <input type="hidden" name="order_number"
                                                        value="{{ $order->order_number }}">

                                                    <input type="hidden" name="desc"
                                                        value="{{ $mo2->mesin->machine_code }}">

                                                    <button type="submit"
                                                        class="btn btn-sm bg-gradient-primary my-0">Stop</button>
                                                    @php
                                                        $firstStop = false;
                                                    @endphp
                                                </form>
                                            @endif
                                        </td>
                                        <td class="py-1 text-center">
                                            @if ($op->proses_name == 'Setting')
                                                {{ $op->waktu_mesin }}
                                            @elseif ($op->waktu_mesin != null)
                                                {{ $op->formatted_waktu_mesin }}
                                            @elseif ($op->stop != null)
                                                <button data-bs-toggle="modal"
                                                    data-bs-target="#modalWaktu{{ $op->id }}"
                                                    class="btn btn-sm bg-gradient-primary my-0">Masukkan</button>
                                            @endif

                                        </td>

                                        <td class="align-middle justify-content-center d-flex">
                                            @if ($op->stop == null)
                                                <form action="{{ url('produksi/hapus-proses') }}"
                                                    onsubmit="return confirm('Yakin hapus {{ $op->proses_name }}?')"
                                                    class="me-2" method="post">
                                                    @csrf
                                                    <input type="hidden" name="op_id" value="{{ $op->id }}">
                                                    <button name="submit" style="background: none; border: none;">
                                                        <i class="fas fa-trash text-danger"></i>
                                                    </button>
                                                </form>
                                                {{-- @else
                                                <button disabled style="background: none; border: none;">
                                                    <i class="fas fa-trash text-secondary"></i>
                                                </button> --}}
                                            @endif
                                            <button type="button" style="border: none; background: none;"
                                                data-bs-toggle="modal" data-bs-target="#detail{{ $op->id }}">
                                                <i class="fa-solid fa-ellipsis"></i></button>
                                        </td>
                                    </tr>

                                    @include('operator.produksi.produksi_modal')
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-12 px-3">
            @if ($op_selesai == 0)
                <form action="{{ url('operator/produksi-selesai/' . $order->id) }}" method="post">
                    @csrf
                    <button @if ($order->produksi == 2) disabled @endif type="submit"
                        class="btn bg-gradient-primary w-100">Proyek Selesai</button>
                </form>
            @endif
        </div>

    </div>

    @php
        $count = count($order->machineOrders);
    @endphp
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Load active tab from local storage
            var activeTabIdOp = localStorage.getItem('activeTabIdOp');
            if (activeTabIdOp) {
                $('.nav-x').removeClass('active');
                $('.tab-pane').removeClass('active');

                $('#' + activeTabIdOp).addClass('active');
                var href = $('#' + activeTabIdOp).attr('href');
                $(href).addClass('active');
            }

            // Save active tab to local storage on click
            $('.nav-x').on('click', function() {
                var id = $(this).attr('id');
                localStorage.setItem('activeTabIdOp', id);
            });
        });
    </script>
    <script>
        var orderCount = {{ $count }};

        for (var i = 1; i <= orderCount; i++) {
            $('#urutan' + i).select2({
                theme: 'bootstrap4',
                dropdownParent: $("#tambahSetting" + i),
                width: $('#urutan' + i).data('width') ? $('#urutan' + i).data('width') : $('#urutan' + i).hasClass(
                    'w-100') ? '100%' : 'style',
                placeholder: $('#urutan' + i).data('placeholder'),
                allowClear: Boolean($('#urutan' + i).data('allow-clear')),
            });

            $('#urutanProses' + i).select2({
                theme: 'bootstrap4',
                dropdownParent: $("#tambahProses" + i),
                width: $('#urutanProses' + i).data('width') ? $('#urutanProses' + i).data('width') : $(
                    '#urutanProses' + i).hasClass('w-100') ? '100%' : 'style',
                placeholder: $('#urutanProses' + i).data('placeholder'),
                allowClear: Boolean($('#urutanProses' + i).data('allow-clear')),
            });
        }
    </script>

    <script>
        const swal = $('.swal').data('swal');
        const swal2 = $('.swal2').data('swal');
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

        if (swal2) {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Proses Gagal',
                text: swal2,
                showConfirmButton: true,
            })
        }
    </script>

    <script>
        function validasiInput(elemen) {
        var menit = document.getElementById('menit');
        var detik = document.getElementById('detik');
            if (elemen.value > 59) {
                elemen.value = 59;
            }
            if (elemen.value.length > 2) {
                elemen.value = elemen.value.slice(-2);
            }
            if (elemen.value.length === 1) {
                elemen.value = "0"+ elemen.value ;
            }
        }
        if (menit.value !== null && !isNaN(menit.value)) {
            menit.value = "00";
        }
    </script>
@endpush
