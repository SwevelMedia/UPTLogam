@extends('layouts.template')

@push('css')
    <style>
        @media screen and (min-width: 768px) {
            .gambar {
                width: 100%;
                height: 600px;
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

        .bt-none {
            background: none;
            border: none;
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
            <table class="table align-items-center mb-0 px-sm-3">
                <tr>
                    <th>Nama Proyek</th>
                    <td>: {{ $order->order_name }}</td>
                </tr>
                <tr>
                    <th style="width: 20%">Nomor Pesanan</th>
                    <td>: {{ $order->order_number }}</td>
                </tr>
                <tr>
                    <th>Material</th>
                    <td>:
                        @foreach ($material as $mat)
                            {{ $mat->material->name . ', ' }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Mesin</th>
                    <td>:
                        @foreach ($mesin as $msn)
                            {{ $msn->mesin->name . ', ' }}
                            {{ $msn->mesin->machine_code . ', ' }}
                        @endforeach
                    </td>
                </tr>
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
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                                aria-label="Close">

                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <embed class="gambar" src="{{ asset('storage/image/order/' . $gambar->path) }}"
                                                type="application/pdf" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </td>
                </tr>
                @if (count($gambarUpload) > 0)
                    <tr>
                        <th>File Upload</th>
                        <td>:
                            @foreach ($gambarUpload as $gu)
                                <a class="text-pink" href="{{ asset('storage/image/order/' . $gu->path) }}"
                                    target="_blank">
                                    {{ $gu->path }}
                                </a> |
                            @endforeach
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>Jadwal</th>
                    <td>: </td>
                </tr>
                <tr>
                </tr>

            </table>

            <div class="table-responsive">
                <table class="table px-sm-3 ">
                    <tr class="bg-light">
                        <th class="text-center">Desc</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Start Plan</th>
                        <th class="text-center">Start Actual</th>
                        <th class="text-center">Stop Plan</th>
                        <th class="text-center">Stop Actual</th>
                    </tr>
                    @foreach ($jadwal as $item)
                        <tr>
                            <th class="text-center">{{ $item->desc }}</th>
                            <td class="text-center">
                                @isset($item->employee->name)
                                    {{ $item->employee->name }}
                                @endisset
                            </td>
                            <td>{{ $item->start_plan }}</td>
                            <td class="text-center">
                                @if ($item->start_actual != null)
                                    {{ $item->start_actual }}
                                @else
                                    @if ($item->desc == 'CAD')
                                        <form action="{{ url('prog/start-cad') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                                            <button type="submit" class="btn btn-sm btn-primary mb-0">Start</button>
                                        </form>
                                    @elseif($item->order->status == 5)
                                        <form action="{{ url('prog/start-cam') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                                            <button type="submit" class="btn btn-sm btn-primary mb-0">Start</button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">{{ $item->stop_plan }}</td>
                            <td class="text-center">
                                @if ($item->stop_actual != null)
                                    {{ $item->stop_actual }}
                                @elseif(auth()->user()->id == $item->users_id)
                                    @if ($item->desc == 'CAD' && $item->start_actual != null)
                                        <button class="btn btn-sm btn-primary mb-0" data-bs-toggle="modal"
                                            data-bs-target="#modalCad{{ $item->id }}">Upload</button>
                                    @elseif($item->order->status == 5 && $item->start_actual != null)
                                        <a class="btn btn-sm btn-primary mb-0"
                                            href="{{ url('desain/cam/' . $order->id) }}">
                                            Upload</a>
                                    @endif
                                @endif
                            </td>
                        <tr>

                            <!-- Modal Upload Cad-->
                            <div class="modal fade" id="modalCad{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="staticBackdropLabel" data-bs-backdrop="static" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-gradient-primary">
                                            <h5 class="modal-title text-white" id="exampleModalLabel">Upload Desain CAD</h5>
                                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                onsubmit="return confirm('Apakah anda yakin projek tidak membutuhkan desain?')"
                                                class="d-inline" action="{{ url('prog/no-cad') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="order_number"
                                                    value="{{ $order->order_number }}">
                                                <button class="text-pink bt-none" type="submit">klik jika projek tidak
                                                    membutuhkan
                                                    desain!</button>
                                            </form>
                                            <form action="{{ url('prog/upload-cad') }}" method="post"
                                                enctype="multipart/form-data">

                                                @csrf
                                                <div class=" my-4">
                                                    <label for="">Upload File</label>
                                                    <input type="file" name="cad" class="form-control" required
                                                        accept=".pdf">
                                                    <input type="hidden" name="order_number"
                                                        value="{{ $order->order_number }}">
                                                </div>


                                                <div class="d-flex justify-content-end">
                                                    <button type="submit"
                                                        class="btn btn-sm bg-gradient-primary">Upload</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        $(document).ready(function() {
            $('#noDesain').change(function() {
                if ($(this).is(':checked')) {
                    $('#uploadSection').css('display', 'none');
                } else {
                    $('#uploadSection').css('display', 'block');
                }
            });
        });
    </script>

    <script>
        // Add event listener to checkboxes
        var checkboxes = document.querySelectorAll('.tool-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var qtyInput = this.parentNode.nextElementSibling.querySelector('.qty-input');
                if (this.checked) {
                    qtyInput.removeAttribute('hidden');
                    qtyInput.value = '1';
                    qtyInput.min = '1';
                } else {
                    qtyInput.setAttribute('hidden', true);
                    qtyInput.value = '0'; // Reset the value when unchecked
                }
            });
        });
    </script>

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
@endpush
