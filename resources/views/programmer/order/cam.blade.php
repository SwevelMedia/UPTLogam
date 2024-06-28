@extends('layouts.template')

@push('css')
<link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/select2/select2-bootstrap4.css') }}">
@endpush

@section('content')
<div class="row">
    <div class=" col-10 mb-4">
        <div class="card bt-primary mb-3">
            <div class="card-body pb-2">
                <div class="card-header pb-0 pt-2 d-flex justify-content-between">
                    <span class="h4">{{ $order->order_name }}</span>
                    <span class="h4">{{ $order->order_number }}</span>
                </div>
                <hr class="bg-primary">
                <div class="d-flex justify-content-between">
                    <p class="h6">Alat</p>
                    <button type="button" id="tambahAlat" class="btn bg-gradient-info">Tambah Alat</button>
                </div>
                <div id="formTambahAlat" class="d-none shadow rounded bt-primary p-3 mb-3">
                <h3>Form tambah alat</h3>
                <form role="form" method="POST" action="{{ url('/prog/tools') }}">
                    @csrf
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-8">
                                <label class="mt-3">Pilih Alat</label>
                                <select name="tools" id="tools" class="form-select mb-3" required>
                                    <option value="">-- pilih --</option>
                                    @php
                                    $displayedTools = [
                                    'inisial' => [],
                                    'qty' => [],
                                    'id' => [],
                                    'nama' => [],
                                    ];
                                    $sudahada = [];
                                    @endphp
                                        @foreach ($toolsOrder as $tor)
                                            @php
                                                $sudahada[] = $tor->tools->tool_name . $tor->tools->size;
                                            @endphp
                                        @endforeach
                                    @foreach ($tools as $tool)
                                    @if (!in_array($tool->tool_name . $tool->size, $displayedTools['inisial']))
                                        @if (!in_array($tool->tool_name . $tool->size, $sudahada))
                                            @php
                                            $displayedTools['inisial'][] = $tool->tool_name . $tool->size;
                                            $displayedTools['qty'][] = '1';
                                            $displayedTools['id'][] = $tool->id;
                                            $displayedTools['nama'][] = $tool->tool_name . ' [ ' . $tool->size . ' ]';
                                            @endphp
                                        @endif
                                    @else
                                    @php
                                    $index = array_search(
                                    $tool->tool_name . $tool->size,
                                    $displayedTools['inisial'],
                                    );
                                    $displayedTools['qty'][$index]++;
                                    @endphp
                                    @endif
                                    @endforeach
                                    @for ($i = 0; $i < count($displayedTools['inisial']); $i++) <option
                                        value="{{ $displayedTools['id'][$i] }}" data-jumlah="{{ $displayedTools['qty'][$i] }}">
                                        {{ $displayedTools['nama'][$i] }} Ready {{ $displayedTools['qty'][$i] }}
                                        </option>
                                        @endfor
                                </select>

                            </div>
                            <div class="col-4">
                                <label class="mt-3">Qty</label>
                                <input type="number" class="form-control" id="qty" name="qty" value="1" min="1" max="1"
                                    required>
                            </div>
                        </div>
                        <input type="hidden" value="{{ $order->order_number }}" name="order_number">
                    </div>
                    <div class="justify-content-end d-flex m-0">
                        <button type="button" id="batalTambah" class="btn btn-secondary me-2 " data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary ">Simpan</button>
                    </div>
                    </form>
                </div>
                <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                <table class="table">
                    <tr class="bg-light">
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th class="text-center">Ukuran</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                    @php
                    $name = [
                    'inisial' => [],
                    'nama' => [],
                    'size' => [],
                    'qty' => [],
                    'id' => [],
                    ];
                    @endphp

                    @if (count($toolsOrder) > 0)
                    @foreach ($toolsOrder as $to)
                    @php
                    $toolKey = $to->tools->tool_name . $to->tools->size;
                    @endphp
                    @if (!in_array($toolKey, $name['inisial']))
                    @php
                    $name['inisial'][] = $toolKey;
                    $name['nama'][] = $to->tools->tool_name;
                    $name['size'][] = $to->tools->size;
                    $name['qty'][] = 1;
                    $name['id'][] = $to->tools->id;
                    @endphp
                    @else
                    @php
                    $index = array_search($toolKey, $name['inisial']);
                    $name['qty'][$index]++;
                    @endphp
                    @endif
                    @endforeach
                    @endif
                    @if (count($toolsOrder)==0)
                    <td colspan="5" class="text-center align-middle fw-bold text-danger">Belum ada alat yang dipilih, silahkan tambah alat !!!</td>
                    @endif

                    @for ($i = 0; $i < count($name['inisial']); $i++) <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $name['nama'][$i] }}</td>
                        <td class="text-center">{{ $name['size'][$i] }}</td>
                        <td class="text-center">{{ $name['qty'][$i] }}</td>
                        <td class="text-center">
                            <form role="form" method="POST" action="{{ route('toolorder.delete') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $name['id'][$i] }}">
                                <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                                <button type="submit" class="fs-6 bg-transparent text-danger" style="border:none;"><i
                                        class="fa fa-trash"></i></button>
                            </form>

                        </td>
                        </tr>
                        @endfor


                </table>

                <form action="{{ url('prog/upload-cam') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <p class="h6">upload CAM</p>
                    <input type="hidden" name="order_number" value="{{ $order->order_number }}">

                    <input type="file" id="camFile" required multiple name="cam[]" class="form-control mb-3"
                        accept=".pdf, .NC">


                    <div class="row">
                        <p class="h6 mb-0">Jumlah Proses</p>
                        @foreach ($order->machineOrders as $mo)
                        <div class="col-sm-3">
                            <label class="text-secondary">{{ $mo->mesin->machine_code }}</label>
                            <input type="number" min="1" class="form-control mb-3" name="proses[]" required>
                        </div>
                        @endforeach
                    </div>
                    <label for="">Keterangan</label>
                    <input type="text" class="form-control mb-3" name="information">
            </div>
        </div>
        @if (count($toolsOrder)>0)
        <button class="w-100 btn bg-gradient-primary text-white" type="submit">Simpan</button>
        @else
        <button class="w-100 btn bg-gradient-secondary text-white" disabled>Simpan</button>
        @endif
        </form>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="{{ asset('assets/select2/select2.min.js') }}"></script>
<script>
$('#tools').select2({
    theme: 'bootstrap4',
    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
    placeholder: $(this).data('placeholder'),
    allowClear: Boolean($(this).data('allow-clear')),
}).on('change', function() {
    var selectedData = $(this).select2('data')[0];
    var selectedJumlah = $(selectedData.element).data('jumlah');
    $('#qty').attr('max', selectedJumlah);
});
</script>

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
<script>
    var tombol = document.getElementById('tambahAlat');
    var formTambahAlat = document.getElementById('formTambahAlat');
    var tombolBatal = document.getElementById('batalTambah');

    if(localStorage.getItem('dataForm')) {
        var dataForm = localStorage.getItem('dataForm');
        if(dataForm === "tampil"){
            formTambahAlat.classList.remove('d-none');
            formTambahAlat.classList.add('d-block');
        }
    }

    tombol.addEventListener('click', function() {
        formTambahAlat.classList.remove('d-none');
        formTambahAlat.classList.add('d-block');
        localStorage.setItem('dataForm', "tampil");
    });

    tombolBatal.addEventListener('click', function() {
        formTambahAlat.classList.remove('d-block');
        formTambahAlat.classList.add('d-none');
        localStorage.removeItem('dataForm');
        console.log(localStorage.getItem('dataForm'))
    });
</script>

<script>
document.getElementById('tools').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var jumlah = selectedOption.getAttribute('data-jumlah');
    console.log("ceng" + jumlah)
    document.getElementById('qty').max = jumlah;
});
</script>
@endpush
