<?php

namespace App\Http\Controllers\Toolman;

use App\Http\Controllers\Controller;
use App\Models\MachineOrder;
use App\Models\Order;
use App\Models\Schedule;
use App\Models\Tools;
use App\Models\ToolsOrder;
use Illuminate\Http\Request;

class ToolsOrderController extends Controller
{
    public function index()
    {
        $jadwal = Schedule::get();

        $orders = [];
        $history = [];

        if (auth()->user()->role == 'toolman') {
            $orderAll = Order::whereStatus(7)->where('cam_approv', 1)->get();
            foreach ($jadwal as $item) {
                foreach ($orderAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'TOOLS' && auth()->user()->id == $item->users_id) {
                        $orders[] = $order;
                    }
                }
            }
            $historyAll = Order::whereIn('status', [8, 9])->orderBy('id', 'desc')->get();
            foreach ($jadwal as $item) {
                foreach ($historyAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'TOOLS' && auth()->user()->id == $item->users_id) {
                        $history[] = $order;
                    }
                }
            }
        }
        return view('toolman.tools.index')->with([
            'orders' => $orders,
            'history' => $history
        ]);
    }

    public function detail($id)
    {
        $order = Order::where('id', $id)->first();
        $jadwal = Schedule::where('order_number', $order->order_number)->where('desc', ['TOOLS'])->first();
        $tools = Tools::all();
        $toolsOrder = ToolsOrder::where('order_number', $order->order_number)->get();
        return view('toolman.tools.detail', compact('order', 'jadwal', 'tools', 'toolsOrder'));
    }

    public function start(Request $request)
    {
        $orderNumber = $request->input('order_number');
        $jadwal = Schedule::where('order_number', $orderNumber)->where('desc', 'TOOLS')->first();

        $jadwal->update([
            'users_id'  => auth()->user()->id,
            'start_actual'  => date('Y-m-d H:i:s')
        ]);

        return back()->with('success', 'Mulai Penyiapan Alat');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'alat' => 'required|array|min:1|distinct',
        ]);

        $inputTool = $request->input('alat');
        $orderNumber = $request->input('order_number');
        $jadwal = Schedule::where('order_number', $orderNumber)->where('desc', 'TOOLS')->first();

        foreach ($inputTool as $key => $value) {
            $input = explode('-', $value);
            $idToolOrder = $input[0];
            $idTool = $input[1];

            Tools::find($idTool)->update(['status' => 2]);

            $toolOrder = ToolsOrder::find($idToolOrder);
            if ($toolOrder) {
                $toolOrder->update([
                    'tools_id' => $idTool,
                ]);
            }

            $input = array();
        }

        $jadwal->update([
            'stop_actual' => date('Y-m-d H:i:s'),
        ]);

        $order = Order::where('order_number', $orderNumber)->first();
        $order->update([
            'status' => 8,
        ]);

        return redirect('toolman/tools')->with('success', 'Data Berhasil Disimpan');
    }
}
