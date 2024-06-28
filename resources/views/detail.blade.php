@extends('layouts.template')

@push('css')
    <style>
        @media screen and (min-width: 768px) {
            .gambar {
                width: 600px;
                height: 400px;
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
        }
    </style>
@endpush

@section('content')
    <div class="card mb-4 ">
        <div class="card-header border-bottom mb-3 pb-0 bg-gradient-primary">
            <div class="d-flex justify-content-between">
                <a href="{{ url()->previous() }}">
                    <h6 class="text-info"><i class="fas fa-chevron-left" style="width: auto"></i> Kembali</h6>
                </a>
                <p class="h4 fw-bolder text-uppercase text-white mx-0 mx-sm-5 mx-md-5 mx-lg-5 mx-xl-5 text-end"
                    style="width: 60%">
                    {{ $order->order_name }}</p>
            </div>

        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="swalwarning" data-swal="{{ session('warning') }}"></div>
        <div class="card-body px-0 pt-0 p-3">
            @if ($errors->any())
                <div class="my-2 mx-3">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-white">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <table class="table align-items-center mb-0 px-sm-3">
                        <tr>
                            <th style="width: 140px !important;">Nomor Pesanan</th>
                            <td class="text-wrap text-start">: {{ $order->order_number }}</td>
                        </tr>
                        <tr>
                            <th>Material</th>
                            <td class="text-wrap text-start">:
                                @if (count($material) > 0)
                                    @foreach ($material as $mat)
                                        {{ $mat->material->name }}
                                    @endforeach
                                @else
                                    {{ $order->material }}
                                @endif
                            </td>
                        </tr>
                        @if (count($mesin) > 0)
                            <tr>
                                <th>Mesin</th>
                                <td class="text-wrap text-start">:
                                    @foreach ($mesin as $msn)
                                        {{ $msn->mesin->name . ', ' }}
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                        @if (count($gambarUpload) > 0)
                            <tr>
                                <th>File Desain</th>
                                <td class="text-wrap text-start">:
                                    @foreach ($gambarUpload as $key => $gu)
                                        <a class="text-pink text-sm" href="{{ asset('file/'.$order->order_number. "/" . $gu->path) }}"
                                            target="_blank">
                                            {{ $gu->path }}
                                        </a>
                                        @if ($key < count($gambarUpload) - 1)
                                            |
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <th>Status </th>
                            <td class="text-wrap text-start">:
                                @if ($order->status == 0)
                                    <span class="badge-custom bg-warning me-2"></span>Pending
                                @elseif($order->status <= 1)
                                    <span class="badge-custom bg-warning me-2"></span>Need Confirm
                                @elseif($order->status <= 2)
                                    <span class="badge-custom bg-secondary me-2">
                                    </span>Scheduling
                                @elseif($order->status <= 7)
                                    @if ($order->status == 4 || $order->status == 3)
                                        <span class="badge-custom bg-info me-2"></span>Desain CAD
                                    @elseif($order->status == 6 || ($order->status == 5 && $order->cad_approv == 1))
                                        <span class="badge-custom bg-info me-2"></span>Desain CAM
                                    @elseif ($order->status == 5 && $order->cad_approv == 0)
                                        <span class="badge-custom bg-warning me-2"></span>Approval Desain CAD
                                    @elseif ($order->status == 5 && $order->cad_approv == 2)
                                        <span class="badge-custom bg-warning me-2"></span>Revisi Desain CAD
                                    @elseif($order->status == 7 && $order->cam_approv == 0)
                                        <span class="badge-custom bg-warning me-2"></span>Approval Desain CAM
                                    @elseif($order->status == 7 && $order->cam_approv == 2)
                                        <span class="badge-custom bg-warning me-2"></span>Revisi Desain CAM
                                    @elseif($order->status == 7 && $order->cam_approv == 1)
                                        <span class="badge-custom bg-info me-2">
                                        </span>Toolkit
                                    @endif
                                @elseif($order->status <= 8)
                                    <span class="badge-custom bg-info me-2">
                                    </span>Production
                                @elseif($order->status == 9)
                                    <span class="badge-custom bg-success me-2"></span>Done
                                @elseif($order->status == 10)
                                    <span class="badge-custom bg-danger me-2"></span>Decline
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table align-items-center mb-0 px-sm-3">
                        <tr>
                            <th style="width: 140px !important;">Client</th>
                            <td class="text-wrap text-start">: {{ $order->client->name }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td class="text-wrap text-start">: {{ $order->client->phone }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td class="text-wrap text-start">: {{ $order->client->address }}</td>
                        </tr>
                        <tr>
                            <th>File Client</th>

                            <td class="text-wrap text-start">:
                                @if (count($gambarClient) == 0)
                                    <span class="text-secondary"> Tidak ada File dari
                                        client</span>
                                @else
                                    @foreach ($gambarClient as $gambar)
                                        @if (pathinfo(asset('file/client/' . $gambar->path), PATHINFO_EXTENSION) == 'jpg' ||
                                                pathinfo(asset('file/client/' . $gambar->path), PATHINFO_EXTENSION) == 'png' ||
                                                pathinfo(asset('file/client/' . $gambar->path), PATHINFO_EXTENSION) == 'jpeg')
                                            <a class="text-pink text-sm" style="cursor: pointer" data-bs-toggle="modal"
                                                data-bs-target="#modal{{ $gambar->id }}">
                                                File
                                                {{ $loop->iteration }}.{{ pathinfo(asset('file/client/' . $gambar->path), PATHINFO_EXTENSION) }}
                                            </a> |
                                        @else
                                            <a class="text-pink text-sm"
                                                href="{{ asset('file/client/' . $gambar->path) }}" target="_blank">
                                                File
                                                {{ $loop->iteration }}.{{ pathinfo(asset('file/client/' . $gambar->path), PATHINFO_EXTENSION) }}
                                            </a> |
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
                                                            src="{{ asset('file/client/' . $gambar->path) }}"
                                                            type="application/pdf" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                        </tr>


                    </table>
                </div>

            </div>


            @if ($order->status > 1)
                <div class="table-responsive mt-3">
                    <table class="table px-sm-3 ">
                        <tr class="bg-light">
                            <th class="text-center text-sm">Desc</th>
                            <th class="text-center text-sm">Nama</th>
                            <th class="text-center text-sm">Start Plan</th>
                            <th class="text-center text-sm">Start Actual</th>
                            <th class="text-center text-sm">Stop Plan</th>
                            <th class="text-center text-sm">Stop Actual</th>
                            <th class="text-center text-sm">Durasi</th>
                        </tr>
                        @foreach ($jadwal as $item)
                            <tr>
                                @if ($order->status > 2 && $item->desc == 'CAD')
                                    <th class="text-center text-sm text-sm">{{ $item->desc }}</th>
                                    <td class="text-center text-sm text-sm">
                                        @isset($item->employee->name)
                                            {{ $item->employee->name }}
                                        @endisset
                                    </td>
                                    <td class="text-center text-sm text-sm">{{ $item->start_plan }}</td>
                                    <td class="text-center text-sm text-sm">
                                        @if ($item->start_actual != null)
                                            {{ date('d/m/Y | H:i:s', strtotime($item->start_actual)) }}
                                        @else
                                            @if (auth()->user()->role == 'drafter' && auth()->user()->id == $item->users_id)
                                                <form action="{{ url('prog/start-cad') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="order_number"
                                                        value="{{ $order->order_number }}">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-primary mb-0">Start</button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center text-sm">{{ $item->stop_plan }}</td>
                                    <td class="text-center text-sm">
                                        @if ($item->stop_actual != null)
                                            {{ date('d/m/Y | H:i:s', strtotime($item->stop_actual)) }}
                                        @elseif(auth()->user()->id == $item->users_id && $item->start_actual != null)
                                            <button class="btn btn-sm btn-primary mb-0" data-bs-toggle="modal"
                                                data-bs-target="#modalCad{{ $item->id }}">Upload</button>
                                        @endif
                                    </td>
                                @endif
                                @if ($order->status > 4 && $item->desc == 'CAM')
                                    <th class="text-center text-sm">{{ $item->desc }}</th>
                                    <td class="text-center text-sm">
                                        @isset($item->employee->name)
                                            {{ $item->employee->name }}
                                        @endisset
                                    </td>
                                    <td class="text-center text-sm">{{ $item->start_plan }}</td>
                                    <td class="text-center text-sm">
                                        @if ($item->start_actual != null)
                                            {{ date('d/m/Y | H:i:s', strtotime($item->start_actual)) }}
                                        @else
                                            @if (auth()->user()->role == 'programmer' && auth()->user()->id == $item->users_id && $order->cad_approv == '1')
                                                <form action="{{ url('prog/start-cam') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="order_number"
                                                        value="{{ $order->order_number }}">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-primary mb-0">Start</button>
                                                </form>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center text-sm">{{ $item->stop_plan }}</td>
                                    <td class="text-center text-sm">
                                        @if ($item->stop_actual != null)
                                            {{ date('d/m/Y | H:i:s', strtotime($item->stop_actual)) }}
                                        @elseif(auth()->user()->id == $item->users_id && $item->start_actual != null)
                                            <a class="btn btn-sm btn-primary mb-0"
                                                href="{{ url('desain/cam/' . $order->id) }}">
                                                Upload</a>
                                        @endif
                                    </td>
                                @endif
                                @if ($order->status > 6 && $item->desc == 'TOOLS')
                                    <th class="text-center text-sm">{{ $item->desc }}</th>
                                    <td class="text-center text-sm">
                                        @isset($item->employee->name)
                                            {{ $item->employee->name }}
                                        @endisset
                                    </td>
                                    <td class="text-center text-sm">{{ $item->start_plan }}</td>
                                    <td class="text-center text-sm">
                                        @if ($item->start_actual != null)
                                            {{ date('d/m/Y | H:i:s', strtotime($item->start_actual)) }}
                                        @else
                                            @if (auth()->user()->role == 'toolman' && auth()->user()->id == $item->users_id && $order->cam_approv == 1)
                                                <form action="{{ url('tool/start') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="order_number"
                                                        value="{{ $order->order_number }}">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-primary mb-0">Start</button>
                                                </form>
                                            @endif
                                        @endif

                                    </td>
                                    <td class="text-center text-sm">{{ $item->stop_plan }}</td>
                                    <td class="text-center text-sm">


                                        @if ($item->stop_actual)
                                            {{ date('d/m/Y | H:i:s', strtotime($item->stop_actual)) }}
                                        @elseif (auth()->user()->role == 'toolman' && auth()->user()->id == $item->users_id && $item->start_actual != null)
                                            <form action="{{ url('tool/start') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="order_number"
                                                    value="{{ $order->order_number }}">
                                                <a href="{{ url('tool/order/' . $order->id) }}" type="submit"
                                                    class="btn btn-sm btn-primary mb-0">Pilih
                                                    Alat</a>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                                <td class="text-center text-sm">
                                    @php
                                        $actual_time = '';
                                    @endphp
                                    @if ($item->start_actual != null && $item->stop_actual != null)
                                        @php
                                            $start = new DateTime($item->start_actual);
                                            $stop = new DateTime($item->stop_actual);
                                            $diff = $start->diff($stop);

                                            // Format selisih waktu ke jam, menit, detik
                                            $actual_time = $diff->format('%H:%I:%S');
                                        @endphp
                                        {{ $actual_time }}
                                    @endif

                                </td>

                            </tr>

                            <!-- Modal Upload Cad-->
                            <div class="modal fade" id="modalCad{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="staticBackdropLabel" data-bs-backdrop="static" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-gradient-primary">
                                            <h5 class="modal-title text-white" id="exampleModalLabel">Upload Desain
                                                CAD</h5>
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ url('prog/upload-cad') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="my-4">
                                                    <label for="">Upload File</label>
                                                    <input type="file" required name="cad" id="cadFile"
                                                        class="form-control mb-2" accept=".pdf">
                                                    <input type="hidden" name="order_number"
                                                        value="{{ $order->order_number }}">
                                                    <label for="">Keterangan</label>
                                                    <input type="text" class="form-control" name="information">
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <button type="submit"
                                                        class="btn btn-sm bg-gradient-primary">Upload</button>
                                                </div>
                                            </form>

                                            <div id="pdfViewer"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($order->status > 7)
                            @php
                                $firstStart = true;
                                $firstStop = true;
                            @endphp
                            @foreach ($jadwalProduksi as $key => $value)
                                <tr>
                                    <th class="text-center text-sm">{{ $value->desc }}</th>
                                    <td class="text-center text-sm">
                                        @isset($value->employee->name)
                                            {{ $value->employee->name }}
                                        @endisset
                                    </td>
                                    <td class="text-center text-sm">{{ $value->start_plan }}</td>
                                    <td class="text-center text-sm">
                                        @if ($value->start_actual != null)
                                            {{ date('d/m/Y | H:i:s', strtotime($value->start_actual)) }}
                                        @else
                                            @if (auth()->user()->role == 'operator' && $firstStart && $firstStop)
                                                <form action="{{ url('operator/start') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="order_number"
                                                        value="{{ $order->order_number }}">
                                                    <input type="hidden" name="desc" value="{{ $value->desc }}">
                                                    <button type="submit"
                                                        class="btn btn-sm btn-primary mb-0">Start</button>
                                                </form>
                                                @php
                                                    $firstStart = false;
                                                    $firstStop = false;
                                                @endphp
                                            @endif
                                        @endif

                                    </td>
                                    <td class="text-center text-sm">{{ $value->stop_plan }}</td>
                                    <td class="text-center text-sm">
                                        @if ($value->stop_actual != null)
                                            {{ date('d/m/Y | H:i:s', strtotime($value->stop_actual)) }}
                                        @elseif(auth()->user()->id == $value->users_id && $value->start_actual != null)
                                            <a href="{{ url('operator/produksi/' . $order->id) }}"
                                                class="btn btn-sm btn-primary mb-0">Produksi</a>
                                            @php
                                                $firstStop = false;
                                            @endphp
                                        @endif
                                    </td>
                                    <td class="text-center text-sm">
                                        @php
                                            $actual_time = '';
                                        @endphp
                                        @if ($value->start_actual != null && $value->stop_actual != null)
                                            @php
                                                $start = new DateTime($value->start_actual);
                                                $stop = new DateTime($value->stop_actual);
                                                $diff = $start->diff($stop);

                                                // Format selisih waktu ke jam, menit, detik
                                                $actual_time = $diff->format('%H:%I:%S');
                                            @endphp
                                            {{ $actual_time }}
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </table>
                </div>
            @elseif(auth()->user()->role == 'ppic')
                <hr class="bg-primary">
                <div class="d-flex justify-content-end p-3">
                    <button type="button" class="text-center text-sm btn btn-danger btn-sm decline-btn me-3"
                        data-bs-toggle="modal" data-bs-target="#declineModal" onclick="setOrderId({{ $order->id }})">
                        Tolak
                    </button>


                    @if ($order->status == 0)
                        <button class="text-center text-sm btn btn-success btn-sm accept-btn me-3"
                            data-orderid="{{ $order->id }}" data-status="1" data-bs-toggle="modal"
                            data-bs-target="#modalPertama{{ $order->id }}">
                            Terima
                        </button>
                    @elseif ($order->status == 1)
                        <a href="{{ url('order/konfirmasi/' . $order->id) }}"
                            class="text-center text-sm btn btn-success btn-sm accept-btn me-3">
                            Need Confirm
                        </a>
                    @elseif ($order->status == 2)
                        <a href="{{ url('order/jadwal/' . $order->id) }}"
                            class="text-center text-sm btn btn-success btn-sm accept-btn me-3">
                            <i class="fa-solid fa-calendar-days fs-6"></i>
                        </a>
                    @endif
                </div>


                <!-- Modal Pertama -->
                <div class="modal fade" id="modalPertama{{ $order->id }}" tabindex="-1"
                    aria-labelledby="modalPertamaLabel{{ $order->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalPertamaLabel{{ $order->id }}">
                                    Konfirmasi
                                    Pesanan {{ $order->order_name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form id="formPilihMesin{{ $order->id }}" data-order-id="{{ $order->id }}"
                                method="POST" action="{{ url('order/pilih-mesin/' . $order->id) }}">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="status" value="1">
                                <div class="modal-body">

                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <label class="form-label">Pilih Mesin</label>
                                    <div class="row px-3 mb-3">
                                        @php
                                            $displayedNames = [];
                                        @endphp
                                        @foreach ($machines as $item)
                                            @if (!in_array($item->name, $displayedNames))
                                                <div class="form-check col-sm-4">
                                                    <input class="form-check-input" type="checkbox" name="mesin[]"
                                                        value="{{ $item->id }}" id="mesin{{ $item->id }}">
                                                    <label class="form-check-label"
                                                        for="mesin{{ $item->id }}">{{ $item->name }}</label>
                                                </div>
                                                <?php $displayedNames[] = $item->name; ?>
                                            @endif
                                        @endforeach
                                    </div>

                                    <label class="form-label">Perlu Desain</label>
                                    <div class="row px-3 mb-3">
                                        <div class="form-check col-sm-4">
                                            <input class="form-check-input" type="radio" name="need_design"
                                                value="1" id="ya">
                                            <label class="form-check-label" for="ya">Iya</label>
                                        </div>
                                        <div class="form-check col-sm-4">
                                            <input class="form-check-input" type="radio" name="need_design"
                                                value="0" id="tidak">
                                            <label class="form-check-label" for="tidak">Tidak</label>
                                        </div>
                                    </div>

                                    <label class="form-label">Pilih Material</label>
                                    <div class="row px-3">
                                        @foreach ($materials as $material)
                                            <div class="form-check col-sm-4">
                                                <input class="form-check-input" type="radio" name="material"
                                                    value="{{ $material->id }}" id="material{{ $material->id }}">
                                                <label class="form-check-label"
                                                    for="material{{ $material->id }}">{{ $material->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Next <i
                                            class="fas fa-angle-right"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Modal Decline -->
                <div class="modal fade" id="declineModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title text-white" id="exampleModalLabel">Tolak Pesanan</h5>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                    aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                Yakin tolak pesanan {{ $order->order_name . ' (' . $order->order_number . ')' }}
                                <div class="form-group ">
                                    <label for="message-text" class="col-form-label">Alasan Ditolak:</label>
                                    <textarea class="form-control" class="form-control" id="message-text" rows="4" name="alasan_penolakan"
                                        required></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <!-- Tombol OK untuk menyetujui penolakan -->
                                <button type="button" class="btn btn-danger" onclick="confirmDecline()">OK</button>
                                <!-- Tombol tutup modal -->
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <script>
        const swal = $('.swal').data('swal');
        const swalwarning = $('.swalwarning').data('swal');
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
        if (swalwarning) {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: swalwarning,
                showConfirmButton: true,
            })
        }
    </script>
    <script>
        function confirmDecline() {
            var orderId = "{{ $order->id }}";

            var message = document.getElementById("message-text").value;

            if (message.trim() === "") {
                alert("Mohon isi alasan penolakan.");
            } else {
                window.location.href = "/order/decline/" + orderId + "/" + message;
                confirmDeclineWithWhatsApp(orderId);
            }

        }

        function confirmDeclineWithWhatsApp(orderId) {
            var nomorPelanggan = "{{ $order->client->phone }}";
            var nomorPesanan = "{{ $order->order_number }}";
            var alasanPenolakan = document.getElementById("message-text").value;
            var pesan = "Pesanan " + nomorPesanan + " ditolak. Alasan: " + alasanPenolakan;

            var formattedMessage = encodeURIComponent(pesan);
            var formattedPhoneNumber = nomorPelanggan.replace(/\D/g, '');

            var whatsappMessage = "https://api.whatsapp.com/send?phone=62" + formattedPhoneNumber + "&text=" +
                formattedMessage;

            window.open(whatsappMessage, '_blank');
        }
    </script>
    <script>
        // Fungsi untuk menampilkan file PDF yang dipilih
        function showPDF(input) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const pdfViewer = document.getElementById('pdfViewer');
                pdfViewer.innerHTML =
                    `<embed src="${e.target.result}" width="100%" height="600px" type="application/pdf" />`;
            };

            reader.readAsDataURL(file);
        }

        // Panggil fungsi showPDF saat file dipilih
        document.getElementById('cadFile').addEventListener('change', function() {
            showPDF(this);
        });
    </script>
@endpush
