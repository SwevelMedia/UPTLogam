 {{-- modal  Waktu Mesin --}}
 <div class="modal fade" id="modalWaktu{{ $op->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="modalWaktu{{ $op->id }}Label" aria-hidden="false">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header bg-gradient-primary">
                 <h1 class="modal-title fs-5 text-white" id="modalWaktu{{ $op->id }}Label">
                     Waktu Mesin
                     {{ $op->proses_name }}</h1>
             </div>
             <form action="{{ url('waktu-mesin') }}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="operator_proses_id" value="{{ $op->id }}">
                    <input type="hidden" name="order_number" value="{{ $order->order_number }}">

                    <div class="my-3 row justify-content-center">
                        <div class="col-4">
                            <label for="jam">Jam</label>
                            <input type="number" name="jam" id="jam" class="form-control" required autocomplete="off"
                             min="0" value="00"  oninput="validasiInput(this)">
                        </div>
                        <div class="col-4">
                            <label for="menit">Menit</label>
                            <input type="number" name="menit" id="menit" class="form-control" required autocomplete="off"
                            placeholder="00" min="0" max="59"  oninput="validasiInput(this)">
                        </div>
                        <div class="col-4">
                            <label for="detik">Detik</label>
                            <input type="number" name="detik" id="detik" class="form-control" required autocomplete="off"
                            placeholder="00" min="0" max="59"  oninput="validasiInput(this)">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-end px-3">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
         </div>
     </div>
 </div>

 {{-- Modal Detail --}}
 <div class="modal fade" id="detail{{ $op->id }}" tabindex="-1" aria-labelledby="detail{{ $op->id }}Label"
     aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header bg-gradient-primary">
                 <h5 class="modal-title  text-white" id="detail{{ $op->id }}Label">
                     {{ $op->proses_name }}</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form action="{{ url('produksi/update-nama-proses/' . $op->id) }}" method="post">
                 @csrf
                 <div class="modal-body">
                     <div class="mb-2">
                         <label>Nama Proses</label>
                         <input type="text" class="form-control" name="proses_name" value="{{ $op->proses_name }}"
                             @if ($op->proses_name == 'Setting') disabled @endif>
                     </div>

                     <div class="mb-2">
                         <label>Nama Operator</label>
                         <input type="text" class="form-control"
                             value="{{ $op->employee ? $op->employee->name : '' }}" disabled>
                     </div>

                     <div class="mb-2 row">
                         <div class="col-6">
                             <label>Tanggal</label>
                             <input type="text" disabled class="form-control"
                                 value="{{ $op->start ? date('d-m-Y', strtotime($op->start)) : '' }}">
                         </div>
                         <div class="col-6">
                             <label>Shift</label>
                             <input type="text" class="form-control" disabled value="{{ $op->shift }}">
                         </div>
                     </div>

                     <div class="mb-2 row">
                         <div class="col-6">
                             <label>Waktu Operator</label>
                             <input type="text" disabled class="form-control"
                                 value="{{ $op->formatted_waktu_operator }}">
                         </div>
                         <div class="col-6">
                             <label>Waktu Mesin</label>
                             <input type="text" class="form-control" disabled
                                 value="{{ $op->formatted_waktu_mesin }}">
                         </div>
                     </div>

                     <div class="mb-2">
                         <label for="keterangan">Keterangan</label>
                         <textarea class="form-control" disabled name="keterangan" id="keterangan" rows="3">{{ $op->problem }}</textarea>
                     </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                     <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>





