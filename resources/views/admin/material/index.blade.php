@extends('layouts.template')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endpush
@section('content')
    <!-- End Navbar -->
    <div class="card mb-4">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h4>Daftar Material</h4>
                    <a href="{{ url('material/create') }}" class="btn btn-primary btn-sm">Tambah Material</a>
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
                                        Nama Bahan</th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index)
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
                                        <td class="align-middle text-center">
                                            <a href="{{ route('material.edit', $index->id) }}"
                                                class="text-center btn bg-primary btn-primary btn-sm px-3 my-0 py-2 accept-btn">
                                                <i class="fa-regular fa-pen-to-square fs-6"></i>
                                            </a>
                                            <form onsubmit="return confirm('Apakah anda yakin mau menghapus Material ini?')"
                                                class="d-inline" action="{{ route('material.destroy', $index->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="text-center px-3 py-2 my-0 btn btn-danger btn-sm accept-btn"
                                                    stype="submit">
                                                    <i class="fa-solid fa-trash fs-6"></i>
                                                </button>
                                            </form>
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
