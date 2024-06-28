@extends('layouts.template')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/daterangepicker/daterangepicker.css') }}">
@endpush

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-gradient-primary pb-2 border-bottom d-flex justify-content-between">
            <a href="{{ route('order.index') }}">
                <h6 class="text-info"><i class="fas fa-chevron-left"></i> Kembali</h6>
            </a>
            <p class="h4 text-white">Atur Jadwal {{ $order->order_number }} </p>
        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="card-body pb-2">
            @if ($errors->any())
                <div class="my-2">
                    <div class="alert text-white alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @php
                $semua = 1;
            @endphp
            <form role="form" class="row" method="POST" action="{{ url('/order/submit-jadwal/') }}"
                enctype="multipart/form-data" class="row" onsubmit="return validateForm()">
                @csrf
                <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                <div class="table-responsive">
                    <table class="table">
                        <tr class="bg-light">
                            <th>Desc</th>
                            <th>Status</th>
                            <th>Plan</th>
                            <th>Durasi</th>
                            <th>Total Durasi</th>
                        </tr>
                        <tr>
                            <th>CAD</th>
                            <td>
                                @php $readycad = true; @endphp
                                @foreach ($order->scheduleCAD->employee->schedule as $sch)
                                    @if ($sch->stop_actual == null && $sch->order_number != $order->order_number )
                                        <li class="text-sm" style="list-style: none">
                                            <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                            {{ $sch->order_number }} |
                                            @if($sch->stop_plan)
                                                @if ($sch->start_actual != null)
                                                    {{ date('d/m/Y', strtotime($sch->start_actual)) }}
                                                @else
                                                    Belum mulai
                                                @endif <i class="fa-solid fa-arrow-right"></i>
                                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Estimasi selesai {{ date('d M Y', strtotime(str_replace('/', '-', $sch->stop_plan))) }}">
                                                    {{ $sch->stop_plan }}</a>
                                            @else
                                                Belum di Schedule
                                            @endif
                                        </li>
                                        @php $readycad = false; @endphp
                                    @endif
                                @endforeach

                                @if ($readycad)
                                    <i class="fa-solid fa-circle-check text-success"></i> Ready
                                @endif
                            </td>

                            <td>
                                <input type="text" id="date-cad" name="cad" autocomplete="off" readonly required
                                    class="form-control" value="">
                            </td>
                            <td id="total-cad" >
                            </td>
                            <input type="hidden" id="total-cad-val" value="0">
                            <td id="total-durasi" rowspan="1" class="text-center align-middle fw-bolder" ></td>
                        </tr>
                        <input type="hidden" id="need_design" value="{{ $order->need_design }}">
                        @if ($order->need_design == 1)
                            @php
                                $semua = $semua+2;
                            @endphp
                            <tr>
                                <th>CAM</th>
                                <td>
                                    @php $readycam = true; @endphp
                                    @foreach ($order->scheduleCAM->employee->schedule as $sch)
                                        @if ($sch->stop_actual == null && $sch->order_number != $order->order_number )
                                            <li class="text-sm" style="list-style: none">
                                                <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                                {{ $sch->order_number }} |
                                                @if($sch->stop_plan)
                                                    @if ($sch->start_actual != null)
                                                        {{ date('d/m/Y', strtotime($sch->start_actual)) }}
                                                    @else
                                                        Belum mulai
                                                    @endif <i class="fa-solid fa-arrow-right"></i>
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Estimasi selesai {{ date('d M Y', strtotime(str_replace('/', '-', $sch->stop_plan))) }}">
                                                        {{ $sch->stop_plan }}</a>
                                                @else
                                                    Belum di Schedule
                                                @endif
                                            </li>
                                            @php $readycam = false; @endphp
                                        @endif
                                    @endforeach

                                    @if ($readycam)
                                        <i class="fa-solid fa-circle-check text-success"></i> Ready
                                    @endif
                                </td>
                                <td>
                                    <input type="text" id="date-cad" name="cam" autocomplete="off" required
                                        class="form-control" value="" readonly>
                                </td>
                                <td id="total-cam">

                                </td>
                                <input type="hidden" id="total-cam-val" value="0">
                            </tr>
                            <tr>
                                <th>TOOLS</th>
                                <td>
                                    @php $readytools = true; @endphp
                                    @foreach ($order->scheduleTOOLS->employee->schedule as $sch)
                                        @if ($sch->stop_actual == null && $sch->order_number != $order->order_number )
                                            <li class="text-sm" style="list-style: none">
                                                <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                                {{ $sch->order_number }} |
                                                @if($sch->stop_plan)
                                                    @if ($sch->start_actual != null)
                                                        {{ date('d/m/Y', strtotime($sch->start_actual)) }}
                                                    @else
                                                        Belum mulai
                                                    @endif <i class="fa-solid fa-arrow-right"></i>
                                                    <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Estimasi selesai {{ date('d M Y', strtotime(str_replace('/', '-', $sch->stop_plan))) }}">
                                                        {{ $sch->stop_plan }}</a>
                                                @else
                                                    Belum di Schedule
                                                @endif
                                            </li>
                                            @php $readytools = false; @endphp
                                        @endif
                                    @endforeach

                                    @if ($readytools)
                                        <i class="fa-solid fa-circle-check text-success"></i> Ready
                                    @endif
                                </td>
                                <td>
                                    <input type="text" id="date-cad" name="tool" autocomplete="off" required
                                        class="form-control" value="" readonly>
                                </td>
                                <td id="total-tools">

                                </td>
                                <input type="hidden" id="total-tools-val" value="0">
                            </tr>
                        @endif
                        @foreach ($mesin as $item)
                            @php
                                $semua++;
                            @endphp
                            <input type="hidden" name="descMesin[]" value="{{ strtoupper($item->mesin->machine_code) }}"
                                required>
                            <tr>
                                <th>P{{ $loop->iteration }}: {{ strtoupper($item->mesin->machine_code) }}</th>
                                <td>
                                    @if ($item->mesin->status == 1)
                                        <i class="fa-solid fa-circle-check text-success"></i> Ready
                                    @elseif ($item->mesin->status == 11)
                                        <i class="fa-solid fa-wrench text-warning"></i> Breakdown Schedule
                                    @elseif ($item->mesin->status == 12)
                                        <i class="fa-solid fa-times text-primary"></i> Breakdown
                                        Unschedule
                                    @elseif ($item->mesin->status == 13)
                                        <i class="fa-solid fa-cogs text-info"></i> Stanby Request
                                    @else
                                        @php $ready =true; @endphp
                                        @foreach ($item->mesin->machineOrder as $mo)
                                            @if ($mo->order->status >= 3)
                                                @php
                                                    $ready = false;
                                                    $jmlhProses = 0;
                                                    $selesai = 0;
                                                @endphp
                                                @foreach ($mo->operatorProses ?? [] as $op)
                                                    @php
                                                        $jmlhProses++;
                                                    @endphp
                                                    @if ($op->stop != null)
                                                        @php
                                                            $selesai++;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                <li class="text-sm" style="list-style: none">
                                                    <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                                    {{ $mo->order_number }}
                                                    @if ($mo->order->status >= 6)
                                                        | <a href="#" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="{{ $selesai }} dari {{ $jmlhProses }} proses selesai dikerjakan">{{ $selesai . '/' . $jmlhProses }}</a>
                                                    @endif
                                                    |
                                                    @foreach ($mo->order->schedule as $jadwal)
                                                        @if ($jadwal->desc == $mo->mesin->machine_code)
                                                            <a href="#" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Estimasi selesai {{ date('d M Y', strtotime(str_replace('/', '-', $jadwal->stop_plan))) }}">
                                                                {{ $jadwal->stop_plan }}
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </li>
                                            @endif
                                        @endforeach
                                        @if ($ready)
                                            <i class="fa-solid fa-circle-check text-success"></i> Ready
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <input type="text" id="date-cad" name="mesin[]" required autocomplete="off"
                                        class="form-control iteration-{{ $loop->iteration }}" value="" readonly>
                                </td>
                                <td id="total-mesin-{{ $loop->iteration }}">

                                </td>
                                <input type="hidden" id="total-mesin-val-{{ $loop->iteration }}" value="0">
                            </tr>
                            <tr></tr>
                        @endforeach
                    </table>

                    <button type="submit" class="btn btn-primary w-100">Simpan</button>

                </div>

            </form>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/daterangepicker/daterangepicker.js') }}"></script>
    <script>
        function extractDates(value) {
            return value.split('-').map(date => date.trim());
        }
    </script>
    <script type="text/javascript">
        $(function() {
            $('input[name="cad"]').daterangepicker({
                autoUpdateInput: false,
                opens: 'center',
                drops: 'auto',
                singleDatePicker: false,
                showDropdowns: true,
                maxSpan: {
                    "months": 1
                },
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD/MM/YYYY'
                }
            });

            $('input[name="cad"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));
                var numberOfDays = picker.endDate.diff(picker.startDate, 'days')+1;
                $('#total-cad').text(numberOfDays + ' hari');
                $('#total-cad-val').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));


                var allDates = [
                    ...extractDates(document.getElementById('total-cad-val').value)
                ];

                var need_design = document.getElementById('need_design').value;
                if (need_design == 1) {
                    if (document.getElementById('total-cam-val').value.trim() !== "0") {
                        allDates.push(...extractDates(document.getElementById('total-cam-val').value));
                    }
                    if (document.getElementById('total-tools-val').value.trim() !== "0") {
                        allDates.push(...extractDates(document.getElementById('total-tools-val').value));
                    }
                }

                document.querySelectorAll('[id^="total-mesin-val-"]').forEach(machine => {
                    if (machine.value.trim() !== "0") {
                        allDates.push(...extractDates(machine.value));
                    }
                });

                var parsedDates = allDates.map(dateStr => new Date(...dateStr.split('/').reverse())).sort((a, b) => a - b);
                var earliestDate = parsedDates[0];
                var latestDate = parsedDates[allDates.length - 1];
                var daysDifference = Math.floor((latestDate - earliestDate) / (1000 * 3600 * 24))+1;

                $('#total-durasi').text(daysDifference + ' hari');


            });

            $('input[name="cad"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('input[name="cam"]').daterangepicker({
                autoUpdateInput: false,
                opens: 'center',
                drops: 'auto',
                singleDatePicker: false,
                showDropdowns: true,
                maxSpan: {
                    "months": 1
                },
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD/MM/YYYY'
                }
            });

            $('input[name="cam"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));
                var numberOfDays = picker.endDate.diff(picker.startDate, 'days')+1;
                $('#total-cam').text(numberOfDays + ' hari');
                $('#total-cam-val').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));

                    var allDates = [
                    ...extractDates(document.getElementById('total-cad-val').value)
                ];

                var need_design = document.getElementById('need_design').value;
                if (need_design == 1) {
                    if (document.getElementById('total-cam-val').value.trim() !== "0") {
                        allDates.push(...extractDates(document.getElementById('total-cam-val').value));
                    }
                    if (document.getElementById('total-tools-val').value.trim() !== "0") {
                        allDates.push(...extractDates(document.getElementById('total-tools-val').value));
                    }
                }

                document.querySelectorAll('[id^="total-mesin-val-"]').forEach(machine => {
                    if (machine.value.trim() !== "0") {
                        allDates.push(...extractDates(machine.value));
                    }
                });

                var parsedDates = allDates.map(dateStr => new Date(...dateStr.split('/').reverse())).sort((a, b) => a - b);
                var earliestDate = parsedDates[0];
                var latestDate = parsedDates[allDates.length - 1];
                var daysDifference = Math.floor((latestDate - earliestDate) / (1000 * 3600 * 24))+1;

                $('#total-durasi').text(daysDifference + ' hari');
            });

            $('input[name="cam"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('input[name="tool"]').daterangepicker({
                autoUpdateInput: false,
                opens: 'center',
                drops: 'auto',
                singleDatePicker: false,
                showDropdowns: true,
                maxSpan: {
                    "months": 1
                },
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD/MM/YYYY'
                }
            });

            $('input[name="tool"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));
                var numberOfDays = picker.endDate.diff(picker.startDate, 'days')+1;
                $('#total-tools').text(numberOfDays + ' hari');
                $('#total-tools-val').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));

                var allDates = [
                    ...extractDates(document.getElementById('total-cad-val').value)
                ];

                var need_design = document.getElementById('need_design').value;
                if (need_design == 1) {
                    if (document.getElementById('total-cam-val').value.trim() !== "0") {
                        allDates.push(...extractDates(document.getElementById('total-cam-val').value));
                    }
                    if (document.getElementById('total-tools-val').value.trim() !== "0") {
                        allDates.push(...extractDates(document.getElementById('total-tools-val').value));
                    }
                }

                document.querySelectorAll('[id^="total-mesin-val-"]').forEach(machine => {
                    if (machine.value.trim() !== "0") {
                        allDates.push(...extractDates(machine.value));
                    }
                });

                var parsedDates = allDates.map(dateStr => new Date(...dateStr.split('/').reverse())).sort((a, b) => a - b);
                var earliestDate = parsedDates[0];
                var latestDate = parsedDates[allDates.length - 1];
                var daysDifference = Math.floor((latestDate - earliestDate) / (1000 * 3600 * 24))+1;

                $('#total-durasi').text(daysDifference + ' hari');
            });


            $('input[name="tool"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('input[name="mesin[]"]').daterangepicker({
                autoUpdateInput: false,
                opens: 'center',
                drops: 'auto',
                singleDatePicker: false,
                showDropdowns: true,
                maxSpan: {
                    "months": 1
                },
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD/MM/YYYY'
                }
            });

            $('input[name="mesin[]"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));
                var iteration = $(this).attr('class').split(' ').find(cls => cls.startsWith('iteration-'))
                    .split('-')[1];
                var numberOfDays = picker.endDate.diff(picker.startDate, 'days')+1;
                $('#total-mesin-' + iteration).text(numberOfDays + ' hari');
                $('#total-mesin-val-' + iteration).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));

                var allDates = [
                    ...extractDates(document.getElementById('total-cad-val').value)
                ];

                var need_design = document.getElementById('need_design').value;
                if (need_design == 1) {
                    if (document.getElementById('total-cam-val').value.trim() !== "0") {
                        allDates.push(...extractDates(document.getElementById('total-cam-val').value));
                    }
                    if (document.getElementById('total-tools-val').value.trim() !== "0") {
                        allDates.push(...extractDates(document.getElementById('total-tools-val').value));
                    }
                }

                document.querySelectorAll('[id^="total-mesin-val-"]').forEach(machine => {
                    if (machine.value.trim() !== "0") {
                        allDates.push(...extractDates(machine.value));
                    }
                });

                var parsedDates = allDates.map(dateStr => new Date(...dateStr.split('/').reverse())).sort((a, b) => a - b);
                var earliestDate = parsedDates[0];
                var latestDate = parsedDates[allDates.length - 1];
                var daysDifference = Math.floor((latestDate - earliestDate) / (1000 * 3600 * 24))+1;

                $('#total-durasi').text(daysDifference + ' hari');
            });

            $('input[name="mesin[]"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    <script>
        function validateForm() {
            const inputs = document.querySelectorAll('input[required], select[required], textarea[required]');
            let allInputsFilled = true;

            inputs.forEach(function(input) {
                if (input.value.trim() === '') {
                    allInputsFilled = false;
                }
            });

            if (!allInputsFilled) {
                alert('Harap isi semua input sebelum mengirimkan formulir.');
                return false; // Menyebabkan formulir tidak dikirim
            }
            return true; // Mengizinkan formulir dikirim
        }
    </script>
    <script>
         $(document).ready(function(){
            var semua = {{ $semua }};
            $('#total-durasi').attr('rowspan', semua + 1);
            console.log($('#total-durasi'))
        });
    </script>
@endpush
