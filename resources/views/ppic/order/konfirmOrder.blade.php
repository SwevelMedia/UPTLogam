@extends('layouts.template')

@push('css')
@endpush

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-gradient-primary pb-2 border-bottom d-flex justify-content-between">
            <a href="{{ route('order.index') }}">
                <h6 class="text-info"><i class="fas fa-chevron-left"></i> Kembali</h6>
            </a>
            <p class="h4 text-white">Konfirmasi Pesanan {{ $order->order_number }} </p>
        </div>
        <div class="swal" data-swal="{{ session('success') }}"></div>
        <div class="card-body pb-2 row">
            <div class="table-responsive">
                <table class="table text-center">
                    <tr>
                        <th colspan="4">Ketersediaan Mesin :</th>
                    </tr>
                    <tr class="bg-light">
                        <th>Kode Mesin </th>
                        <th>Nama Mesin</th>
                        <th>Status</th>
                        <th>Pilih Mesin</th>
                    </tr>

                    <form id="formPilihMesin{{ $order->id }}" data-order-id="{{ $order->id }}" method="POST"
                        action="{{ url('order/pilih-mesin-accept/' . $order->id) }}">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        @php $totmesin=0;
                             $dataMesin = [];
                        @endphp
                        @foreach ($mesin as $item)
                            @php $totmesin++ @endphp
                            @foreach ($allmachine as $allmac)
                                @if ($allmac->name == $item->mesin->name)
                                    @if (!in_array($item->mesin->name, $dataMesin))
                                        @php $dataMesin[] = $item->mesin->name @endphp
                                        <input type="hidden" id="dataMesin-{{ $totmesin }}" value="{{ $item->mesin->name }}">
                                    @endif
                                    <tr>
                                        <td>{{ $allmac->machine_code }}</td>
                                        <td>{{ $allmac->name }}</td>
                                        <td class="">
                                            <div id="status">
                                                @if ($allmac->status == 1)
                                                    <i class="fa-solid fa-circle-check text-success"></i> Ready
                                                @elseif ($allmac->status == 11)
                                                    <i class="fa-solid fa-wrench text-warning"></i> Breakdown Schedule
                                                @elseif ($allmac->status == 12)
                                                    <i class="fa-solid fa-times text-primary"></i> Breakdown
                                                    Unschedule
                                                @elseif ($allmac->status == 13)
                                                    <i class="fa-solid fa-cogs text-info"></i> Stanby Request
                                                @else
                                                    @php $ready =true; @endphp
                                                    @foreach ($allmac->machineOrder as $mo)
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
                                                    <i class="fa-solid fa-circle-exclamation text-warning"></i> Belum di Schedule
                                                    @endif
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <input type="checkbox" name="mesin[]" value="{{ $allmac->id }}"
                                                data-name="{{ $allmac->name }}" dataid="{{ $item->mesin->id }}"
                                                onclick="handleCheckboxChange(this)"
                                                @if ($item->mesin->id == $allmac->id)
                                                    @if ($allmac->status == 1)
                                                        @checked('checked')
                                                    @endif
                                                @endif>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                </table>
            </div>
            <div class="table-responsive p-3 mt-3">
                <table id="example" class="table align-items-center mb-0 text-center">
                    <thead>
                        <tr>
                            <th colspan="5">Karyawan:</th>
                        </tr>
                        <tr class="bg-light">
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Pilih Karyawan</th>
                        </tr>
                    </thead>
                    <tbody>@php
                        // Mengurutkan karyawan berdasarkan peran (drafter, programmer, toolman, operator)
                        $sortedKaryawan = $karyawan->sortBy(function ($emp) {
                            switch ($emp->role) {
                                case 'drafter':
                                    return 1;
                                    break;
                                case 'programmer':
                                    return 2;
                                    break;
                                case 'toolman':
                                    return 3;
                                    break;
                                case 'operator':
                                    return 4;
                                    break;
                                default:
                                    return 5;
                                    break;
                            }
                        });
                        $drafter = 0;
                        $programmer = 0;
                        $toolman = 0;

                    @endphp

                        @foreach ($sortedKaryawan as $emp)
                            @if ($order->need_design == 1)
                                <tr>
                                    <td>{{ $emp->name }}</td>
                                    <td>{{ $emp->role }}</td>
                                    <td>
                                        <div id="status">
                                            @php $ready = true; @endphp
                                            @foreach ($emp->schedule as $sch)
                                                @if ($emp->role == 'drafter' && $sch->stop_actual == null && $sch->desc == 'CAD')
                                                    <li class="text-sm" style="list-style: none">
                                                        <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                                        {{ $sch->order_number }} |
                                                        @if ($sch->start_actual != null)
                                                            {{ date('d/m/Y', strtotime($sch->start_actual)) }}
                                                        @else
                                                            Belum mulai
                                                        @endif <i class="fa-solid fa-arrow-right"></i>
                                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Estimasi selesai {{ date('d M Y', strtotime(str_replace('/', '-', $sch->stop_plan))) }}">
                                                            {{ $sch->stop_plan }}</a>

                                                    </li>
                                                    @php $ready = false; @endphp
                                                    <!-- Jika item schedule sesuai, set $ready menjadi false -->
                                                @elseif($emp->role == 'programmer' && $sch->stop_actual == null && ($sch->desc == 'CAM' || $sch->desc == 'CAM'))
                                                    <li class="text-sm" style="list-style: none">
                                                        <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                                        {{ $sch->order_number }} |
                                                        @if ($sch->start_actual != null)
                                                            {{ date('d/m/Y', strtotime($sch->start_actual)) }}
                                                        @else
                                                            Belum mulai
                                                        @endif <i class="fa-solid fa-arrow-right"></i>
                                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Estimasi selesai {{ date('d M Y', strtotime(str_replace('/', '-', $sch->stop_plan))) }}">
                                                            {{ $sch->stop_plan }}</a>
                                                    </li>
                                                    @php $ready = false; @endphp
                                                    <!-- Jika item schedule sesuai, set $ready menjadi false -->
                                                @elseif($emp->role == 'toolman' && $sch->stop_actual == null && $sch->desc == 'TOOLS')
                                                    <li class="text-sm" style="list-style: none">
                                                        <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                                        {{ $sch->order_number }} |
                                                        @if ($sch->start_actual != null)
                                                            <a href="#" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Mulai mengerjakan {{ date('d M Y', strtotime(str_replace('/', '-', $sch->start_actual))) }}">
                                                                {{ date('d/m/Y', strtotime($sch->start_actual)) }}</a>
                                                        @else
                                                            Belum mulai
                                                        @endif
                                                        <i class="fa-solid fa-arrow-right"></i>
                                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Estimasi selesai {{ date('d M Y', strtotime(str_replace('/', '-', $sch->stop_plan))) }}">
                                                            {{ $sch->stop_plan }}</a>
                                                    </li>
                                                    @php $ready = false; @endphp
                                                    <!-- Jika item schedule sesuai, set $ready menjadi false -->
                                                @elseif($emp->role == 'operator' && $sch->stop_actual == null && !in_array($sch->desc, ['TOOLS', 'CAD', 'CAM', 'DRAFTING']))
                                                    <li class="text-sm" style="list-style: none">
                                                        <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                                        {{ $sch->order_number }} |
                                                        @if ($sch->start_actual != null)
                                                            {{ date('d/m/Y', strtotime($sch->start_actual)) }}
                                                        @else
                                                            Belum mulai
                                                        @endif
                                                        <i class="fa-solid fa-arrow-right"></i>
                                                        <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Estimasi selesai {{ date('d M Y', strtotime(str_replace('/', '-', $sch->stop_plan))) }}">
                                                            {{ $sch->stop_plan }}</a>
                                                    </li>
                                                    @php $ready = false; @endphp
                                                    <!-- Jika item schedule sesuai, set $ready menjadi false -->
                                                @endif
                                            @endforeach

                                            @if ($ready)
                                                <!-- Jika semua item schedule tidak sesuai, maka $ready masih true -->
                                                <i class="fa-solid fa-circle-check text-success"></i> Ready
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($emp->role == 'operator')
                                        @else
                                            <input type="checkbox" name="karyawan[]"
                                                value="{{ $emp->id }}-{{ $emp->role }}"
                                                data-name="{{ $emp->name }}" data-role="{{ $emp->role }}"
                                                onclick="handleCheckboxChangeRL(this)"
                                                @if ($emp->role == 'drafter' && $drafter == 0)
                                                    @if ($ready)
                                                        checked="checked"
                                                        @php
                                                            $drafter++;
                                                        @endphp
                                                    @endif
                                                @endif
                                                @if ($emp->role == 'programmer' && $programmer == 0)
                                                    @if ($ready)
                                                        checked="checked"
                                                        @php
                                                            $programmer++;
                                                        @endphp
                                                    @endif
                                                @endif
                                                @if ($emp->role == 'toolman' && $toolman == 0)
                                                    @if ($ready)
                                                        checked="checked"
                                                        @php
                                                            $toolman++;
                                                        @endphp
                                                    @endif
                                                @endif>
                                        @endif
                                    </td>
                                </tr>
                            @else
                                @if ($emp->role != 'toolman' && $emp->role != 'programmer')
                                    <tr>
                                        <td>{{ $emp->name }}</td>
                                        <td>{{ $emp->role }}</td>
                                        <td>
                                            <div id="status">
                                                @php $ready = true; @endphp
                                                @foreach ($emp->schedule as $sch)
                                                    @if ($emp->role == 'toolman' && $sch->stop_actual == null && $sch->desc == 'TOOLS')
                                                        <li class="text-sm" style="list-style: none">
                                                            <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                                            {{ $sch->order_number }} |
                                                            @if ($sch->start_actual != null)
                                                                <a href="#" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top"
                                                                    title="Mulai mengerjakan {{ date('d M Y', strtotime(str_replace('/', '-', $sch->start_actual))) }}">
                                                                    {{ date('d/m/Y', strtotime($sch->start_actual)) }}</a>
                                                            @else
                                                                Belum mulai
                                                            @endif
                                                            <i class="fa-solid fa-arrow-right"></i>
                                                            <a href="#" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Estimasi selesai {{ date('d M Y', strtotime(str_replace('/', '-', $sch->stop_plan))) }}">
                                                                {{ $sch->stop_plan }}</a>
                                                        </li>
                                                        @php $ready = false; @endphp
                                                        <!-- Jika item schedule sesuai, set $ready menjadi false -->
                                                    @elseif($emp->role == 'operator' && $sch->stop_actual == null && !in_array($sch->desc, ['TOOLS', 'CAD', 'CAM', 'DRAFTING']))
                                                        <li class="text-sm" style="list-style: none">
                                                            <i class="fa-solid fa-circle-exclamation text-warning"></i>
                                                            {{ $sch->order_number }} |
                                                            @if ($sch->start_actual != null)
                                                                {{ date('d/m/Y', strtotime($sch->start_actual)) }}
                                                            @else
                                                                Belum mulai
                                                            @endif
                                                            <i class="fa-solid fa-arrow-right"></i>
                                                            <a href="#" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Estimasi selesai {{ date('d M Y', strtotime(str_replace('/', '-', $sch->stop_plan))) }}">
                                                                {{ $sch->stop_plan }}</a>
                                                        </li>
                                                        @php $ready = false; @endphp
                                                        <!-- Jika item schedule sesuai, set $ready menjadi false -->
                                                    @endif
                                                @endforeach

                                                @if ($ready)
                                                    <!-- Jika semua item schedule tidak sesuai, maka $ready masih true -->
                                                    <i class="fa-solid fa-circle-check text-success"></i> Ready
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if ($emp->role == 'operator')
                                            @else
                                                <input type="checkbox" name="karyawan[]"
                                                    value="{{ $emp->id }}-{{ $emp->role }}"
                                                    data-name="{{ $emp->name }}" data-role="{{ $emp->role }}"
                                                    onclick="handleCheckboxChangeRL(this)"
                                                    @if ($emp->role == 'drafter' && $drafter == 0) checked="checked"@php
                                                $drafter++;
                                            @endphp @endif
                                                    @if ($emp->role == 'programmer' && $programmer == 0) checked="checked"@php
                                                $programmer++;
                                            @endphp @endif
                                                    @if ($emp->role == 'toolman' && $toolman == 0) checked="checked"@php
                                                $toolman++;
                                            @endphp @endif>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach

                    </tbody>


                </table>
            </div>
        </div>
        <div class="d-flex justify-content-end p-3">
            <button type="button" class="text-center btn btn-danger btn-sm decline-btn me-3" data-bs-toggle="modal"
                data-bs-target="#declineModal" onclick="setOrderId({{ $order->id }})">
                Tolak
            </button>
            <button type="submit" onclick="return validateCheckboxes()"
                class="text-center btn btn-success btn-sm accept-btn me-3">Terima</button>
        </div>

        <!-- Modal Decline -->
        <div class="modal fade" id="declineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Tolak Pesanan</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        Yakin tolak pesanan {{ $order->order_name . ' (' . $order->order_number . ')' }}
                        <div class="form-group ">
                            <label for="message-text" class="col-form-label">Alasan Ditolak:</label>
                            <textarea class="form-control" class="form-control" id="message-text" rows="4" name="alasan_penolakan"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <!-- Tombol OK untuk menyetujui penolakan -->
                        <button type="button" class="btn btn-danger" onclick="confirmDecline()">OK</button>
                        <!-- Tombol tutup modal -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="needDesign" value="{{ $order->need_design }}">
    @endsection

    @push('js')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function redirectTo(url) {
                window.location.href = url;
            }
        </script>
        <script>
            function confirmDecline() {
                var orderId = "{{ $order->id }}";

                var message = document.querySelector('textarea[name="alasan_penolakan"]').value;

                window.location.href = "/order/decline/" + orderId + "/" + message;

                confirmDeclineWithWhatsApp(orderId);
            }

            function confirmDeclineWithWhatsApp(orderId) {
                var nomorPelanggan = "{{ $order->client->phone }}";
                var nomorPesanan = "{{ $order->order_number }}";
                var alasanPenolakan = document.getElementById("message-text").value;
                var pesan = "Pesanan " + nomorPesanan + " ditolak. Alasan: " + alasanPenolakan;

                var formattedMessage = encodeURIComponent(pesan);
                var formattedPhoneNumber = nomorPelanggan.replace(/\D/g, '');

                var whatsappMessage = "https://api.whatsapp.com/send?phone=62" + formattedPhoneNumber + "&text=" +
                    formattedMessage;

                window.open(whatsappMessage, '_blank');
            }
        </script>

        <script>
            function getAllHiddenInputValues() {
                let hiddenInputs = document.querySelectorAll('input[type="hidden"][id^="dataMesin-"]');
                let values = [];

                hiddenInputs.forEach(input => {
                    values.push(input.value);
                });

                return values;
            }
            var namaMesin = getAllHiddenInputValues();
            function validateCheckboxes() {
                var roles = {}; // Objek untuk menyimpan jumlah karyawan yang dipilih untuk setiap role
                var checkboxes = document.querySelectorAll('input[name="karyawan[]"]:checked');
                var checkboxesmachine = document.querySelectorAll('input[name="mesin[]"]:checked');
                var design = document.getElementById('needDesign').value;

                var selectedNames = [];

                checkboxesmachine.forEach(function(checkbox) {
                    selectedNames.push(checkbox.getAttribute('data-name'));
                });


                var jumlah = 0;
                var jumlahmesin = 0;
                for (var i = 0; i < checkboxes.length; i++) {
                    jumlah++;
                }
                for (var i = 0; i < checkboxesmachine.length; i++) {
                    jumlahmesin++;
                }

                if (jumlah > 2 && jumlahmesin >= namaMesin.length) {
                    const containsAll = namaMesin.every(name => selectedNames.includes(name));
                    if(containsAll){
                        return true;
                    }
                    const missingNames = namaMesin.filter(name => !selectedNames.includes(name));

                    console.log(missingNames);
                    alert('Mesin ' + missingNames + ' Belum terpilih !!');
                    return false;
                }

                if (jumlahmesin < namaMesin.length) {
                    const missingNames = namaMesin.filter(name => !selectedNames.includes(name));
                    alert('Mesin ' + missingNames + ' Belum terpilih !!');
                    return false;
                }

                if (design == 0) {
                    if (jumlah < 1) {
                        alert('Pilih Toolman!!');
                        return false;
                    }
                    return true;
                }

                alert('Pilih 1 karyawan untuk setiap role, ' + (3 - jumlah) + ' Role Belum terpilih !!');
                return false;
            }

            function handleCheckboxChangeRL(checkbox) {
                var roleName = checkbox.dataset.role;
                var isChecked = checkbox.checked;

                // Cari semua checkbox dengan role yang sama kecuali yang sedang diubah
                var checkboxes = document.querySelectorAll('input[type="checkbox"][data-role="' + roleName + '"]:not([value="' +
                    checkbox.value + '"])');

                // Hapus centang pada checkbox lain dengan role yang sama jika checkbox saat ini dicentang
                if (isChecked) {
                    checkboxes.forEach(function(otherCheckbox) {
                        otherCheckbox.checked = false;
                    });
                }
            }
        </script>
        <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        </script>
    @endpush
