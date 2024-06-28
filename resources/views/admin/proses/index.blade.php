@extends('layouts.template')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
@endpush
@section('content')
<!-- End Navbar -->
<div class="card mb-4">
    <div class="card-header pb-0 d-flex justify-content-between">
        <h4>Daftar Proses</h4>
        <a href="{{ url('proses/create') }}" class="btn btn-primary btn-sm">Tambah Proses</a>
    </div>
    <div class="swal" data-swal="{{ session('success') }}"></div>
    <div class="card-body px-4 pt-0 pb-2">

        <div class="table-responsive ">
            <table id="example" class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            No</th>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            Nama Proses</th>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            Mesin </th>
                        <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proses as $index)
                    <tr>
                        <td>
                            <p class="text-center">
                                {{ $loop->iteration }}
                            </p>
                        </td>
                        <td>
                            <p class="text-center">
                                {{ $index->name }}
                            </p>
                        </td>
                        <td>
                            <p class="text-center">
                                @foreach($machine as $mc)
                                @if($mc->id == $index->machines_id)
                                {{ $mc->name }}
                                @endif
                                @endforeach
                            </p>
                        </td>
                        <td class=" align-middle text-center">
                            <div class="btn-group dropend">
                                <a class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="cursor: pointer;">
                                </a>
                                <ul class="dropdown-menu p-4">
                                    <li><a class="dropdown-item bg-info btn btn-info text-center"
                                            href="{{ route('subproses.show', $index->id) }}">Sub Proses</a></li>
                                    <li><a class="dropdown-item bg-warning btn btn-warning text-center"
                                            href="{{ route('proses.edit', $index->id) }}">Edit</a></li>
                                    <li>
                                        <form onsubmit="return confirm('Apakah anda yakin mau menghapus proses ini?')"
                                            class="d-inline" action="{{ route('proses.destroy', $index->id) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="dropdown-item bg-danger btn btn-danger text-center"
                                                type="submit">Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
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