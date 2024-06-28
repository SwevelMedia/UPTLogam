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
    <div class="card mb-4 pb-4">
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
            <div class="row mb-3">
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
                                        {{ $mat->material->name . ', ' }}
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
                                        <a class="text-pink" href="{{ asset('storage/image/order/' . $gu->path) }}"
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
            <div class="mx-3 row">
                <div class="col-sm-6">
                    <label class="fs-6">Deskripsi Revisi</label>
                    <textarea class="form-control mb-3" disabled>{{ $order->description }}</textarea>


                    <form action="{{ url('submit-revisi/' . $order->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label class="fs-6">Upload file</label>
                        <input type="file" required accept=".pdf" name="file" id="file"
                            class="form-control mb-3">

                        @if (auth()->user()->role == 'drafter')
                            <input type="hidden" name="oldFile" value="{{ $gambarCad->path }}">
                        @elseif (auth()->user()->role == 'programmer')
                            <input type="hidden" name="oldFile" value="{{ $gambarCam->path }}">
                        @endif

                        <button type="submit" class="btn btn-sm bg-gradient-pink w-100">Submit</button>
                    </form>
                </div>
                <div class="col-sm-6">
                    <div id="pdfViewer"></div>
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
        // Fungsi untuk menampilkan file PDF yang dipilih
        function showPDF(input) {
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const pdfViewer = document.getElementById('pdfViewer');
                pdfViewer.innerHTML =
                    `<embed src="${e.target.result}" width="100%" height="450px" type="application/pdf" />`;
            };

            reader.readAsDataURL(file);
        }

        // Panggil fungsi showPDF saat file dipilih
        document.getElementById('file').addEventListener('change', function() {
            showPDF(this);
        });
    </script>
@endpush
