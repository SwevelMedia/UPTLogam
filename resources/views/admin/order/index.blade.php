@extends('layouts.template')

@push('css')
@endpush

@section('content')
<div class="card mb-4">
    <div class="card-header pb-0">
        <p class="h4">Daftar Pesanan</p>
    </div>
    <div class="swal" data-swal="{{ session('success') }}"></div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            No</th>
                        <th class=" text-secondary text-sm font-weight-bolder opacity-7 text-center">
                            Nomor Pesanan</th>
                        <th class=" text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                            Nama Proyek</th>
                        <th class=" text-secondary text-sm font-weight-bolder opacity-7">
                            Status</th>
                        <th class=" text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                            Penyelesaian</th>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-sm text-center ">{{ $item->order_number }}</td>
                        <td class="text-sm ">{{ $item->order_name }}</td>
                        <td class="text-sm">
                            @if ( $item->status == 0)
                            <span class="badge-custom bg-warning me-2"></span>Pending
                            @elseif( $item->status == 1)
                            <span class="badge-custom bg-warning me-2"></span>Need Confirm
                            @elseif( $item->status == 2)
                            <span class="badge-custom bg-secondary me-2"></span>Scheduling
                            @elseif( $item->status == 3 || $item->status == 4 || $item->status == 5 || $item->status ==
                            6)
                            <span class="badge-custom bg-info me-2"></span>Design
                            @elseif( $item->status == 7)
                            <span class="badge-custom bg-info me-2"></span>Toolkit
                            @elseif( $item->status == 8)
                            <span class="badge-custom bg-info me-2"></span>Production
                            @elseif( $item->status == 9)
                            <span class="badge-custom bg-success me-2"></span>Done
                            @elseif( $item->status == 10)
                            <span class="badge-custom bg-danger me-2"></span>Decline
                            @endif


                        </td>
                        <td class="align-middle text-center">
                            @if ($item->status == 0 )
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">0%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="12"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                            @elseif($item->status == 1)
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">5%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 5%;"></div>
                                    </div>
                                </div>
                            </div>
                            @elseif($item->status == 2)
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">10%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="40"
                                            aria-valuemin="0" aria-valuemax="40" style="width: 10%;"></div>
                                    </div>
                                </div>
                            </div>
                            @elseif($item->status == 3 )
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">20%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="40"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                                    </div>
                                </div>
                            </div>
                            @elseif($item->status == 4 )
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">30%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="40"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 30%;"></div>
                                    </div>
                                </div>
                            </div>
                            @elseif($item->status == 5 )
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">40%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="40"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 40%;"></div>
                                    </div>
                                </div>
                            </div>
                            @elseif($item->status == 6)
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">50%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="65"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 50%;"></div>
                                    </div>
                                </div>
                            </div>
                            @elseif($item->status == 7)
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">60%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="100"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                    </div>
                                </div>
                            </div>
                            @elseif($item->status == 8)
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">70%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow="100"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 70%;"></div>
                                    </div>
                                </div>
                            </div>
                            @elseif($item->status == 9)
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">100%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" aria-valuenow="100"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                            @elseif($item->status == 10)
                            <div class="d-flex align-items-center">
                                <span class="me-2 text-xs">0%</span>
                                <div>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="0"
                                            aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </td>
                        <td class="text-center">
                            <a href="{{ url('order/' . $item->id) }}"
                                class="text-secondary font-weight-bold text-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection

@push('js')
@endpush