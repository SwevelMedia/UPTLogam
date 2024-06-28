@extends('layouts.template')

@push('css')
@endpush

@section('content')
<div class="row justify-content-center">
    <div class=" row col-md-8">
        <div class="card mb-4 col-md-10">
            <div class="card-header pb-0 d-flex justify-content-between">
                <h5>Edit Proses</h5>
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
            <form method="post" action="{{ route('proses.update', $proses->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Nama Proses</label>
                    <input class="form-control" type="text" name="name"
                        placeholder="Masukkan nama proses" id="example-text-input" value="{{ $proses->name }}" required>
                </div>
                <div class="form-group">
                    <label for="id_mesin" class="form-control-label">Pilih Mesin</label>
                    <select class="form-select form-control-md" name="machines_id" id="machines_id" required>
                        @foreach ($machine as $mc )
                            @if ($proses->machines_id==$mc->id)
                                <option value="{{ $mc->id }}">{{ $mc->name }}</option>
                            @endif
                        @endforeach
                        @foreach ($machine as $index )
                            <option value="{{ $index->id}} ">{{ $index->name }}</option>
                        @endforeach
                    </select>
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
