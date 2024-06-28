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
                <div class="my-3">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-white">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table align-items-center mb-0 px-sm-3">
                        <tr>
                            <th class="text-sm" style="width: 140px !important;">Nomor Pesanan</th>
                            <td class="text-wrap text-start">: {{ $order->order_number }}</td>
                        </tr>
                        <tr>
                            <th class="text-sm">Material</th>
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
                                <th class="text-sm">Mesin</th>
                                <td class="text-wrap text-start">:
                                    @foreach ($mesin as $msn)
                                        {{ $msn->mesin->name . ', ' }}
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                        @if (count($gambarUpload) > 0)
                            <tr>
                                <th class="text-sm">File Desain</th>
                                <td class="text-wrap text-start">:
                                    @foreach ($gambarUpload as $key => $gu)
                                        <a class="text-pink text-sm"
                                            href="{{ asset('file/' . $order->order_number . '/' . $gu->path) }}"
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
                            <th class="text-sm">Status</th>
                            <td>:
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


                        @foreach ($order->schedule as $jadwal)
                            @if ($jadwal->desc == 'CAD' || $jadwal->desc == 'CAM')
                                @php
                                    $actual_time = '';
                                    $start = new DateTime($jadwal->start_actual);
                                    $stop = new DateTime($jadwal->stop_actual);
                                    $diff = $start->diff($stop);

                                    // Format selisih waktu ke jam, menit, detik
                                    $actual_time = $diff->format('%H:%I:%S');
                                @endphp
                                @if ($jadwal->desc == 'CAD')
                                    <tr>
                                        <th class="text-sm">Waktu Desain</th>
                                        <td>:
                                            CAD <i class="fa-solid fa-arrow-right fs-6"></i> {{ $actual_time }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($jadwal->desc == 'CAM' && $jadwal->stop_actual != null)
                                    <tr>
                                        <td></td>
                                        <td>: CAM <i class="fa-solid fa-arrow-right fs-6"></i>
                                            {{ $actual_time }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach

                        @if ($order->status == 7)
                            <tr>
                                <th class="text-sm">Produksi</th>
                                <td>: {{ $operatorProses }} Proses</td>
                            </tr>
                        @endif

                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table align-items-center mb-0 px-sm-3">
                        <tr>
                            <th class="text-sm" style="width: 140px !important;">Client</th>
                            <td class="text-wrap text-start">: {{ $order->client->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-sm">Telepon</th>
                            <td class="text-wrap text-start">
                                : <a href="#" onclick="hubungi()"> {{ $order->client->phone }} 
                                <i class="fa-brands fa-whatsapp ms-2 fs-5 text-success"></i></a>
                                
                            </td>
                        </tr>
                        <tr>
                            <th class="text-sm">Alamat</th>
                            <td class="text-wrap text-start">: {{ $order->client->address }}</td>
                        </tr>
                        <tr>
                            <th class="text-sm">File Client</th>

                            <td class="text-wrap text-start">:
                                @if (count($gambarClient) == 0)
                                    <span class="text-secondary"> Tidak ada File dari
                                        client</span>
                                @else
                                    @foreach ($gambarClient as $gambar)
                                        @if (pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) == 'jpg' ||
                                                pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) == 'png' ||
                                                pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) == 'jpeg')
                                            <a class="text-pink text-sm" style="cursor: pointer" data-bs-toggle="modal"
                                                data-bs-target="#modal{{ $gambar->id }}">
                                                File
                                                {{ $loop->iteration }}.{{ pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) }}
                                            </a> |
                                        @else
                                            <a class="text-pink text-sm"
                                                href="{{ asset('storage/image/order/' . $gambar->path) }}" target="_blank">
                                                File
                                                {{ $loop->iteration }}.{{ pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) }}
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
                    </table>
                </div>
            </div>
            <div class="mx-5">
                {{-- <div class="mb-4">
                    @foreach ($gambarUpload as $file)
                        <a class="text-pink" href="{{ asset('storage/image/order/' . $file->path) }}" target="_blank">
            {{ $file->path }}
            </a>
            <embed class="mb-3" src="{{ asset('storage/image/order/' . $file->path) }}" width="100%" height="600px"
                type="application/pdf" />
            @endforeach
        </div> --}}


                <div class="d-flex justify-content-end">
                    @if (($order->cad_approv == '0' && $order->status == 5) || ($order->cam_approv == '0' && $order->status == 7))
                        <button class="btn bg-gradient-danger me-2"
                            style="width: 150px; height: 40px; display: flex; justify-content: center; align-items: center;"
                            data-bs-toggle="modal" data-bs-target="#declineModal">
                            <span style="white-space: nowrap; text-overflow: ellipsis;">Batalkan
                                Pesanan</span>
                        </button>
                        <button class="btn bg-gradient-primary me-2"
                            style="width: 150px; height: 40px; display: flex; justify-content: center; align-items: center;"
                            data-bs-toggle="modal" data-bs-target="#revisi">
                            <span style="white-space: nowrap; text-overflow: ellipsis;">Revisi
                                Desain</span>
                        </button>
                        <button class="btn bg-gradient-success me-2"
                            style="width: 150px; height: 40px; display: flex; justify-content: center; align-items: center;"
                            data-bs-toggle="modal" data-bs-target="#approve">
                            <span style="white-space: nowrap; text-overflow: ellipsis;">Approve
                                Desain</span>
                        </button>
                    @elseif(
                        ($order->cad_approv == 1 && $order->status == 5 && $order->need_design == 1) ||
                            ($order->cam_approv == 1 && $order->status == 7))
                        <p class="h5 text-success me-3"><i class="fa-regular fa-circle-check"></i> Desain Approved</p>
                        <form action="{{ url('approve-cad/back') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">

                            <button type="submit"
                                class="text-center btn btn-secondary bg-dradient btn-sm detail-btn px-3">
                                <i class="fa-solid fa-arrow-rotate-right fs-6"></i>
                            </button>
                        </form>
                    @elseif(
                        ($order->cad_approv == 2 && $order->status == 5 && $order->need_design == 1) ||
                            ($order->cam_approv == 2 && $order->status == 7))
                        <p class="h5 text-warning me-3"><i class="fa-solid fa-triangle-exclamation"></i> Desain Akan
                            Direvisi</p>
                        <form action="{{ url('approve-cad/back') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">

                            <button type="submit"
                                class="text-center btn btn-secondary bg-dradient btn-sm detail-btn px-3">
                                <i class="fa-solid fa-arrow-rotate-right fs-6"></i>
                            </button>
                        </form>
                    @elseif($order->status == 10)
                        <p class="h5 text-danger me-3"><i class="fa-regular fa-circle-xmark"></i> Pesanan Ditolak</p>
                        <form action="{{ url('approve-cad/back-decline') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">

                            <button type="submit"
                                class="text-center btn btn-secondary bg-dradient btn-sm detail-btn px-3">
                                <i class="fa-solid fa-arrow-rotate-right fs-6"></i>
                            </button>
                        </form>
                    @elseif($order->cad_approv == 1 && $order->need_design == 0)
                        <p class="h5 text-success me-3"><i class="fa-regular fa-circle-check"></i> Desain Approved</p>
                    @endif
                </div>

            </div>

        </div>
    </div>

    {{-- Modal Approve --}}
    <div class="modal fade" id="approve" tabindex="-1" aria-labelledby="approveLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-success">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('approve-cad') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                        <h5 class="modal-title mb-3" id="approveLabel">Approve Desain ?</h5>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Revisi --}}
    <div class="modal fade" id="revisi" tabindex="-1" aria-labelledby="revisiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="revisiLabel">Revisi Desain</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('revisi-cad') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                        <div class="mb-3">
                            <label for="description" class="fs-6">Deskripsi Revisi</label>
                            <textarea class="form-control" required class="form-control" rows="4" name="description"></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Decline -->
    <div class="modal fade" id="declineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Tolak Pesanan</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{ url('order-decline') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        Yakin tolak pesanan {{ $order->order_name . ' (' . $order->order_number . ')?' }}
                        <div class="form-group ">
                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                            <label class="col-form-label">Alasan Ditolak:</label>
                            <textarea class="form-control" required class="form-control" rows="4" name="description"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <!-- Tombol OK untuk menyetujui penolakan -->
                        <button type="submit" class="btn btn-danger">OK</button>
                        <!-- Tombol tutup modal -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
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
        function hubungi(orderId) {
            var nomorPelanggan = "{{ $order->client->phone }}";
            var nomorPesanan = "{{ $order->order_number }}";
            var pesan = "Terkait dengan pesanan dengan nomor Order " + nomorPesanan + " anda ";

            var formattedMessage = encodeURIComponent(pesan);
            var formattedPhoneNumber = nomorPelanggan.replace(/\D/g, '');

            var whatsappMessage = "https://api.whatsapp.com/send?phone=62" + formattedPhoneNumber + "&text=" +
                formattedMessage;

            window.open(whatsappMessage, '_blank');
        }
    </script>
@endpush
