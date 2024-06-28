@extends('layouts.template')

@push('css')
@endpush

@section('content')
<div class="row justify-content-center">
    <div class=" row col-md-8">
        <div class="card mb-4 col-md-10">
            <div class="card-header pb-0 d-flex justify-content-between">
                <h5>Tambah</h5>
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
            <form method="post" action="{{ url('/prog/tools') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="id_order" class="form-control-label">Pilih Pesanan</label>
                    <select class="form-select form-control-md" name="order_number" id="order_number" required>
                        <option value="">Pilih pesanan yang di proses</option>
                        @foreach ($orders as $order)
                            @if ($order->status == 3)
                                <option value="{{ $order->order_number }}">{{ $order->order_number }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Pilih Tools</label>
                    <div id="tools_checkbox_group">
                        <!-- Assuming $tools is your array of tools -->
                        @foreach ($tools as $index )
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tools_id[]" id="tool_{{ $index->id }}"
                                value="{{ $index->id }}">
                            <label class="form-check-label" for="tool_{{ $index->id }}">
                                {{ $index->tool_name }}, {{ $index->size }}
                            </label>
                        </div>
                        @endforeach
                    </div>
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