<?php

namespace App\Http\Controllers\operator;

use App\Models\Order;
use App\Models\Gambar;
use App\Models\Schedule;
use App\Models\OperatorProses;
use App\Models\MachineOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MaterialOrder;
use App\Models\ProsesOrder;
use App\Models\Tools;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Crypt;
use PHPUnit\Framework\Constraint\Operator;

class OperatorOrderController extends Controller
{
    public function index()
    {
        $waitingorders = Order::whereIn('status', [3, 4, 5, 6, 7])->get();

        $orders = Order::where('status', 8)->where('produksi', 0)->get();

        $running = Order::where('status', 8)->where('produksi', 1)->get();

        $history = Order::whereIn('status', [8, 9])->where('produksi', 2)->get();

        $jadwal = Schedule::whereIn('order_number', $waitingorders->pluck('order_number'))->where('desc', 'TOOLS')->get();

        return view('operator.produksi.index')->with([
            'waitingorders' => $waitingorders,
            'orders' => $orders,
            'running' => $running,
            'history' => $history,
            'jadwal' => $jadwal
        ]);
    }

    public function tambahSetting(Request $request)
    {
        $request->validate([
            'id_mo' => 'required',
            'urutan' => 'required'
        ]);

        $urutan = $request->input('urutan') + 1;
        $id_mo = $request->input('id_mo');
        $op = OperatorProses::where('id_machine_order', $id_mo)->get();

        foreach ($op as $value) {
            if ($value->urutan >= $urutan) {
                OperatorProses::find($value->id)->update(['urutan' => $value->urutan + 1]);
            }
        }

        OperatorProses::create([
            'proses_name' => 'Setting',
            'urutan' => $urutan,
            'id_machine_order' => $id_mo,
            'waktu_mesin' => '-'
        ]);

        return back();
    }

    public function tambahProses(Request $request)
    {
        $request->validate([
            'id_mo' => 'required',
            'urutan' => 'required'
        ]);

        $urutan = $request->input('urutan') + 1;
        $id_mo = $request->input('id_mo');
        $op = OperatorProses::where('id_machine_order', $id_mo)->get();

        foreach ($op as $value) {
            if ($value->urutan >= $urutan) {
                OperatorProses::find($value->id)->update(['urutan' => $value->urutan + 1]);
            }
        }

        OperatorProses::create([
            'proses_name' => 'Proses Tambahan',
            'urutan' => $urutan,
            'id_machine_order' => $id_mo
        ]);

        return back();
    }

    public function start(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $desc = $request->input('desc');
        $jadwal = Schedule::where('order_number', $orderNumber)->where('desc', $desc)->first();

        $jadwal->update([
            'users_id'  => auth()->user()->id,
            'start_actual'  => date('Y-m-d H:i:s')
        ]);

        return back()->with('success', 'Mulai Produksi');
    }

    public function produksi($id)
    {
        $order = Order::find($id);
        $gambarUpload = Gambar::where('order_id', $id)->whereIn('owner', ['programmer', 'drafter'])->get();
        $gambarclient = Gambar::where('order_id', $id)->where('owner', '!=', 'programmer')->get();

        $mo = $order->machineOrders->pluck('id')->toArray();

        $op_selesai = OperatorProses::whereIn('id_machine_order', $mo)->where('waktu_mesin', null)->count();

        return view('operator.produksi.produksi', compact('order', 'gambarUpload', 'gambarclient', 'op_selesai'));
    }


    public function prosesStart(Request $request)
    {
        $op_id = $request->input('operator_proses_id');
        $op = OperatorProses::find($op_id);
        $key = $request->input('key');

        if ($key == 1) {
            $orderNumber = $request->input('order_number');
            $order = Order::where('order_number', $orderNumber)->first();
            $desc = $request->input('desc');
            $jadwal = Schedule::where('order_number', $orderNumber)->where('desc', $desc)->first();

            $jadwal->update([
                'users_id'  => auth()->user()->id,
                'start_actual'  => date('Y-m-d H:i:s')
            ]);

            $order->update(['produksi' => 1]);
        }

        $op->update([
            'start' => date('Y-m-d H:i:s'),
            'users_id'  => auth()->user()->id,
        ]);
        return back();
    }


    public function prosesStop(Request $request)
    {
        $op_id = $request->input('operator_proses_id');
        $key = $request->input('keyMax');

        if ($key == 1) {
            $orderNumber = $request->input('order_number');
            $desc = $request->input('desc');
            $jadwal = Schedule::where('order_number', $orderNumber)->where('desc', $desc)->first();

            $jadwal->update([
                'users_id'  => auth()->user()->id,
                'stop_actual'  => date('Y-m-d H:i:s')
            ]);
        }

        $data = OperatorProses::find($op_id);

        $users_id = $data->users_id;
        $dataLogin = auth()->user()->id;

        if ($users_id == $dataLogin) {
            $data->update([
                'stop' => date('Y-m-d H:i:s'),
            ]);

            if ($data->proses_name == 'Setting') {
                $data->update(['waktu_mesin' => '-']);
            }

            return back();
        } else {
            return back()->with('warning', 'Anda tidak melakukan start di proses ini');
        }
    }

    public function waktuMesin(Request $request)
    {
        $op_id = $request->input('operator_proses_id');

        $data = OperatorProses::find($op_id);

        $request->validate([
            'jam' => 'required|min_digits:2',
            'menit' => 'required|min:1|max:60|min_digits:2',
            'detik' => 'required|min:0|max:60|min_digits:2',
        ]);

        $jam = $request->input('jam');
        $menit = $request->input('menit');
        $detik = $request->input('detik');

        $waktu = $jam . $menit . $detik;

        $data->update([
            'waktu_mesin' => $waktu,
            'problem'   => $request->input('keterangan')
        ]);

        return back();
    }

    public function updateNamaProses(Request $request, $id)
    {
        $request->validate([
            'proses_name' => 'required|min:3'
        ]);

        $data = OperatorProses::find($id);

        $data->update([
            'proses_name'   => $request->input('proses_name')
        ]);

        return back();
    }

    public function hapusProses(Request $request)
    {
        $op = OperatorProses::find($request->input('op_id'));
        $op->delete();

        return back();
    }

    public function produksiSelesai($id)
    {
        $order = Order::find($id);
        $order->update(['produksi' => 2]);

        $sch = Schedule::where('order_number', $order->order_number)->latest()->first();
        $sch->update([
            'users_id'  => auth()->user()->id,
            'stop_actual'  => date('Y-m-d H:i:s')
        ]);

        return back();
    }
}
