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
                            <td class="text-wrap text-start">:
                                : <a href="#" onclick="hubungi()"> {{ $order->client->phone }}
                                    <i class="fa-brands fa-whatsapp ms-2 fs-5 text-success"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-sm">Alamat</th>
                            <td class="text-wrap text-start">: {{ $order->client->address }}</td>
                        </tr>

                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p class="h6 text-center">Durasi Pengerjaan</p>

            <div class="row justify-content-center">
                <div class="col-8 mb-3">
                    <table class="table">
                        <tr>
                            <th class="bg-light">DESC</th>
                            <th class="bg-light">Durasi</th>
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
                                        <td class="text-sm">CAD</td>
                                        <td>{{ $actual_time }}</td>
                                    </tr>
                                @endif
                                @if ($jadwal->desc == 'CAM' && $jadwal->stop_actual != null)
                                    <tr>
                                        <td>CAM</td>
                                        <td>{{ $actual_time }}</td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach

                        <tr>
                            <td>Produksi (Mesin)</td>
                            <td>{{ $waktuMesin }}</td>
                        </tr>
                        <tr>
                            <td>Produksi (Operator)</td>
                            <td>{{ $waktuOp }}</td>
                        </tr>
                        <tr></tr>
                    </table>

                    <div class="px-2">
                        @if ($order->status == 8)
                            <form action="{{ url('approve-produksi/' . $order->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn bg-gradient-primary w-100">Approve</button>
                            </form>
                        @else
                            <p class="h6 text-success text-center">
                                <i class="fa-regular fa-circle-check"></i> Proyek Selesai
                            </p>
                        @endif
                    </div>
                </div>
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
