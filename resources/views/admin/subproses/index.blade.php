@extends('layouts.template')

@push('css')
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="card mb-4 me-sm-3">
        <div class="card-header pb-0 ">
            <a href="{{ route('proses.index') }}">
                <h6 class="text-info"><i class="fas fa-chevron-left"></i> Kembali</h6>
            </a>
            <div class="d-flex justify-content-between">
                <p class="h4">Proses {{ $proses->name }}</p>
                <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-primary btn-sm">Tambah</a>
            </div>

        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="card-body pt-0">
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
            <div class="accordion" id="accordionRental">
                @foreach ($subproses as $sub)
                <div class="accordion-item ">
                    <h5 class="accordion-header justify-content-between d-flex border-bottom"
                        id="heading{{ $sub->id }}">
                        <button class="accordion-button  font-weight-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $sub->id }}" aria-expanded="false"
                            aria-controls="collapse{{ $sub->id }}">
                            {{ $sub->name }}
                        </button>
                        <a data-bs-toggle="modal" data-bs-target="#exampleModal{{ $sub->id }}"
                            class="text-primary me-3 pt-3"> <i class="fas fa-edit fs-6"></i> </a>
                        <form onsubmit="return confirm('Apakah anda yakin mau menghapus Sub-proses {{ $sub->name }} ?')"
                            class="d-inline" action="{{ route('subproses.destroy', $sub->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button class="text-danger border-none pt-3 bg-transparent" type="submit"
                                style="border:none !important;"><i class="fas fa-trash fs-6"></i></button>
                        </form>
                    </h5>
                    <div id="collapse{{ $sub->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $sub->id }}" data-bs-parent="#accordionRental">
                        <div class="accordion-body text-sm opacity-8 row">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>SPINDLE SPEED</th>
                                        <td>: {{ $sub->spindle_speed }} RPM</td>
                                        <th>FEEDRATE</th>
                                        <td>: {{ $sub->feedrate }}</td>
                                        <th>STOCK TO LEAVE</th>
                                        <td>: {{ $sub->stock_to_leave }}</td>
                                    </tr>
                                    <tr>
                                        <th>ESTIMATE TIME</th>
                                        <td>: {{ $sub->estimate_time }}</td>
                                        <th>CORNER RADIUS</th>
                                        <td>: {{ $sub->corner_radius }}</td>
                                        <th>HOLDER</th>
                                        <td>: {{ $sub->holder }}</td>
                                    </tr>
                                    <tr></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal{{ $sub->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ubah Sub Proses {{ $proses->name }}
                                </h5>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" class="row" action="{{ route('subproses.update', $sub->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="proses_id" name="proses_id" class="form-control" required
                                        disable value="{{ $proses->id }}">
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-control-label">Nama
                                            Sub-Proses</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="Nama SubProses" aria-label="Nama Sub-Proses"
                                            aria-describedby="name-subproses-addon" required value="{{ $sub->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-control-label">Spindle
                                            Speed</label>
                                        <input type="number" id="spindle_speed" min="0" name="spindle_speed"
                                            class="form-control" placeholder="3500" value="3500"
                                            aria-label="spindle_speed" aria-describedby="spindle_speed-addon"
                                            value="{{ $sub->spindle_speed }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-control-label">Feedrate</label>
                                        <input type="number" min="0" step="0.1" id="feedrate" name="feedrate"
                                            class="form-control" placeholder="1200.0" value="1200.0"
                                            aria-label="feedrate" aria-describedby="feedrate-addon"
                                            value="{{ $sub->feedrate }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-control-label">Stock to
                                            Leave</label>
                                        <input type="number" min="0" step="0.1" id="stock_to_leave"
                                            name="stock_to_leave" class="form-control" placeholder="0.0" value="0.0"
                                            aria-label="stock_to_leave" aria-describedby="stock_to_leave-addon"
                                            value="{{ $sub->stock_to_leave }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-control-label">Estimate
                                            Time</label>
                                        <input type="text" id="estimate_time" name="estimate_time" class="form-control"
                                            placeholder="00:00:00" value="00:00:00" aria-label="estimate_time"
                                            aria-describedby="estimate_time-addon"
                                            pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]"
                                            value="{{ $sub->estimate_time }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-control-label">Corner
                                            Radius</label>
                                        <input type="number" min="0" step="0.1" id="corner_radius" name="corner_radius"
                                            class="form-control" placeholder="0.0" value="0.0"
                                            aria-label="corner_radius" aria-describedby="corner_radius-addon"
                                            value="{{ $sub->corner_radius }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-control-label">Holder</label>
                                        <input type="number" min="0" step="0.1" id="holder" name="holder"
                                            class="form-control" placeholder="0.0" value="100.0" aria-label="holder"
                                            aria-describedby="holder-addon" value="{{ $sub->holder }}">
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
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sub Proses {{ $proses->name }}</h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ url('/proses/subproses/') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="proses_id" name="proses_id" class="form-control" required disable
                        value="{{ $proses->id }}">
                    <div class="mb-3">
                        <label for="example-text-input" class="form-control-label">Nama Sub-Proses</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nama SubProses"
                            aria-label="Nama Sub-Proses" aria-describedby="name-subproses-addon" required>
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-control-label">Spindle Speed</label>
                        <input type="number" id="spindle_speed" min="0" name="spindle_speed" class="form-control"
                            placeholder="3500" value="3500" aria-label="spindle_speed"
                            aria-describedby="spindle_speed-addon">
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-control-label">Feedrate</label>
                        <input type="number" min="0" step="0.1" id="feedrate" name="feedrate" class="form-control"
                            placeholder="1200.0" value="1200.0" aria-label="feedrate" aria-describedby="feedrate-addon">
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-control-label">Stock to Leave</label>
                        <input type="number" min="0" step="0.1" id="stock_to_leave" name="stock_to_leave"
                            class="form-control" placeholder="0.0" value="0.0" aria-label="stock_to_leave"
                            aria-describedby="stock_to_leave-addon">
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-control-label">Estimate Time</label>
                        <input type="text" id="estimate_time" name="estimate_time" class="form-control"
                            placeholder="00:00:00" value="00:00:00" aria-label="estimate_time"
                            aria-describedby="estimate_time-addon" pattern="([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]">
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-control-label">Corner Radius</label>
                        <input type="number" min="0" step="0.1" id="corner_radius" name="corner_radius"
                            class="form-control" placeholder="0.0" value="0.0" aria-label="corner_radius"
                            aria-describedby="corner_radius-addon">
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-control-label">Holder</label>
                        <input type="number" min="0" step="0.1" id="holder" name="holder" class="form-control"
                            placeholder="0.0" value="100.0" aria-label="holder" aria-describedby="holder-addon">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary">Submit</button>
                    </div>

                </form>
            </div>

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