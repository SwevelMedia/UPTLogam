@extends('layouts.template')

@push('css')
@endpush

@section('content')
<div class="row justify-content-center">
    <div class=" row col-md-8">
        <div class="card mb-4 col-md-10">
            <div class="card-header pb-0 d-flex justify-content-between">
                <h5>Ubah Alat</h5>
            </div>
            <div class="swal" data-swal="{{ session('success') }}"></div>
            <hr class="bg-primary pt-1">
            @if ($errors->any())
            <div class="my-3">
                <div class="alert border-danger text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <form method="post" action="{{ route('tool.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Nama Alat</label>
                    <input class="form-control" type="text" name="tool_name" placeholder="Masukkan nama tools" id="example-text-input" required value="{{ $data->tool_name }}">
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Ukuran Alat</label>
                    <input class="form-control" type="text" name="size" placeholder="Masukkan ukuran tools" id="example-text-input" required value="{{ $data->size }}">
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Kode Alat</label>
                    <input class="form-control" type="text" name="tool_code" placeholder="Masukkan kode tools" id="example-text-input" required value="{{ $data->tool_code }}">
                </div>
                <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Status</label>
                    <input class="form-control" type="text" name="status" placeholder="Masukkan status tools" id="example-text-input" required value="{{ $data->status }}">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
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