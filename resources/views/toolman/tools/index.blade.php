@extends('layouts.template')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">

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
    <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between">
            <h4>Daftar Alat yang Dibutuhkan</h4>
        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="swalwarning" data-swal="{{ session('warning') }}"></div>
        <div class="card p-3 bt-primary">
            <div class="nav-wrapper position-relative end-0">
                <ul class="nav nav-pills nav-fill p-1" role="tablist" id="custom-tabs-two-tab">
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1 active" id="custom-tabs-two-1-tab" data-bs-toggle="tab"
                            href="#baru" role="tab" aria-controls="profile" aria-selected="true">
                            @if (count($orders) > 0)
                                Pesanan Baru <span class="badge-notif bg-danger fw-bolder">{{ count($orders) }}</span>
                            @else
                                Pesanan Baru
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#history" role="tab"
                            aria-controls="dashboard" aria-selected="false">
                            @if (count($history) > 0)
                                History <span class="badge-notif bg-info fw-bolder">{{ count($history) }}</span>
                            @else
                                History
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div class="tab-pane fade show active" id="baru" role="tabpanel"
                        aria-labelledby="custom-tabs-two-1-tab">
                        <div class="table-responsive p-0">
                            <table id="example" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nomor Pesanan</th>
                                        <th class="text-center">Nama Proyek</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $index)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $index->order_number }}</td>
                                            <td class="text-center">{{ $index->order_name }}</td>
                                            <td class="text-center">

                                                <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0"
                                                    href="{{ url('order/' . $index->id) }}">
                                                    <i class="fa-solid fa-arrow-right fs-6"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div class="tab-pane fade show" id="history" role="tabpanel" aria-labelledby="custom-tabs-two-2-tab">
                        <div class="table-responsive p-0">
                            <div class="table-responsive p-0">
                                <table id="example2" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nomor Pesanan</th>
                                            <th class="text-center">Nama Proyek</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($history as $his)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $his->order_number }}</td>
                                                <td class="text-center">{{ $his->order_name }}</td>
                                                <td class="text-center">
                                                    <a class="text-center btn btn-secondary btn-sm detail-btn px-3 py-2 mb-0"
                                                        href="{{ url('order/' . $his->id) }}">
                                                        <i class="fa-solid fa-circle-info fs-6"></i>
                                                    </a>
                                                    <a class="text-center btn btn-primary btn-sm detail-btn px-3 py-2 mb-0"
                                                        href="{{ url('tool/order/' . $his->id) }}">
                                                        <i class="fa-solid fa-arrow-right fs-6"></i>
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
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>

    <script>
        $(document).ready(function() {
            $(function() {
                $('#example').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
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
