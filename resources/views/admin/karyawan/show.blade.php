@extends('layouts.template')

@push('css')
@endpush

@section('content')
<div class="card mb-4 px-3">
    <div class="card-header border-bottom mb-3">
        <a href="{{ url()->previous() }}">
            <h6 class="text-info"><i class="fas fa-chevron-left"></i> Kembali</h6>
        </a>
        <p class="h4">Detail Karyawan</p>
    </div>
    <div class="swal" data-swal="{{ session('success') }}"></div>
    <div class="card-body px-0 pt-0 p-3 row d-fex justify-content-between">
        <div class="col-sm-3">
            @if ($karyawan->photo == url('/storage/image/profile'))
            <img src="{{ asset('/storage/image/profile/user.png') }}" class="img-fluid float-end rounded">
            @else
            <img src="{{ $karyawan->photo }}" class="img-fluid float-end rounded">
            @endif
        </div>
        <div class="table-responsive col-sm-9">
            <table class="table align-items-center mb-0 px-3">
                <tr>
                    <th>Nama</th>
                    <td>: {{ $karyawan->name }}</td>
                </tr>
                <tr>
                    <th>NIP</th>
                    <td>: {{ $karyawan->nip }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>: {{ strtoupper($karyawan->role) }}</td>
                </tr>
                <tr>
                    <th>Tanggal Masuk</th>
                    <td>: {{ date('d M Y', strtotime($karyawan->tanggal_masuk)) }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>: {{ $karyawan->phone }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>: {{ $karyawan->email }}</td>
                </tr>
                <tr>
                    <th>NIK</th>
                    <td>: {{ $karyawan->nik }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>: {{ $karyawan->gender }}</td>
                </tr>
                <tr>
                    <th>Tempat, Tanggal Lahir</th>
                    <td>: {{ $karyawan->tempat_lahir . ', ' . date('d M Y', strtotime($karyawan->tanggal_lahir)) }}
                    </td>
                </tr>
                <tr>
                    <th>Agama</th>
                    <td>: {{ $karyawan->agama }}</td>
                </tr>
                <tr>
                    <th>Status Nikah</th>
                    <td>: {{ $karyawan->status_nikah }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>: {{ $karyawan->address }}</td>
                </tr>
                <tr>
                    <th>Golongan Darah</th>
                    <td>: {{ $karyawan->gol_darah }}</td>
                </tr>
                <tr>
                    <th>Pendidikan Terakhir</th>
                    <td>: {{ $karyawan->pendidikan }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush