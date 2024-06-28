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
            <a href="{{ route('machiner.konfigmesin') }}">
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
                        <td>: {{ $mesin->name }}</td>
                    </tr>
                    <tr>
                        <th>Nama Perusahaan</th>
                        <td>: {{ $mesin->machine_code }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if ($mesin->status == 1)
                                <span class="badge-custom bg-warning me-2"></span>Ready
                            @elseif($mesin->status == 2)
                                <span class="badge-custom bg-warning me-2"></span>Sedang Digunakan
                            @elseif($mesin->status == 11)
                                <span class="badge-custom bg-warning me-2"></span>Breakdown Schedule
                            @elseif($mesin->status == 12)
                                <span class="badge-custom bg-warning me-2"></span>Breakdown Unschedule
                            @elseif($mesin->status == 13)
                                <span class="badge-custom bg-secondary me-2"></span>Stanby Request
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>:
                            @foreach ($mesin->maintenance as $mt)
                                {{ date('d M Y', strtotime($mt->estimasi)) }}
                            @endforeach

                        </td>
                    </tr>
                </table>
                <div class="row justify-content-end mt-3">
                    <div class="col-6 col-sm-3">
                        <form action="{{ url('status-mesin') }}" method="POST" class="w-100">
                            @csrf
                            <input type="hidden" name="machine_id" value="{{ $mesin->id }}">
                            <input type="hidden" name="status" value="1">
                            @if ($mesin->status == 2)
                                <button type="button" class="btn btn-success w-100" disabled>Mesin sedang
                                    digunakan</button>
                            @else
                                <button type="submit" class="btn btn-success w-100">Ready</button>
                            @endif
                        </form>
                    </div>
                    <div class="col-6 col-sm-3">
                        <form action="{{ url('status-mesin') }}" method="POST" class="w-100">
                            @csrf
                            <input type="hidden" name="machine_id" value="{{ $mesin->id }}">
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="btn btn-light w-100">Sedang
                                Digunakan</button>
                        </form>
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
@endpush
