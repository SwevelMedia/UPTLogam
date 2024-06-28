<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class prosesController extends Controller
{
    public function dataCam(string $id)
    {
        $data = Order::with('machineOrders')->find($id);
        $data['machine_orders'] = $data->machineOrders;
        foreach ($data['machine_orders'] as $machineOrder) {
            $machineOrder->mesin;
            $machineOrder->prosesOrder;
            foreach ( $machineOrder->prosesOrder as $sub ){
                $sub->subProses;
            }
        }
        return response()->json($data);
    }
}