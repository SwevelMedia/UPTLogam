@extends('layouts.template')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
@endpush
@section('content')
<!-- End Navbar -->
<div class="card mb-4 ">
    <div class="card-header border-bottom mb-3 pb-0 d-flex justify-content-between">
        <p class="h4">Daftar Karyawan</p>
        <a href="{{ url('karyawan/create') }}" class="btn btn-primary btn-sm">Tambah</a>
    </div>
    <div class="swal" data-swal="{{ session('success') }}"></div>
    <div class="card-body px-0 pt-0 pb-2 px-sm-3">
        <div class="table-responsive p-0">
            <table id="example" class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            No</th>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            Nama Karyawan</th>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            Jabatan</th>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            Jenis Kelamin</th>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            Telepon</th>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawan as $index)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div>
                                    @if ($index->photo == url('/storage/image/profile'))
                                    <img src="{{ asset('/storage/image/profile/user.png') }}"
                                        class="avatar avatar-sm  me-3 ">
                                    @else
                                    <img src="{{ $index->photo }}" class="avatar avatar-sm  me-3 ">
                                    @endif
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ $index->name }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ $index->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">
                                {{ $index->role }}
                            </p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <span
                                class="badge text-white badge-sm @if ($index->gender == 'laki-laki') bg-gradient-success @else bg-gradient-pink @endif ">{{ $index->gender }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $index->phone }}</span>
                        </td>
                        <td class="align-middle text-center">
                            <div class="btn-group dropend">
                                <a class="dropdown-toggle p-2" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="cursor: pointer;">
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ url('karyawan/' . $index->id) }}">Detail</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ url('karyawan/' . $index->id . '/edit') }}">Edit</a></li>
                                    <li>
                                        <form onsubmit="return confirm('Apakah anda yakin hapus data karyawan ini?')"
                                            class="d-inline" action="{{ url('karyawan/' . $index->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="dropdown-item" type="submit">Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>

                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="editModal{{ $index->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="editModal{{ $index->id }}Label" aria-hidden="true" data-bs-backdrop="static"
                        data-bs-keyboard="false">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModal{{ $index->id }}Label">Edit
                                        Data Karyawan</h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @if ($errors->any())
                                <div class="my-3">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif
                                <form method="post" action="{{ url('karyawan/' . $index->id) }}"
                                    enctype="multipart/form-data">
                                    <div class="modal-body">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" name="oldPhoto" value="{{ $index->photo }}">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="example-text-input" class="form-control-label">Nama
                                                    Karyawan</label>
                                                <input class="form-control" type="text" name="name"
                                                    placeholder="Masukkan nama lengkap karyawan" id="example-text-input"
                                                    required value="{{ $index->name }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="example-text-input" class="form-control-label">Jenis
                                                    Kelamin</label>
                                                <select class="form-select form-control-md" name="gender" required>
                                                    <option value="{{ $index->gender }}">{{ $index->gender }}
                                                    </option>
                                                    <option value="laki-laki">Laki - Laki</option>
                                                    <option value="perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Alamat</label>
                                            <textarea class="form-control" name="address"
                                                id="exampleFormControlTextarea1" rows="3"
                                                placeholder="Masukkan alamat lengkap disini"
                                                required>{{ $index->address }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="example-email-input"
                                                    class="form-control-label">Jabatan</label>
                                                <input class="form-control" type="text"
                                                    placeholder="Masukkan jabatan disini" name="position"
                                                    id="example-email-input" required value="{{ $index->position }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="example-tel-input" class="form-control-label">Phone</label>
                                                <input class="form-control" type="tel" name="phone"
                                                    placeholder="Masukkan nomer telepon disini" id="example-tel-input"
                                                    required value="{{ $index->phone }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="example-password-input" class="form-control-label">Foto</label>
                                            <input class="form-control" type="file" name="photo"
                                                id="example-password-input">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-number-input" class="form-control-label">Email</label>
                                            <input class="form-control" type="email" name="email"
                                                placeholder="masukkan email disini" id="example-number-input" required
                                                value="{{ $index->email }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn bg-gradient-primary">Save
                                            changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>

        </div>
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