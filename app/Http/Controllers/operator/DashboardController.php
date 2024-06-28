<?php

namespace App\Http\Controllers\operator;

use App\Http\Controllers\Controller;
use App\Models\OperatorProses;
use App\Models\Order;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DateTime;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::where('status', 8)->where('produksi', 0)->get(['id', 'order_number', 'order_name']);

        $running = Order::where('status', 8)->where('produksi', 1)->with('schedule')->get();

        $history = Schedule::where('users_id', auth()->user()->id)->where('stop_actual', '!=', null)->count();

        $operatorProses = OperatorProses::where('users_id', auth()->user()->id)->where('stop', '!=', null)->get();


        $latestOp = OperatorProses::latest()->first();



        return view('operator.dashboard.index', compact('orders', 'running', 'history'));
    }
}