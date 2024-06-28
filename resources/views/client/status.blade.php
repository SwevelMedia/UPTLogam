<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/ico" href="{{ asset('assets/img/UPT.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <title>
        UPT Logam | Pemesanan
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid justify-content-between d-flex">
            <a class="navbar-brand" href="#" style="border-radius: 100px; overflow: hidden;"><img
                    src="{{ asset('assets/img/uptlogam.png') }}"
                    style="border-radius: 5px; overflow: hidden; height:50px"></a>
        </div>
    </nav>
    <main class="main-content  mt-0">
        <section class="min-vh-100 mb-8">
            <div class="page-header align-items-start min-vh-5 pt-5 pb-11 m-3 border-radius-lg"
                style="background-image: url('{{ asset('assets/img/curved-images/curved14.jpg') }}');">
                <span class="mask bg-gradient-dark opacity-6"></span>
                <div class="container">
                    <div class="row justify-content-center">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                    <div class="col-xl-11 col-lg-12 col-md-11 mx-auto">
                        <div class="card z-index-0">
                            <div class="position-relative">
                                <a href="/order">
                                    <h6 class="text-info m-4"><i class="fas fa-chevron-left"></i> Kembali</h6>
                                </a>
                            </div>
                            <div class="card-header text-center pt-4">
                                <h5>UPT Logam</h5>
                                <h6>Cek Status Pesanan</h6>
                            </div>
                            <div class="swal" data-swal="{{ session('success') }}"></div>
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
                            <div class="row px-xl-5 px-sm-4 px-3">
                                <div class="mt-1 position-relative text-center">
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('check.status') }}">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" id="order_number" name="order_number" class="form-control"
                                            style="height: 50px;" placeholder="Nomor Pesanan" aria-label="Order Number"
                                            aria-describedby="order-number-addon" required>
                                        <button type="submit" class="btn bg-gradient-primary text-white"
                                            style="height: 50px; width:115px">Cek Status</button>
                                    </div>
                                </form>
                                @if (isset($cari) && isset($client))
                                <div class="col-lg-6 row" style="display: flex; flex-wrap: nowrap;">
                                    <p class="col-6 d-inline">Nama Client</p>
                                    <p class="col-1 d-inline">: </p>
                                    <p class="col-5 d-inline">{{ $client->name }}</p>
                                </div>
                                <div class="col-lg-6 row" style="display: flex; flex-wrap: nowrap;">
                                    <p class="col-6 d-inline">Tanggal Pemesanan</p>
                                    <p class="col-1 d-inline">: </p>
                                    <p class="col-5 d-inline">{{ $cari->created_at->format('Y-m-d') }}</p>
                                </div>
                                <div class="col-lg-6 row" style="display: flex; flex-wrap: nowrap;">
                                    <p class="col-6 d-inline">Nama Proyek</p>
                                    <p class="col-1 d-inline">: </p>
                                    <p class="col-5 d-inline">{{ $cari->order_name }}</p>
                                </div>
                                <div class="col-lg-6 row" style="display: flex; flex-wrap: nowrap;">
                                    <p class="col-6 d-inline"><span class="fw-bold text-info">Status Pesanan</span>
                                    </p>
                                </div>
                                @if ($cari->status < 10) <div id="icon-status"
                                    class="col-12 ms-xl-5 ms-lg-5 ms-md-3 ms-sm-2 ms-2 row -mb-5 d-flex"
                                    style="flex-wrap: nowrap;">
                                    <div class="text-center col-2 d-inline ">
                                        <div class="row " style="display: flex; flex-wrap: nowrap;">
                                            <div class="col-1 " style="z-index: 2;">
                                                <span class="badge-custom2 bg-gradient-primary fs-5 ms-2"
                                                    style=" margin-top: 9px; "></span>
                                            </div>
                                            @if ($cari->status < 1) <div
                                                class="col-xl-11 col-lg-11 col-md-10 col-sm-9 col-9 mx-0 px-0 align-center py-3 "
                                                style="z-index: 1;">
                                                <div class="bg-secondary opacity-5 ms-sm-1 mx-xl-0 ms-lg-0 ms-md-0 ms-1"
                                                    style=" height: 3px; width: 95%;"></div>
                                        </div>
                                        @else
                                        <div id="line-1" class="col-12 align-center py-3  ">
                                            <div class="bg-gradient-primary" style=" height: 3px; width: 100%;"></div>
                                        </div>
                                        @endif
                                    </div>
                            </div>
                            <div class="col-2 d-inline mx-0 px-0 ">
                                <div class="row mx-0 px-0" style="display: flex; flex-wrap: nowrap;">

                                    @if ($cari->status < 1) <div class="text-center col-2 d-inline mx-0 px-0">
                                        <div class="border border-secondary border-5 ms-xl-0 ms-lg-0 ms-md-0 ms-sm-1 ms-1 opacity-5 mx-0 rounded-circle d-flex justify-content-center align-items-center"
                                            style="width: 35px; height: 35px;">
                                            <span class="badge-custom2 bg-secondary fs-5 opacity-5"></span>
                                        </div>
                                </div>
                                @else
                                <div class="border col-1 ms-1  border-primary border-5 p-0 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 35px; height: 35px;">
                                    <span class="text-info fs-2 "><i class="fa-solid fa-circle-check"></i></span>
                                </div>
                                @endif
                                @if ($cari->status == 2 || $cari->status == 1)
                                <div class="col-xl-10 col-lg-9 col-md-8 col-sm-7 col-7 mx-0 px-0 align-center py-3 ">
                                    <div class="bg-secondary opacity-5" style=" height: 3px; width: 95%;"></div>
                                </div>
                                @elseif($cari->status < 1) <div
                                    class="col-xl-10 col-lg-10 col-md-9 col-sm-7 col-7 mx-0 px-0 align-center py-3 ">
                                    <div class="bg-secondary opacity-5 ms-xl-1 ms-lg-2 ms-md-3 ms-sm-4 ms-4"
                                        style=" height: 3px; width: 97%;"></div>
                            </div>
                            @else
                            <div class=" col-lg-10 col-md-8 col-sm-7 col-7 mx-0 px-0 align-center py-3 ">
                                <div class="bg-gradient-primary" style=" height: 3px; width: 100%;"></div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-2 d-inline mx-0 px-0 ">
                        <div class="row mx-0 px-0" style="display: flex; flex-wrap: nowrap;">

                            @if ($cari->status < 5) <div class="text-center col-2 d-inline mx-0 px-0">
                                <div class="border border-secondary border-5 ms-xl-0 ms-lg-0 ms-md-0 ms-sm-1 ms-1 opacity-5 mx-0 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 35px; height: 35px;">
                                    <span class="badge-custom2 bg-secondary fs-5 opacity-5"></span>
                                </div>
                        </div>
                        @else
                        <div class="border col-1 ms-1  border-primary border-5 p-0 rounded-circle d-flex justify-content-center align-items-center"
                            style="width: 35px; height: 35px;">
                            <span class="text-info fs-2 "><i class="fa-solid fa-circle-check"></i></span>
                        </div>
                        @endif
                        @if ($cari->status == 5)
                        <div class="col-xl-10 col-lg-9 col-md-8 col-sm-7 col-7 mx-0 px-0 align-center py-3 ">
                            <div class="bg-secondary opacity-5" style=" height: 3px; width: 95%;"></div>
                        </div>
                        @elseif($cari->status < 5) <div
                            class="col-xl-10 col-lg-10 col-md-9 col-sm-7 col-7 mx-0 px-0 align-center py-3 ">
                            <div class="bg-secondary opacity-5 ms-xl-1 ms-lg-2 ms-md-3 ms-sm-4 ms-4"
                                style=" height: 3px; width: 97%;"></div>
                    </div>
                    @else
                    <div class=" col-lg-10 col-md-8 col-sm-7 col-7 mx-0 px-0 align-center py-3 ">
                        <div class="bg-gradient-primary" style=" height: 3px; width: 100%;"></div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-2 d-inline mx-0 px-0 ">
                <div class="row mx-0 px-0" style="display: flex; flex-wrap: nowrap;">

                    @if ($cari->status < 7) <div class="text-center col-2 d-inline mx-0 px-0">
                        <div class="border border-secondary border-5 ms-xl-0 ms-lg-0 ms-md-0 ms-sm-1 ms-1 opacity-5 mx-0 rounded-circle d-flex justify-content-center align-items-center"
                            style="width: 35px; height: 35px;">
                            <span class="badge-custom2 bg-secondary fs-5 opacity-5"></span>
                        </div>
                </div>
                @else
                <div class="border col-1 ms-1  border-primary border-5 p-0 rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 35px; height: 35px;">
                    <span class="text-info fs-2 "><i class="fa-solid fa-circle-check"></i></span>
                </div>
                @endif
                @if ($cari->status == 7)
                <div class=" col-xl-10 col-lg-9 col-md-8 col-sm-6 col-6 mx-0 px-0 align-center py-3 ">
                    <div class="bg-secondary opacity-5 ms-0  " style=" height: 3px; width: 97%;"></div>
                </div>
                @elseif($cari->status < 7) <div
                    class=" col-xl-10 col-lg-10 col-md-9 col-sm-7 col-7 mx-0 px-0 align-center py-3 ">
                    <div class="bg-secondary opacity-5 ms-xl-1 ms-lg-2 ms-md-3 ms-sm-4 ms-4  "
                        style=" height: 3px; width: 97%;"></div>
            </div>
            @else
            <div class=" col-lg-10 col-md-8 col-sm-7 col-7 mx-0 px-0 align-center py-3 ">
                <div class="bg-gradient-primary" style=" height: 3px; width: 100%;"></div>
            </div>
            @endif
            </div>
            </div>
            <div class="col-2 d-inline mx-0 px-0  ">
                <div class="row mx-0 px-0" style="display: flex; flex-wrap: nowrap;">
                    @if ($cari->status < 8) <div class="text-center col-2 d-inline mx-0 px-0">
                        <div class="border border-secondary border-5 opacity-5 mx-0 rounded-circle d-flex justify-content-center align-items-center"
                            style="width: 35px; height: 35px;">
                            <span class="badge-custom2 bg-secondary fs-5 opacity-5"></span>
                        </div>
                </div>
                @else
                <div class="border col-1 ms-1 ms-lg-0 ms-xl-1  border-primary border-5 p-0 rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 35px; height: 35px;">
                    <span class="text-info fs-2 "><i class="fa-solid fa-circle-check"></i></span>
                </div>
                @endif
                @if ($cari->status == 8)
                <div class=" col-lg-10 col-md-8 col-sm-7 col-7 px-0 align-center py-3 ">
                    <div class="bg-secondary opacity-5" style=" height: 3px; width: 95%;"></div>
                </div>
                @elseif ($cari->status <= 7) <div
                    class=" col-lg-10 ms-xl-1 ms-lg-2 ms-md-3 ms-sm-3 ms-3 col-md-9 col-sm-7 col-7 px-0 align-center py-3 ">
                    <div class="bg-secondary opacity-5 ms-sm-1 ms-xl-0 ms-lg-0 ms-md-0 ms-2 "
                        style=" height: 3px; width: 97%;"></div>
            </div>
            @else
            <div class=" col-lg-10 col-md-8 col-sm-7 col-7 mx-0 px-0 align-center py-3 ">
                <div class="bg-gradient-primary" style=" height: 3px; width: 100%;"></div>
            </div>
            @endif
            </div>
            </div>

            @if ($cari->status < 9) <div class="text-center col-2 d-flex mx-0 px-0">
                <div class="border border-secondary border-5 opacity-5 mx-0 rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 35px; height: 35px;">
                    <span class="badge-custom2 bg-secondary fs-5 opacity-5"></span>
                </div>
                </div>
                @else
                <div class="col-2 d-inline mx-0 px-0 ">
                    <div class="row mx-0 px-0" style="display: flex; flex-wrap: nowrap;">
                        <div class="border col-1 ms-1  border-primary border-5 p-0 rounded-circle d-flex justify-content-center align-items-center"
                            style="width: 35px; height: 35px;">
                            <span class="text-info fs-2 "><i class="fa-solid fa-circle-check"></i></span>
                        </div>
                    </div>
                </div>
                @endif

                </div>
                <div id="icon-status-mobile" class="d-none" style="flex-wrap: nowrap;">
                    <div class="container-icon-status">
                        <div id="1" class="d-flex">
                            <div class="d-inline">
                                <div class="col-1">
                                    <span class="badge-custom2 bg-gradient-primary fs-3"
                                        style="margin-left:4px;"></span>
                                </div>
                                <div class="col-12">
                                    <div class=" @if ($cari->status < 1) bg-secondary opacity-5 @else bg-gradient-primary @endif"
                                        style="margin-left:10px; margin-top:-8px; height: 42px; width: 5px;">
                                    </div>
                                </div>
                            </div>
                            <div class="text-right ms-2 mt-1" style="width:230px;"></div>
                        </div>
                        <div id="2" class=" d-flex">
                            <div class="d-inline">
                                <div class="border col-1 ms-1  @if ($cari->status < 1) border-secondary opacity-5 @else border-primary @endif   border-5 p-0 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 35px; height: 35px;">
                                    @if ($cari->status < 1) <span class="badge-custom2 bg-secondary fs-3 opacity-5"
                                        style="margin-left:1px;"></span>
                                        @else
                                        <span class="text-info fs-3 "><i class="fa-solid fa-circle-check"></i></span>
                                        @endif
                                </div>
                                <div class="col-12">
                                    <div class=" @if ($cari->status < 5) bg-secondary opacity-5 @else bg-gradient-primary @endif"
                                        style="margin-left:19px; margin-top:0px; height: 30px; width: 5px;">
                                    </div>
                                </div>
                            </div>
                            <div class="ms-2 mt-1  @if ($cari->status < 1) text-secondary opacity-5 @else text-primary @endif"
                                style="width:230px;">
                                <span class="fw-bold">Diterima</span>
                                <br>
                                @if (isset($diterima))
                                <span class="text-secondary">{{ $diterima->created_at->format('d M Y') }}</span>
                                @endif
                            </div>


                        </div>
                        <div id="3" class=" d-flex">
                            <div class="d-inline">
                                <div class="border col-1 ms-1  @if ($cari->status < 5) border-secondary opacity-5 @else border-primary @endif   border-5 p-0 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 35px; height: 35px;">
                                    @if ($cari->status < 5) <span class="badge-custom2 bg-secondary fs-3 opacity-5"
                                        style="margin-left:1px;"></span>
                                        @else
                                        <span class="text-info fs-3 "><i class="fa-solid fa-circle-check"></i></span>
                                        @endif
                                </div>
                                <div class="col-12">
                                    <div class=" @if ($cari->status < 7) bg-secondary opacity-5 @else bg-gradient-primary @endif"
                                        style="margin-left:19px; margin-top:0px; height: 30px; width: 5px;">
                                    </div>
                                </div>
                            </div>
                            <div class="ms-2 mt-1  @if ($cari->status < 5) text-secondary opacity-5 @else text-primary @endif"
                                style="width:230px;">
                                <span class="fw-bold">Desain</span>
                                <br>
                                @if ($cari->status > 4)
                                <span
                                    class="text-secondary">{{ \Carbon\Carbon::createFromFormat('d/m/Y', $design->stop_actual)->format('d M Y') }}</span>
                                @elseif(isset($estimasidesign))
                                <span class="text-secondary">estimasi
                                    {{ \Carbon\Carbon::createFromFormat('d/m/Y', $estimasidesign->stop_plan)->format('d M Y') }}</span>
                                @endif

                            </div>
                        </div>
                        <div id="4" class=" d-flex">
                            <div class="d-inline">
                                <div class="border col-1 ms-1  @if ($cari->status < 7) border-secondary opacity-5 @else border-primary @endif   border-5 p-0 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 35px; height: 35px;">
                                    @if ($cari->status < 7) <span class="badge-custom2 bg-secondary fs-3 opacity-5"
                                        style="margin-left:1px;"></span>
                                        @else
                                        <span class="text-info fs-3 "><i class="fa-solid fa-circle-check"></i></span>
                                        @endif
                                </div>
                                <div class="col-12">
                                    <div class=" @if ($cari->status < 8) bg-secondary opacity-5 @else bg-gradient-primary @endif"
                                        style="margin-left:19px; margin-top:0px; height: 30px; width: 5px;">
                                    </div>
                                </div>
                            </div>
                            <div class="ms-2 mt-1  @if ($cari->status < 7) text-secondary opacity-5 @else text-primary @endif"
                                style="width:230px;">
                                <span class="fw-bold">Persiapan</span>
                                <br>
                                @if (isset($estimasitools))
                                <span class="text-secondary">estimasi
                                    {{ \Carbon\Carbon::createFromFormat('d/m/Y', $estimasitools->stop_plan)->format('d M Y') }}</span>
                                @endif

                            </div>
                        </div>
                        <div id="5" class=" d-flex">
                            <div class="d-inline">
                                <div class="border col-1 ms-1  @if ($cari->status < 8) border-secondary opacity-5 @else border-primary @endif   border-5 p-0 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 35px; height: 35px;">
                                    @if ($cari->status < 8) <span class="badge-custom2 bg-secondary fs-3 opacity-5"
                                        style="margin-left:1px;"></span>
                                        @else
                                        <span class="text-info fs-3 "><i class="fa-solid fa-circle-check"></i></span>
                                        @endif
                                </div>
                                <div class="col-12">
                                    <div class=" @if ($cari->status < 9) bg-secondary opacity-5 @else bg-gradient-primary @endif"
                                        style="margin-left:19px; margin-top:0px; height: 30px; width: 5px;">
                                    </div>
                                </div>
                            </div>
                            <div class="ms-2 mt-1  @if ($cari->status < 8) text-secondary opacity-5 @else text-primary @endif"
                                style="width:230px;">
                                <span class="fw-bold">Produksi</span>
                                <br>
                                @if (isset($estimasiproduksi))
                                <span class="text-secondary">estimasi
                                    {{ \Carbon\Carbon::createFromFormat('d/m/Y', $estimasiproduksi->start_plan)->format('d M Y') }}</span>
                                @endif

                            </div>
                        </div>
                        <div id="6" class=" d-flex">
                            <div class="d-inline">
                                <div class="border col-1 ms-1  @if ($cari->status < 9) border-secondary opacity-5 @else border-primary @endif   border-5 p-0 rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 35px; height: 35px;">
                                    @if ($cari->status < 9) <span class="badge-custom2 bg-secondary fs-3 opacity-5"
                                        style="margin-left:1px;"></span>
                                        @else
                                        <span class="text-info fs-3 "><i class="fa-solid fa-circle-check"></i></span>
                                        @endif
                                </div>
                            </div>
                            <div class="ms-2 mt-1  @if ($cari->status < 9) text-secondary opacity-5 @else text-primary @endif"
                                style="width:230px;">
                                <span class="fw-bold">Selesai</span>
                                <br>
                                @if (isset($estimasiselesai))
                                <span class="text-secondary">estimasi
                                    {{ \Carbon\Carbon::createFromFormat('d/m/Y', $estimasiselesai->stop_plan)->format('d M Y') }}</span>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>

                <div id="ket-status" class="col-12 row d-flex" style=" flex-wrap: nowrap;">
                    <div class="text-center ms-xl-1 ms-lg-1 ms-md-1 ms-sm-0 ms-0 col-2 d-flex ">

                    </div>
                    @if ($cari->status < 1) <div
                        class="text-center px-0 col-2 ms-0  ms-xl-4 ms-lg-4 ms-md-0 ms-sm-0 d-flex ">
                        <p class="text-secondary opacity-5 ms-xl-4 ms-lg-4 ms-md-3 ms-sm-2 ms-2 ">
                            Diterima</p>
                </div>
                @else
                <div class="text-center px-0 col-2 ms-0  ms-xl-4 ms-lg-4 ms-md-0 ms-sm-0 d-flex ">
                    <p class="text-primary ms-xl-4 ms-lg-4 ms-md-3 ms-sm-2 ms-2 ">
                        Diterima</p>
                </div>
                @endif
                @if ($cari->status < 5) <div class="text-center px-0 ms-xl-1 ms-lg-1 ms-md-0 ms-sm-0 ms-0 col-2 d-flex">
                    <p class="text-secondary opacity-5 ms-xl-4 ms-lg-4 ms-md-4 ms-sm-3 ms-3">
                        Desain</p>
                    </div>
                    @else
                    <div class="text-center px-0 ms-xl-1 ms-lg-1 ms-md-0 ms-sm-0 ms-0 col-2 d-flex">
                        <p class="text-primary  ms-xl-4 ms-lg-4 ms-md-4 ms-sm-3 ms-3">
                            Desain</p>
                    </div>
                    @endif
                    @if ($cari->status < 7) <div class="text-start px-0 ms-xl-0 ms-lg-0 ms-md-0 ms-0  col-2 d-flex">
                        <p class="text-secondary opacity-5 ms-0 ms-xl-3 ms-lg-3 ms-md-2 ms-sm-0">
                            Persiapan</p>
                        </div>
                        @else
                        <div class="text-start px-0 ms-xl-0 ms-lg-0 ms-md-0 ms-0  col-2 d-flex">
                            <p class="text-primary  ms-0 ms-xl-3 ms-lg-3 ms-md-2 ms-sm-0">
                                Persiapan</p>
                        </div>
                        @endif
                        @if ($cari->status < 8) <div class="text-center px-0 ms-xl-3 ms-lg-3 ms-md-3 col-2 d-flex">
                            <p class="text-secondary opacity-5 ms-2 ms-xl-1 ms-lg-1 ms-md-0 ms-sm-2">
                                Produksi</p>
                            </div>
                            @else
                            <div class="text-center px-0 ms-xl-3 ms-lg-3 ms-md-3 col-2 d-flex">
                                <p class="text-primary  ms-2 ms-xl-1 ms-lg-1 ms-md-0 ms-sm-2">
                                    Produksi</p>
                            </div>
                            @endif
                            @if ($cari->status < 9) <div
                                class="text-center px-0 ms-xl-2 ms-lg-2 ms-md-2 ms-sm-3 ms-3 col-2 d-flex">
                                <p class="text-secondary opacity-5">Selesai</p>
                                </div>
                                @else
                                <div class="text-center px-0 ms-xl-2 ms-lg-2 ms-md-2  ms-sm-3 ms-3 col-2 d-flex">
                                    <p class="text-primary ">Selesai</p>
                                </div>
                                @endif
                                </div>
                                @else
                                <span class="badge-custom bg-danger me-2"></span>
                                Decline
                                @endif
                                @elseif(isset($orderNumber))
                                {{ '' }}
                                @else
                                <p class="mx-2 text-danger">Silahkan Masukkan Nomer Pesanan yang benar</p>
                                @endif
                                </div>

                                </div>
                                </div>
                                </div>
                                </div>
        </section>
        <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <footer class="footer py-5">
            <div class="container">

                <div class="row">
                    <div class="col-8 mx-auto text-center mt-1">
                        <p class="mb-0 text-sm text-muted">
                            © dibuat oleh
                            <a href="https://beecons.co.id/" class="font-weight-bold" target="_blank">PT Baracipta
                                Esa
                                Engineering
                            </a>
                            <script>
                            document.write(new Date().getFullYear())
                            </script>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    </main>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    const swal = $('.swal').data('swal');
    if (swal) {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Success',
            text: swal,
            showConfirmButton: false,
            timer: 4000
        })
    }
    window.addEventListener('resize', function() {
        if (window.innerWidth < 525) {
            document.getElementById('ket-status').classList.remove('d-flex');
            document.getElementById('icon-status').classList.remove('d-flex');
            document.getElementById('ket-status').classList.add('d-none');
            document.getElementById('icon-status').classList.add('d-none');
            document.getElementById('icon-status-mobile').classList.remove('d-none');
            document.getElementById('icon-status-mobile').classList.add('d-flex');
        } else {
            document.getElementById('ket-status').classList.remove('d-none');
            document.getElementById('icon-status').classList.remove('d-none');
            document.getElementById('ket-status').classList.add('d-flex');
            document.getElementById('icon-status').classList.add('d-flex');
            document.getElementById('icon-status-mobile').classList.remove('d-flex');
            document.getElementById('icon-status-mobile').classList.add('d-none');
        }
    });

    // Trigger resize event once when the page loads
    window.dispatchEvent(new Event('resize'));
    </script>





</body>

</html>
