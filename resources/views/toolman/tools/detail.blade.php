@extends('layouts.template')

@push('css')
    <link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="card mb-4">
        <div class="card-header mb-3 pb-0 bg-gradient-primary">
            <a href="{{ url('toolman/tools') }}">
                <h6 class="text-info"><i class="fas fa-chevron-left"></i> Kembali</h6>
            </a>
            <div class="d-flex justify-content-between">
                <p class="h5 text-white">Daftar Alat yang Dibutuhkan</p>
                <p class="h5 text-white"> {{ $order->order_number }}</p>
            </div>

        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="swalwarning" data-swal="{{ session('warning') }}"></div>
        <div class="card-body px-md-4 pt-0">
            @if ($jadwal->start_actual != null)
                <form action="{{ url('tool/submit') }}" method="post">


                    @csrf
                    <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                    <div class="table-responsive">
                        <table class="table">
                            <tr class="bg-light">
                                <th class="text-center">Nama Alat</th>
                                <th class="text-center">Ukuran</th>
                                <th class="text-center">Kode</th>

                            </tr>
                            @foreach ($toolsOrder as $tool)
                                <tr>
                                    <td class="text-center">{{ $tool->tools->tool_name }}</td>
                                    <td class="text-center">{{ $tool->tools->size }}</td>
                                    <td class="text-center">
                                        <select name="alat[]" class="form-select tool-select" id="selectTools-{{ $tool->id }}">
                                            <option value="{{ $tool->id . '-' . $tool->tools_id }}" hidden selected>
                                                {{ $tool->tools->tool_code }}
                                            </option>
                                            @foreach ($tools as $option)
                                                @if ($option->tool_name == $tool->tools->tool_name && $option->size == $tool->tools->size)
                                                    @if ($option->status == 2)
                                                        <option value="" disabled class="text-secondary">
                                                            {{ $option->tool_code }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $tool->id . '-' . $option->id }}">
                                                            {{ $option->tool_code }}
                                                        </option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>

                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" id="warning-message" class="text-danger text-end pe-5">
                                    {{-- Menampilkan peringatan --}}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end">
                        <input type="hidden" name="status[]" value="7">
                        <button type="submit" class="btn btn-sm bg-gradient-primary w-35 mx-2">Simpan</button>
                    </div>
                </form>
            @endif
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectElements = document.querySelectorAll('select[id^="selectTools-"]');
            var warningMessage = document.getElementById('warning-message');
    
            function logAllSelectedOptions() {
                var selectedTextArray = [];
                var duplicates = [];
    
                selectElements.forEach(function(selectElement) {
                    var selectedOption = selectElement.options[selectElement.selectedIndex];
                    var selectedText = selectedOption.text;
                    
                    if (selectedTextArray.includes(selectedText)) {
                        duplicates.push(selectedText);
                    } else {
                        selectedTextArray.push(selectedText);
                    }
                });
    
                if (duplicates.length > 0) {
                    document.querySelector('.btn.bg-gradient-primary').disabled = true;
                    warningMessage.innerHTML = "Ada kode tolls yang sama : " + duplicates.join(', ');
                } else {
                    document.querySelector('.btn.bg-gradient-primary').disabled = false;
                    warningMessage.innerHTML = "";
                }
            }
    
            logAllSelectedOptions();
    
            selectElements.forEach(function(selectElement) {
                selectElement.addEventListener('change', function() {
                    logAllSelectedOptions();
                });
            });
        });
    </script>
    
    
@endpush
