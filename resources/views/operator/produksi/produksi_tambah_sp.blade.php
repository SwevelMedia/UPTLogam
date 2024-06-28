<div class="mt-1 mx-sm-3 mx-2">

    <div class="mb-3">
        <p class="h6"><span
                class="text-secondary">{{ $mo2->mesin->name . ': ' }}</span>{{ $mo2->mesin->machine_code }}
        </p>
        <p class="h6"><span class="text-secondary">Operator: </span>
            @foreach ($mo2->operatorProses as $op_idx)
                @if (!in_array($op_idx->employee ? $op_idx->employee->name : '', $opName))
                    {{ $op_idx->employee ? $op_idx->employee->name . ', ' : '' }}

                    @php
                        $opName[] = $op_idx->employee ? $op_idx->employee->name : '';
                    @endphp
                @endif
            @endforeach
        </p>
    </div>

    <button @if ($order->produksi == 2) disabled @endif class="btn btn-sm bg-gradient-info me-2"
        data-bs-toggle="modal" data-bs-target="#tambahSetting{{ $loop->iteration }}"><i
            class="fa-solid fa-circle-plus fs-6 me-2"></i>
        Setting</button>

    <button @if ($order->produksi == 2) disabled @endif class="btn btn-sm bg-gradient-pink" data-bs-toggle="modal"
        data-bs-target="#tambahProses{{ $loop->iteration }}"><i class="fa-solid fa-circle-plus fs-6 me-2"></i>
        Proses</button>

    {{-- Modal Tambah Setting --}}
    <div class="modal fade" id="tambahSetting{{ $loop->iteration }}" tabindex="-1" aria-labelledby="tambahSettingLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-info">
                    <h5 class="modal-title" id="tambahSettingLabel">Tambah Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('operator/tambah-setting') }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="id_mo" value="{{ $mo2->id }}">
                        <label for="urutan">Urutan</label>
                        <select name="urutan" id="urutan{{ $loop->iteration }}" class="form-control">
                            @foreach ($mo2->operatorProses as $op_select)
                                @if ($op_select->proses_name != 'Setting')
                                    @if (count($mo2->operatorProses) == $op_select->urutan)
                                        <option value="{{ $op_select->urutan }}" disabled>Setelah
                                            {{ $op_select->proses_name }}
                                        </option>
                                    @else
                                        <option value="{{ $op_select->urutan }}">Setelah
                                            {{ $op_select->proses_name }}
                                        </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>

                    </div>
                    <div class="d-flex justify-content-end me-3">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-info">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Proses --}}
    <div class="modal fade" id="tambahProses{{ $loop->iteration }}" tabindex="-1" aria-labelledby="tambahSettingLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-pink">
                    <h5 class="modal-title text-white" id="tambahSettingLabel">Tambah Proses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('operator/tambah-proses') }}" method="post">
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="id_mo" value="{{ $mo2->id }}">
                        <label for="urutan">Urutan</label>
                        <select name="urutan" id="urutanProses{{ $loop->iteration }}" class="form-control">
                            @foreach ($mo2->operatorProses as $opr)
                                <option value="{{ $opr->urutan }}">Setelah
                                    {{ $opr->proses_name }}
                                    ({{ $opr->urutan }})
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="d-flex justify-content-end me-3">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-pink">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
