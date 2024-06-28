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
    <div class="card mb-4 px-3">
        <div class="card-header border-bottom mb-3 pb-0">
            <a href="{{ url()->previous() }}">
                <h6 class="text-info"><i class="fas fa-chevron-left"></i> Kembali</h6>
            </a>
            <div class="d-flex justify-content-between">
                <p class="h4">Detail Pesanan</p>
            </div>

        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="card-body px-0 pt-0 p-3 row d-fex justify-content-between">
            <div class="">

            </div>
            <div class="table-responsive">
                <table class="table align-items-center mb-0 px-3">
                    <tr>
                        <th>Nomor Pesanan</th>
                        <td>: {{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <th>Nama Perusahaan</th>
                        <td>: {{ $order->client->name }}</td>
                    </tr>
                    <tr>
                        <th>Nama Proyek</th>
                        <td>: {{ $order->order_name }}</td>
                    </tr>
                    <tr>
                        <th>Material</th>
                        <td>: {{ $order->material }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>: {{ date('d M Y', strtotime($order->created_at)) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($order->status == 0)
                                <span class="badge-custom bg-warning me-2"></span>Pending
                            @elseif($order->status == 1)
                                <span class="badge-custom bg-warning me-2"></span>Need Confirm
                            @elseif($order->status == 2)
                                <span class="badge-custom bg-secondary me-2"></span>Scheduling
                            @elseif($order->status == 5)
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
                    </tr>
                    @if (count($order->images) > 0)
                        <tr>
                            <th>File Client</th>
                            <td>:

                                @foreach ($order->images as $gambar)
                                    @if ($gambar->owner != 'programmer')
                                        @if (pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) == 'jpg' ||
                                                pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) == 'png' ||
                                                pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) == 'jpeg')
                                            <a class="text-pink" style="cursor: pointer" data-bs-toggle="modal"
                                                data-bs-target="#modal{{ $gambar->id }}">
                                                File
                                                {{ $loop->iteration }}.{{ pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) }}
                                            </a> |
                                        @else
                                            <a class="text-pink" href="{{ asset('storage/image/order/' . $gambar->path) }}"
                                                target="_blank">
                                                File
                                                {{ $loop->iteration }}.{{ pathinfo(asset('storage/image/order/' . $gambar->path), PATHINFO_EXTENSION) }}
                                            </a> |
                                        @endif
                                    @endif


                                    <!-- Modal -->
                                    <div class="modal fade" id="modal{{ $gambar->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="staticBackdropLabel" data-bs-backdrop="static" aria-hidden="true">
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
                            </td>
                        </tr>
                    @else
                        <tr>
                            <th>File Client</th>
                            <td>: Tidak ada file dari client</td>
                        </tr>
                    @endif
                    @if (count($gambarUpload) > 0)
                        <tr>
                            <th>File Programmer</th>
                            <td>:
                                @foreach ($gambarUpload as $gu)
                                    <a class="text-pink" href="{{ asset('storage/image/order/' . $gu->path) }}"
                                        target="_blank">
                                        {{ $gu->path }}
                                    </a> |
                                @endforeach
                            </td>
                        </tr>
                    @else
                        <tr>
                            <th>File Programmer</th>
                            <td>: Tidak / belum ada file dari programmer</td>
                        </tr>
                    @endif
                </table>

                {{-- <li>
                    <a class="text-pink" href="{{ asset('storage/image/order/' . $gambar->path) }}"
            target="_blank">
            {{ $gambar->path }}
            </a>
            </li> --}}
                <div class="mx-5">
                    @foreach ($order->images as $gambar)
                        <li class="mb-3">
                            <a class="text-pink" href="{{ asset('storage/image/order/' . $gambar->path) }}"
                                target="_blank">
                                Lihat File
                            </a><br>
                            <embed class="gambar" src="{{ asset('storage/image/order/' . $gambar->path) }}"
                                type="application/pdf" />
                        </li>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
