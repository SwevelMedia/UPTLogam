<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class clientController extends Controller
{
    public function edit($id)
    {
        $client = Client::find($id);
        $order = Order::where('client_id', $id)->first();

        return view('edit_client', compact('client', 'order'));
    }
}
