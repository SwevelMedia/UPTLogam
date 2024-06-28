<?php

namespace App\Http\Controllers\toolman;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Schedule;
use DateTime;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jadwal = Schedule::get();

        $orders = [];

        if (auth()->user()->role == 'toolman') {
            $orderAll = Order::whereStatus(7)->where('cam_approv', 1)->get();
            foreach ($jadwal as $item) {
                foreach ($orderAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'TOOLS' && auth()->user()->id == $item->users_id) {
                        $orders[] = $order;
                    }
                }
            }
        }

        $history = Order::whereIn('status', [8, 9])->count();

        $jadwal = Schedule::where('users_id', auth()->user()->id)->where('stop_actual', '!=', null)->get();

        $waktu = 0;
        $jumlah = $jadwal->count();
        if ($jumlah > 0) {
            foreach ($jadwal as $value) {
                $start = new DateTime($value->start_actual);
                $stop = new DateTime($value->stop_actual);

                $actualTime = $start->diff($stop)->format('%H:%I:%S');
                $actualTimeInSeconds = strtotime($actualTime) - strtotime('TODAY');

                $waktu += $actualTimeInSeconds;
            }

            $avgWaktu = intval($waktu / $jumlah);

            $avg = gmdate("H:i:s", $avgWaktu);
        } else {
            $avg = "-";
        }


        return view('toolman.dashboard.index', compact('orders', 'history', 'avg'));
    }
}
