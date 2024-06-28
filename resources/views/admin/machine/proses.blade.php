@extends('layouts.template')

@push('css')
@endpush

@section('content')
    <div class="card mb-4">
        <div class="card-header pb-0 d-flex justify-content-between">
            <p class="h4">{{ $mesin->name }} Proses</p>
            <button class="btn btn-sm bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#tambahProses">Tambah
                Proses</button>
        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="card-body">
            @foreach ($mesin->proses as $proses)
                <div class="accordion-item ">
                    <h5 class="accordion-header justify-content-between d-flex border-bottom"
                        id="heading{{ $proses->id }}">
                        <button class="accordion-button  font-weight-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $proses->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $proses->id }}">
                            {{ $loop->iteration . '. ' . $proses->name }}
                        </button>
                        <a data-bs-toggle="modal" data-bs-target="#tambahSub{{ $proses->id }}"
                            class="text-primary me-4 pt-3"> <i class="fas fa-plus fs-6"></i></a>
                        <a data-bs-toggle="modal" data-bs-target="#editProses{{ $proses->id }}"
                            class="text-primary me-3 pt-3"> <i class="fas fa-edit fs-6"></i> </a>
                        <form onsubmit="return confirm('Apakah anda yakin mau menghapus Proses {{ $proses->name }} ?')"
                            class="d-inline" action="{{ url('mesin/hapus-proses/' . $proses->id) }}" method="POST">
                            @csrf
                            <button class="text-danger border-none pt-3 bg-transparent" type="submit"
                                style="border:none !important;"><i class="fas fa-trash fs-6"></i></button>
                        </form>
                    </h5>
                    <div id="collapse{{ $proses->id }}" class="accordion-collapse collapse show"
                        aria-labelledby="heading{{ $proses->id }}" data-bs-parent="#accordionRental">
                        <div class="accordion-body text-sm opacity-8 row">
                            @foreach ($proses->subProses as $sub)
                                <div class="accordion-item ps-sm-4">
                                    <h5 class="accordion-header justify-content-between d-flex border-bottom"
                                        id="heading{{ $sub->id }}">
                                        <button class="accordion-button  font-weight-bold text-secondary" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $sub->id }}"
                                            aria-expanded="false" aria-controls="collapse{{ $sub->id }}">
                                            {{ $sub->name }}
                                        </button>
                                        <a data-bs-toggle="modal" data-bs-target="#editSub{{ $sub->id }}"
                                            class="text-primary me-3 pt-3"> <i class="fas fa-edit fs-6"></i> </a>
                                        <form
                                            onsubmit="return confirm('Apakah anda yakin mau menghapus Sub-proses {{ $sub->name }} ?')"
                                            class="d-inline" action="{{ url('mesin/hapus-sub/' . $sub->id) }}"
                                            method="POST">
                                            @csrf
                                            <button class="text-danger border-none pt-3 bg-transparent" type="submit"
                                                style="border:none !important;"><i class="fas fa-trash fs-6"></i></button>
                                        </form>
                                    </h5>
                                    <div id="collapse{{ $sub->id }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ $sub->id }}" data-bs-parent="#accordionRental">
                                        <div class="accordion-body text-sm opacity-8 row">
                                            <div class="row mb-2 mx-3 px-3 py-0">
                                                <div class="col-6 border-end">
                                                    <span class="text-xs">
                                                        Spindle Speed : {{ $sub->spindle_speed }} RPM<br>
                                                        Feedrate : {{ $sub->feedrate }}
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    <span class="text-xs">
                                                        Stock To Leave : {{ $sub->stock_to_leave }} <br>
                                                        Time : {{ $sub->estimate_time }}
                                                    </span>
                                                </div>
                                                <div class="col-12 border-top  border-bottom row">
                                                    <div class="col-4  border-end">
                                                        <span class="text-xs">Tool : {{ $sub->tool }}</span>
                                                    </div>
                                                    <div class="col-4 border-end">
                                                        <span class="text-xs">Corner Radius :
                                                            {{ $sub->corner_radius }}</span>
                                                    </div>
                                                    <div class="col-4">
                                                        <span class="text-xs">Holder : {{ $sub->holder }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                @foreach ($proses->subProses as $subModal)
                    <div class="modal fade" id="editSub{{ $subModal->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-gradient-primary">
                                    <h5 class="modal-title text-white" id="exampleModalLabel">Update Sub Proses
                                        :
                                        {{ $subModal->name }}</h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{ url('/mesin/edit-subproses/' . $subModal->id) }}"
                                        enctype="multipart/form-data" class="row">
                                        @csrf
                                        <div class="col-12 mb-3">
                                            <label for="example-text-input" class="form-control-label">Nama
                                                Sub-Proses</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="Nama SubProses" aria-label="Nama Sub-Proses"
                                                aria-describedby="name-subproses-addon" required
                                                value="{{ $subModal->name }}">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label for="example-text-input" class="form-control-label">Spindle
                                                Speed</label>
                                            <input type="number" id="spindle_speed" min="0" name="spindle_speed"
                                                class="form-control" placeholder="3500" aria-label="spindle_speed"
                                                aria-describedby="spindle_speed-addon"
                                                value="{{ $subModal->spindle_speed }}">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label for="example-text-input" class="form-control-label">Feedrate</label>
                                            <input type="number" min="0" step="0.1" id="feedrate"
                                                name="feedrate" class="form-control" placeholder="1200.0"
                                                value="{{ $subModal->feedrate }}" aria-label="feedrate"
                                                aria-describedby="feedrate-addon">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label for="example-text-input" class="form-control-label">Stock
                                                to Leave</label>
                                            <input type="number" min="0" step="0.1" id="stock_to_leave"
                                                name="stock_to_leave" class="form-control" placeholder="0.0"
                                                value="{{ $subModal->stock_to_leave }}" aria-label="stock_to_leave"
                                                aria-describedby="stock_to_leave-addon">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label for="example-text-input" class="form-control-label">Estimate
                                                Time</label>
                                            <input type="text" id="estimate_time" name="estimate_time"
                                                class="form-control" placeholder="00:00:00"
                                                value="{{ $subModal->estimate_time }}" aria-label="estimate_time"
                                                aria-describedby="estimate_time-addon"
                                                pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label for="example-text-input" class="form-control-label">Corner
                                                Radius</label>
                                            <input type="number" min="0" step="0.1" id="corner_radius"
                                                name="corner_radius" class="form-control" placeholder="0.0"
                                                value="{{ $subModal->corner_radius }}" aria-label="corner_radius"
                                                aria-describedby="corner_radius-addon">
                                        </div>
                                        <div class="mb-3 col-sm-6">
                                            <label for="example-text-input" class="form-control-label">Holder</label>
                                            <input type="number" min="0" step="0.1" id="holder"
                                                name="holder" class="form-control" placeholder="0.0"
                                                value="{{ $subModal->holder }}" aria-label="holder"
                                                aria-describedby="holder-addon">
                                        </div>
                                        <div class="mb-3 col-12">
                                            <label for="exampleDataList" class="form-label">Tool</label>

                                            <select name="tool" id="" class="form-select text-dark">
                                                <option value="{{ $subModal->holder }}">{{ $subModal->tool }}</option>
                                                @php $displayedNames = []; @endphp
                                                @foreach ($tools as $tool)
                                                    @if (!in_array($tool->tool_name . ', ' . $tool->size, $displayedNames))
                                                        <option value="{{ $tool->tool_name . ', ' . $tool->size }}">
                                                            {{ $tool->tool_name . ', ' . $tool->size }}
                                                        </option>
                                                        <?php $displayedNames[] = $tool->tool_name . ', ' . $tool->size; ?>
                                                    @endif
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="modal fade" id="tambahSub{{ $proses->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-primary">
                                <h5 class="modal-title text-white" id="exampleModalLabel">Tambah Sub Proses :
                                    {{ $proses->name }}</h5>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                    aria-label="Close">
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{ url('/mesin/tambah-subproses') }}"
                                    enctype="multipart/form-data" class="row">
                                    @csrf
                                    <input type="hidden" id="proses_id" name="proses_id" class="form-control" required
                                        disable value="{{ $proses->id }}">
                                    <div class="col-12 mb-3">
                                        <label for="example-text-input" class="form-control-label">Nama Sub-Proses</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="Nama SubProses" aria-label="Nama Sub-Proses"
                                            aria-describedby="name-subproses-addon" required>
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="example-text-input" class="form-control-label">Spindle Speed</label>
                                        <input type="number" id="spindle_speed" min="0" name="spindle_speed"
                                            class="form-control" placeholder="3500" value="3500"
                                            aria-label="spindle_speed" aria-describedby="spindle_speed-addon">
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="example-text-input" class="form-control-label">Feedrate</label>
                                        <input type="number" min="0" step="0.1" id="feedrate"
                                            name="feedrate" class="form-control" placeholder="1200.0" value="1200.0"
                                            aria-label="feedrate" aria-describedby="feedrate-addon">
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="example-text-input" class="form-control-label">Stock to Leave</label>
                                        <input type="number" min="0" step="0.1" id="stock_to_leave"
                                            name="stock_to_leave" class="form-control" placeholder="0.0" value="0.0"
                                            aria-label="stock_to_leave" aria-describedby="stock_to_leave-addon">
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="example-text-input" class="form-control-label">Estimate Time</label>
                                        <input type="text" id="estimate_time" name="estimate_time"
                                            class="form-control" placeholder="00:00:00" value="00:00:00"
                                            aria-label="estimate_time" aria-describedby="estimate_time-addon"
                                            pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]">
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="example-text-input" class="form-control-label">Corner Radius</label>
                                        <input type="number" min="0" step="0.1" id="corner_radius"
                                            name="corner_radius" class="form-control" placeholder="0.0" value="0.0"
                                            aria-label="corner_radius" aria-describedby="corner_radius-addon">
                                    </div>
                                    <div class="mb-3 col-sm-6">
                                        <label for="example-text-input" class="form-control-label">Holder</label>
                                        <input type="number" min="0" step="0.1" id="holder"
                                            name="holder" class="form-control" placeholder="0.0" value="100.0"
                                            aria-label="holder" aria-describedby="holder-addon">
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="exampleDataList" class="form-label">Tool</label>
                                        <select name="tool" id="" class="form-select text-dark">
                                            <option value="">-- Pilih --</option>
                                            @php $displayedNames = []; @endphp
                                            @foreach ($tools as $tool)
                                                @if (!in_array($tool->tool_name . ', ' . $tool->size, $displayedNames))
                                                    <option value="{{ $tool->tool_name . ', ' . $tool->size }}">
                                                        {{ $tool->tool_name . ', ' . $tool->size }}
                                                    </option>
                                                    <?php $displayedNames[] = $tool->tool_name . ', ' . $tool->size; ?>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editProses{{ $proses->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-primary">
                                <h5 class="modal-title text-white" id="exampleModalLabel">Tambah Proses
                                </h5>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                    aria-label="Close">

                                </button>
                            </div>
                            <form method="post" action="{{ url('/mesin/edit-proses/' . $proses->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Nama Proses</label>
                                        <input class="form-control" type="text" name="name"
                                            placeholder="Masukkan nama proses" id="example-text-input" required
                                            value="{{ old('name', $proses->name) }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn bg-gradient-primary">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="tambahProses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Tambah Proses
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <form method="post" action="{{ url('/mesin/tambah-proses') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="machine_id" value="{{ $mesin->id }}">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Nama Proses</label>
                            <input class="form-control" type="text" name="name" placeholder="Masukkan nama proses"
                                id="example-text-input" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                    </div>
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
