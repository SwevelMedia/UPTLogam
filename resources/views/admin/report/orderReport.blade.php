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
    <div class="card p-3 bt-primary">
        <div class="nav-wrapper position-relative end-0">
            <ul class="nav nav-pills nav-fill p-1" role="tablist" id="custom-tabs-two-tab">

            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show active" id="baru" role="tabpanel"
                    aria-labelledby="custom-tabs-two-1-tab">
                    <div class="table-responsive p-0">
                        <table id="example" class="table align-items-center mb-0 text-center">
                            <thead>
                                <tr>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                        Pesanan
                                    </th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                        Perusahaan
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
                                @foreach ($history as $os)
                                    <tr>
                                        <td>{{ $os->order_number }}</td>
                                        <td>{{ $os->client->name }}</td>
                                        <td>{{ $os->order_name }}</td>
                                        <td>{{ $os->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if ($os->status == 0)
                                                <span class="badge-custom bg-warning me-2"></span>Pending
                                            @elseif($os->status == 1)
                                                <span class="badge-custom bg-warning me-2"></span>Need Confirm
                                            @elseif($os->status == 2)
                                                <span class="badge-custom bg-secondary me-2"></span>Scheduling
                                            @elseif($os->status <= 6)
                                                <span class="badge-custom bg-info me-2"></span>Design
                                            @elseif($os->status == 7)
                                                <span class="badge-custom bg-info me-2"></span>Toolkit
                                            @elseif($os->status == 8)
                                                <span class="badge-custom bg-info me-2"></span>Production
                                            @elseif($os->status == 9)
                                                <span class="badge-custom bg-success me-2"></span>Done
                                            @elseif($os->status == 10)
                                                <span class="badge-custom bg-warning me-2"></span>Decline
                                            @endif
                                        </td>
                                        <td>
                                            @if ($os->status == 0)
                                                <button class="text-center btn btn-success btn-sm px-3 accept-btn"
                                                    data-orderid="{{ $os->id }}" data-status="1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalPertama{{ $os->id }}">
                                                    <i class="fas fa-check-circle fs-6"></i>
                                                </button>
                                            @elseif ($os->status == 1)
                                                <a href="{{ url('order/konfirmasi/' . $os->id) }}"
                                                    class="text-center btn bg-success btn-success px-3 btn-sm accept-btn">
                                                    <i class="fa-solid fa-check-circle fs-6"></i>
                                                </a>
                                            @elseif ($os->status == 2)
                                                <a href="{{ url('order/jadwal/' . $os->id) }}"
                                                    class="text-center btn bg-primary btn-primary px-3 btn-sm accept-btn">
                                                    <i class="fa-solid fa-calendar-days fs-6"></i>
                                                </a>
                                            @endif
                                            <a class="text-center btn bg-gradient btn-primary btn-sm detail-btn px-3"
                                                href="{{ route('report.pdf', $os->id) }}">
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
                    <form role="form" method="POST" action="{{ url('admin/order') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="text" id="perusahaan" name="perusahaan" class="form-control"
                                placeholder="Nama Perusahaan" aria-label="Name Perusahaan"
                                aria-describedby="name-perusahaan-addon" required list="perusahaan-list" autocomplete="off">
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
                                placeholder="Nomer Perusahaan" aria-label="Phone" aria-describedby="phone-addon" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" id="address" name="address" class="form-control"
                                placeholder="Alamat Perusahaan" aria-label="Address" aria-describedby="address-addon"
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
@endpush
