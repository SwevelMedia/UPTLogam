@extends('layouts.template')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
@endpush
@section('content')
    <!-- End Navbar -->
    <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between">
            <h4>Daftar Mesin</h4>
            <a href="{{ url('machine/create') }}" class="btn btn-primary btn-sm">Tambah Mesin</a>
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
                                Nama Mesin</th>
                            <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                Kode Mesin</th>
                            <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                Status</th>
                            <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($machine as $index)
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
                                        {{ $index->machine_code }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-center">
                                        @if ($index->status == 1)
                                            Ready
                                        @else($index->status == 2)
                                            Tidak Ready
                                        @endif
                                    </p>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm bg-gradient-primary text-center px-3 mb-0"
                                        href="{{ url('machine/' . $index->id) }}">Proses</a>
                                    <a class="btn btn-sm btn-warning text-center px-3 mb-0"
                                        href="{{ route('machine.edit', $index->id) }}">Edit</a>

                                    <form onsubmit="return confirm('Apakah anda yakin mau menghapus mesin ini?')"
                                        class="d-inline" action="{{ route('machine.destroy', $index->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn-sm px-3 mb-0 bg-danger btn btn-danger text-center"
                                            type="submit">Hapus</button>
                                    </form>

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
