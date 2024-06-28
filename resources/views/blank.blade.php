@extends('layouts.template')

@push('css')
@endpush

@section('content')
    <div class="card mb-4">
        <div class="card-header pb-0">
            <p class="h4">Lorem Ipsum</p>
        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Author</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                Position</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Gender</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Phone</th>
                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

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
