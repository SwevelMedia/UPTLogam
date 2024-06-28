@extends('layouts.template')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="card mb-4">
    <div class="card-header pb-0 d-flex justify-content-between">
        <h4>Daftar Tools Order</h4>
        <a href="{{ url('prog/tools/create') }}" class="btn btn-primary btn-sm">Tambah</a>
    </div>
    <div class="swal" data-swal="{{ session('success') }}"></div>
    <div class="card-body px-4 pt-0 pb-2">
        <div class="table-responsive">
            <table id="example" class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tools ID</th>
                        <th class="text-center">Order Number</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($toolsOrderWithCombinedTools as $index)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @foreach ($index['tools'] as $tool)
                            <label class="form-check-label" for="tool_{{ $tool['id'] }}">
                                {{ $tool['tool_name'] }}, {{ $tool['size'] }}
                            </label>
                            <br>
                            @endforeach
                        </td>
                        <td class="text-center">{{ $index['order_number'] }}</td>
                        <td class="text-center">
                            <div class="btn-group dropend">
                                <a class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="cursor: pointer;"></a>
                                <ul class="dropdown-menu p-4">
                                    <li><a class="dropdown-item bg-warning btn btn-warning text-center"
                                            href="{{ route('proses.edit', $index['order_number']) }}">Edit</a></li>
                                    <li>
                                        <form onsubmit="return confirm('Apakah anda yakin mau menghapus data?')"
                                            class="d-inline"
                                            action="{{ route('tools.destroy', $index['order_number']) }}" method="POST">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#example').DataTable();
});
</script>

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
@endpush