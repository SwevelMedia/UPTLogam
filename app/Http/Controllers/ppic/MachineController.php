<?php

namespace App\Http\Controllers\ppic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\Order;


class MachineController extends Controller
{
    public function index()
    {
        $machines = Machine::all();
        return response()->json($machines);
    }
}
