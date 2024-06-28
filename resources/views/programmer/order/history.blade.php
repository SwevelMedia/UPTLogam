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
    <link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 px-3">
                <div class="card-header mb-3 pb-0">
                    <a href="{{ url()->previous() }}">
                        <h6 class="text-info"><i class="fas fa-chevron-left"></i> Kembali</h6>
                    </a>
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
                                        {{ $item->employee->name }}
                                    </td>
                                    <td>{{ $item->start_plan }}</td>
                                    <td class="text-center">
                                        {{ $item->start_actual }}
                                    </td>
                                    <td class="text-center">{{ $item->stop_plan }}</td>
                                    <td class="text-center">
                                        {{ $item->stop_actual }}
                                    </td>
                                <tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8 mb-4">
            <div class="card bt-primary">
                <div class="card-header pb-0">
                    <p class="h5">Proses</p>
                </div>
                <div class="swal" data-swal="{{ session('success') }}"></div>
                <div class="card-body pb-2">
                    @foreach ($order->machineOrders as $mesin)
                        <p class="h5">{{ $mesin->mesin->name }}</p>
                        @foreach ($mesin->prosesOrder as $po)
                            <div class="mb-3">
                                <div class="mx-1">
                                    Operation Info :
                                    <strong>{{ $loop->iteration . '.  ' . $po->subProses->proses->name }}</strong>
                                </div>
                                <div class="row mb-2 mx-1 py-0 border">
                                    <div class="col-5 border-end border-bottom">
                                        <span class="text-xs">
                                            Program Name : {{ $po->subProses->name }} <br>
                                            Spindle Speed : {{ $po->subProses->spindle_speed }} RPM
                                        </span>
                                    </div>
                                    <div class="col-4 border-end border-bottom">
                                        <span class="text-xs">
                                            Feedrate : {{ $po->subProses->feedrate }} <br>
                                            Stock To Leave : {{ $po->subProses->stock_to_leave }}
                                        </span>
                                    </div>
                                    <div class="col-3 border-bottom">
                                        <span class="text-xs">
                                            Time : {{ $po->subProses->estimate_time }}
                                        </span>
                                    </div>

                                    <div class="col-4  border-end">
                                        <span class="text-xs">Tool : {{ $po->subProses->tool }}</span>
                                    </div>
                                    <div class="col-4 border-end">
                                        <span class="text-xs">Corner Radius :
                                            {{ $po->subProses->corner_radius }}</span>
                                    </div>
                                    <div class="col-4">
                                        <span class="text-xs">Holder : {{ $po->subProses->holder }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        <div class=" col-4 mb-4">
            <form action="{{ url('prog/update-cam') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card bt-pink mb-3">
                    <div class="card-body pb-2">
                        <p class="h5">Tools</p>
                        <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                        @foreach ($order->machineOrders as $mo)
                            <strong>{{ $mo->mesin->name }}</strong>
                            <table class="table">
                                <tr>
                                    <th class="w-60 text-center">Jenis Tool</th>
                                    <th class="w-25 text-center">Qty</th>
                                </tr>
                                @php
                                    $tools = [];
                                    $toolCounts = [];
                                @endphp

                                @foreach ($mo->toolsOrder as $to)
                                    @php
                                        $toolName = $to->tools->tool_name . ', ' . $to->tools->size;
                                    @endphp

                                    @if (!in_array($toolName, $tools))
                                        @php
                                            $tools[] = $toolName;
                                            $toolCounts[$toolName] = 1;
                                        @endphp
                                    @else
                                        @php
                                            $toolCounts[$toolName]++;
                                        @endphp
                                    @endif
                                @endforeach

                                @foreach ($tools as $tool)
                                    <input type="hidden" name="tool[]" value="{{ $tool . ', ' . $mo->id }}">
                                    <tr>
                                        <td class="text-sm">{{ $tool }}</td>
                                        <td class="text-sm text-center">
                                            <input type="number" min="1" value="{{ $toolCounts[$tool] }}"
                                                name="qty[]" class="form-control-sm  w-100">
                                        </td>
                                    </tr>
                                @endforeach


                            </table>
                        @endforeach
                    </div>
                </div>
                <button class="w-100 btn bg-gradient-pink text-white" type="submit">Update</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

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
