@extends('layouts.template')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<style>
ul.inline-list {
    padding: 0;
    /* Menghapus padding default */
    margin: 0;
    /* Menghapus margin default */
}

ul.inline-list li {
    display: inline;
    /* Membuat elemen <li> tampil secara inline */
    margin-right: 10px;
    /* Memberi jarak antara elemen <li> */
}

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
<div class="card p-2">
    <div class="nav-wrapper position-relative end-0 ">
        <ul class="nav nav-pills nav-fill p-1" role="tablist" id="custom-tabs-two-tab">
            <li class="nav-item">
                <a class="nav-link mb-0 px-0 py-1 active" id="custom-tabs-two-1-tab" data-bs-toggle="tab" href="#baru"
                    role="tab" aria-controls="profile" aria-selected="true">
                    @if (count($orders) > 0)
                    Pesanan Baru <span class="badge-notif bg-danger">{{ count($orders) }}</span>
                    @else
                    Pesanan Baru
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#dikerjakan" role="tab"
                    aria-controls="dashboard" aria-selected="false">
                    @if (count($running) > 0)
                    Sedang Dikerjakan <span class="badge-notif bg-warning">{{ count($running) }}</span>
                    @else
                    Sedang Dikerjakan
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#approval" role="tab"
                    aria-controls="dashboard" aria-selected="false">
                    @if (count($approval) > 0)
                    Approval <span class="badge-notif bg-warning">{{ count($approval) }}</span>
                    @else
                    Approval
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#revisi" role="tab"
                    aria-controls="dashboard" aria-selected="false">
                    @if (count($revisi) > 0)
                    Revisi <span class="badge-notif bg-warning">{{ count($revisi) }}</span>
                    @else
                    Revisi
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#history" role="tab"
                    aria-controls="dashboard" aria-selected="false">
                    @if (count($history) > 0)
                    History <span class="badge-notif bg-info">{{ count($history) }}</span>
                    @else
                    History
                    @endif
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        {{-- New Order --}}
        <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show active" id="baru" role="tabpanel" aria-labelledby="custom-tabs-two-1-tab">
                <div class="table-responsive p-0">
                    <table id="example" class="table align-items-center mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                    Pesanan
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                    Client
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama Proyek
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Tanggal
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->client->name }}</td>
                                <td>{{ $order->order_name }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <a class="text-center btn btn-primary btn-sm detail-btn px-3"
                                        href="{{ url('order/' . $order->id) }}">
                                        <i class="fa-solid fa-circle-info fs-6"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- running --}}
        <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show" id="dikerjakan" role="tabpanel" aria-labelledby="custom-tabs-two-2-tab">
                <div class="table-responsive p-0">
                    <table id="example" class="table align-items-center mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                    Pesanan
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                    Client
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama Proyek
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($running as $item)
                            <tr>
                                <td>{{ $item->order_number }}</td>
                                <td>{{ $item->client->name }}</td>
                                <td>{{ $item->order_name }}</td>
                                <td>
                                    <a class="text-center btn btn-primary btn-sm detail-btn px-3"
                                        href="{{ url('order/' . $item->id) }}">
                                        <i class="fa-solid fa-circle-info fs-6"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- approval --}}
        <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show" id="approval" role="tabpanel" aria-labelledby="custom-tabs-two-2-tab">
                <div class="table-responsive p-0">
                    <table id="example" class="table align-items-center mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                    Pesanan
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                    Client
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama Proyek
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approval as $appove)
                            <tr>
                                <td>{{ $appove->order_number }}</td>
                                <td>{{ $appove->client->name }}</td>
                                <td>{{ $appove->order_name }}</td>
                                <td>
                                    <a class="text-center btn btn-primary btn-sm detail-btn px-3"
                                        href="{{ url('order/' . $appove->id) }}">
                                        <i class="fa-solid fa-circle-info fs-6"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- revisi --}}
        <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show" id="revisi" role="tabpanel" aria-labelledby="custom-tabs-two-2-tab">
                <div class="table-responsive p-0">
                    <table id="example" class="table align-items-center mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                    Pesanan
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                    Client
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama Proyek
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($revisi as $rev)
                            <tr>
                                <td>{{ $rev->order_number }}</td>
                                <td>{{ $rev->client->name }}</td>
                                <td>{{ $rev->order_name }}</td>
                                <td>
                                    <a class="text-center btn btn-primary btn-sm detail-btn px-3"
                                        href="{{ url('prog/revisi/' . $rev->id) }}">
                                        <i class="fa-solid fa-circle-info fs-6"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- History --}}
        <div class="tab-content" id="custom-tabs-two-tabContent">
            <div class="tab-pane fade show" id="history" role="tabpanel" aria-labelledby="custom-tabs-two-2-tab">
                <div class="table-responsive p-0">
                    <table id="example" class="table align-items-center mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nomor
                                    Pesanan
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama
                                    Client
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Nama Proyek
                                </th>
                                <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $data)
                            <tr>
                                <td>{{ $data->order_number }}</td>
                                <td>{{ $data->client->name }}</td>
                                <td>{{ $data->order_name }}</td>
                                <td>
                                    <a class="text-center btn btn-primary btn-sm detail-btn px-3"
                                        href="{{ url('order/' . $data->id) }}">
                                        <i class="fa-solid fa-circle-info fs-6"></i>
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
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
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
</script>
@endpush