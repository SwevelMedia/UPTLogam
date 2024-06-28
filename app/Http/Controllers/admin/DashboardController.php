<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $client = new Client();
        $order = new Order();
        return view('admin.dashboard.index', compact(
            'client',
            'order'
        ));
    }

}