@extends('layouts.template')

@push('css')
    <style>
        /* Accordion Styles */
        .accordion-item {
            margin-bottom: 0px;
        }

        .accordion-button {
            background-color: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            cursor: pointer;
        }

        .accordion-button:focus {
            box-shadow: none;
            outline: none;
        }

        .accordion-button:hover {
            background-color: #e9ecef;
        }

        .accordion-button[aria-expanded="true"] {
            background-color: #e9ecef;
        }

        .accordion-body {
            background-color: #fff;
            padding: 1rem;
        }

        .accordion-collapse.collapse {
            display: none;
        }

        .accordion-collapse.collapse.show {
            display: block;
        }

        .btn {
            width: 100%;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .btn span {
            display: inline-block;
            width: auto;
            white-space: normal;
        }

        /* Adjustments for Mobile View */
        @media (max-width: 576px) {
            .table-responsive {
                overflow-x: auto;
            }

            .table {
                width: 100%;
                /* Ensure table width doesn't exceed screen width */
            }

            .accordion-button {
                padding: 0.5rem 0.75rem;
                font-size: 0.9rem;
            }

            .accordion-body {
                padding: 0.5rem;
            }

            .btn {
                height: 35px;
                /* Adjust button height for smaller screens */
            }
        }
    </style>
@endpush

@section('content')
    <div class="card mb-4">
        <div class="card-header pb-0">
            <p class="h4">Manajemen Mesin</p>
        </div>

        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="card-body px-0 pt-0 pb-2">
            @if ($errors->any())
                <div class="my-2 mx-3">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-white">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table align-items-center table-borderless mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 20%;">Kode Mesin</th>
                            <th class="text-center" style="width: 30%;">Nama Mesin</th>
                            <th class="text-center" style="width: 20%;">Status</th>
                            <th class="text-center" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($machines as $index => $machine)
                            <tr>
                                <td class="text-center">{{ $machine->machine_code }}</td>
                                <td class="text-center">{{ $machine->name }}</td>
                                <td class="text-center">
                                    @if ($machine->status == 1)
                                        <span class="badge bg-success text-white">Ready</span>
                                        </a>
                                    @elseif($machine->status == 2)
                                        <span class="badge bg-light text-white">Sedang Digunakan</span>
                                        </a>
                                    @elseif($machine->status == 11)
                                        <a href="/machiner/detail/{{ $machine->id }}">
                                            <span class="badge bg-warning text-white">Breakdown Schedule</span>
                                        </a>
                                    @elseif($machine->status == 12)
                                        <a href="/machiner/detail/{{ $machine->id }}">
                                            <span class="badge bg-secondary text-white">Breakdown Unschedule</span>
                                        </a>
                                    @elseif($machine->status == 13)
                                        <a href="/machiner/detail/{{ $machine->id }}">
                                            <span class="badge bg-info text-white">Standby Request</span>
                                        </a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                                        aria-controls="collapse{{ $index }}" data-index="{{ $index }}">
                                        <i class="ni ni-bold-down" style="margin-left: auto;"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="p-0">
                                    <div class="accordion" id="accordion{{ $index }}">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading{{ $index }}"></h2>
                                            <div id="collapse{{ $index }}" class="accordion-collapse collapse pt-0"
                                                aria-labelledby="heading{{ $index }}"
                                                data-bs-parent="#accordion{{ $index }}">
                                                <div class="accordion-body">
                                                    <div class="row justify-content-end">
                                                        {{-- <div class="col-6 col-sm-3">
                                                            <form action="{{ url('status-mesin') }}" method="POST"
                                                                class="w-100">
                                                                @csrf
                                                                <input type="hidden" name="machine_id"
                                                                    value="{{ $machine->id }}">
                                                                <input type="hidden" name="status" value="1">
                                                                @if ($machine->status == 2)
                                                                    <button type="button" class="btn btn-success w-100"
                                                                        disabled>Mesin sedang digunakan</button>
                                                                @else
                                                                    <button type="submit"
                                                                        class="btn btn-success w-100">Ready</button>
                                                                @endif
                                                            </form>
                                                        </div>
                                                        <div class="col-6 col-sm-3">
                                                            <form action="{{ url('status-mesin') }}" method="POST"
                                                                class="w-100">
                                                                @csrf
                                                                <input type="hidden" name="machine_id"
                                                                    value="{{ $machine->id }}">
                                                                <input type="hidden" name="status" value="2">
                                                                <button type="submit" class="btn btn-light w-100">Sedang
                                                                    Digunakan</button>
                                                            </form>
                                                        </div> --}}
                                                        {{-- Breakdown Schedule --}}
                                                        <div class="col-4">
                                                            <button data-bs-toggle="modal"
                                                                data-bs-target="#modalSchedule{{ $machine->id }}"
                                                                class="btn btn-sm bg-warning my-0 text-white">Breakdown
                                                                Schedule</button>
                                                        </div>
                                                        {{-- modal Schedule --}}
                                                        <div class="modal fade" id="modalSchedule{{ $machine->id }}"
                                                            data-bs-backdrop="static" data-bs-keyboard="false"
                                                            tabindex="-1"
                                                            aria-labelledby="modalSchedule{{ $machine->id }}Label"
                                                            aria-hidden="false">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-gradient-primary">
                                                                        <h1 class="modal-title fs-5 text-white"
                                                                            id="modalSchedule{{ $machine->id }}Label">
                                                                            Estimasi</h1>
                                                                    </div>
                                                                    <form action="{{ url('status-mesin') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <input type="hidden" name="machine_id"
                                                                                value="{{ $machine->id }}">
                                                                            <div class="my-3">
                                                                                <input type="date" name="estimasi"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                            <div class="my-3">
                                                                                <textarea name="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end px-3">
                                                                            <button type="button"
                                                                                class="btn btn-secondary me-2"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <input type="hidden" name="status"
                                                                                value="11">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Breakdown Unschedule --}}
                                                        <div class=" col-4">
                                                            <button data-bs-toggle="modal"
                                                                data-bs-target="#modalUnschedule{{ $machine->id }}"
                                                                class="btn btn-sm bg-primary my-0 text-white">Breakdown
                                                                Unschedule</button>
                                                        </div>
                                                        {{-- modal Unschedule --}}
                                                        <div class="modal fade" id="modalUnschedule{{ $machine->id }}"
                                                            data-bs-backdrop="static" data-bs-keyboard="false"
                                                            tabindex="-1"
                                                            aria-labelledby="modalUnschedule{{ $machine->id }}Label"
                                                            aria-hidden="false">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-gradient-primary">
                                                                        <h1 class="modal-title fs-5 text-white"
                                                                            id="modalUnschedule{{ $machine->id }}Label">
                                                                            Estimasi</h1>
                                                                    </div>
                                                                    <form action="{{ url('status-mesin') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <input type="hidden" name="machine_id"
                                                                                value="{{ $machine->id }}">
                                                                            <div class="my-3">
                                                                                <input type="date" name="estimasi"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                            <div class="my-3">
                                                                                <textarea name="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end px-3">
                                                                            <button type="button"
                                                                                class="btn btn-secondary me-2"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <input type="hidden" name="status"
                                                                                value="12">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Breakdown Standby Request --}}
                                                        <div class=" col-4">
                                                            <button data-bs-toggle="modal"
                                                                data-bs-target="#modalStanby{{ $machine->id }}"
                                                                class="btn btn-sm bg-info my-0 text-white">Standby
                                                                Request</button>
                                                        </div>
                                                        {{-- modal Standby --}}
                                                        <div class="modal fade" id="modalStanby{{ $machine->id }}"
                                                            data-bs-backdrop="static" data-bs-keyboard="false"
                                                            tabindex="-1"
                                                            aria-labelledby="modalStanby{{ $machine->id }}Label"
                                                            aria-hidden="false">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-gradient-primary">
                                                                        <h1 class="modal-title fs-5 text-white"
                                                                            id="modalSchedule{{ $machine->id }}Label">
                                                                            Estimasi</h1>
                                                                    </div>
                                                                    <form action="{{ url('status-mesin') }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <input type="hidden" name="machine_id"
                                                                                value="{{ $machine->id }}">
                                                                            <div class="my-3">
                                                                                <input type="date" name="estimasi"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                            <div class="my-3">
                                                                                <textarea name="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end px-3">
                                                                            <button type="button"
                                                                                class="btn btn-secondary me-2"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <input type="hidden" name="status"
                                                                                value="13">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

        $('.accordion-button').on('click', function() {
            const $this = $(this);
            const $collapse = $this.closest('.accordion-item').find('.accordion-collapse');
            $('.accordion-collapse.show').not($collapse).collapse('hide');
        });

        function showAlert() {
            alert("Mesin sedang digunakan");
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form[action="{{ url('status-mesin') }}"]');
            forms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    const status = parseInt(this.querySelector('input[name="status"]').value);
                    if (status !== 1) {
                        this.querySelector('button[type="submit"]').disabled = true;
                    }
                });
            });
        });
    </script>
@endpush
