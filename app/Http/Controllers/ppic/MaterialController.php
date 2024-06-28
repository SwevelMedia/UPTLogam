<?php

namespace App\Http\Controllers\ppic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Order;


class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        $orders = Order::all(); 
        
        return view('ppic.order.index', compact('materials', 'orders'));
    }
}
