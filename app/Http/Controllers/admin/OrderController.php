<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Material;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $data = Order::orderBy('id', 'desc')->get();
        return view('admin.order.index')->with('data', $data);
    }

    public function orderReport()
    {
        $history = Order::whereIn('status', [9])->orderBy('id', 'desc')->get();
        $orders = Order::whereIn('status', [0, 1, 2])->orderBy('id', 'desc')->get();
        $materials = Material::all();

        return view('admin.report.orderReport', [
            'history' => $history,
            'orders' => $orders,
            'materials' => $materials
        ]);
    }
}
