@extends('layouts.template')

@push('css')
@endpush

@section('content')
    <div class="row justify-content-center">
        <div class=" row col-md-8">
            <div class="card mb-4 col-md-10">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <h5>Tambah Mesin</h5>
                </div>
                <div class="swal" data-swal="{{ session('success') }}"></div>
                <hr class="bg-primary pt-1">
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
                <form method="post" action="{{ url('/machine') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Nama Mesin</label>
                        <input class="form-control" type="text" name="name"
                            placeholder="Masukkan nama mesin" id="example-text-input" required>
                    </div>
                    <div class="form-group">
                        <label for="example-text-input" class="form-control-label">Kode Mesin</label>
                        <input class="form-control" type="text" name="machine_code"
                            placeholder="Masukkan kode mesin" id="example-text-input" required>
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
