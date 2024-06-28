<?php

namespace App\Http\Controllers\ppic;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $count = Order::whereIn('status', [0, 1, 2])->count();
        $all = Order::count();
        $cad = Order::where('status', 5)->where('cad_approv', 0)->get();
        $cam = Order::where('status', 7)->where('cam_approv', 0)->get();
        $order = new Order();
        $client = new Client();
        $orderSelesai = Order::where('status', 8)->where('produksi', 2)->get();
        $scheduleCad = $cad;
        $scheduleCam = $cam;

        if (request()->expectsJson()) {
            return response()->json([
                'countOrder' => $count,
                'desainCad' => $cad,
                'desainCam' => $cam,
                'order' => $order,
                'orders' => $order->newPpic(),
                'client' => $client,
                'orderSelesai' => $orderSelesai,
                'semuaOrder' => $all
            ]);
        }

        return view('ppic.dashboard.index')->with([
            'countOrder' => $count,
            'desainCad' => $cad,
            'desainCam' => $cam,
            'order' => $order,
            'client' => $client,
            'orderSelesai' => $orderSelesai
        ]);
    }
}
