<?php

namespace App\Http\Controllers\machiner;

use App\Http\Controllers\Controller;
use App\Models\Machine;
use App\Models\Order;
use App\Models\MachineOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $ready = Machine::where('status', 1)->get();
        $digunakan = MachineOrder::whereIn('status', [2, 3, 4, 5, 6, 7, 8])->get();
        $breakdownschedule = Machine::where('status', 11)->get();
        $breakdownunschedule = Machine::where('status', 12)->get();
        $standbyrequest = Machine::where('status', 13)->get();

        $readyCount = $ready->count();
        $breakdownscheduleCount = $breakdownschedule->count();
        $breakdownunscheduleCount = $breakdownunschedule->count();
        $standbyrequestCount = $standbyrequest->count();

        $digunakanCount = $digunakan->count();

        $totalCount = Machine::count();

        return view('machiner.dashboard.index')
            ->with('ready', $ready)
            ->with('digunakan', $digunakan)
            ->with('readyCount', $readyCount)
            ->with('breakdownschedule', $breakdownschedule)
            ->with('breakdownscheduleCount', $breakdownscheduleCount)
            ->with('breakdownunschedule', $breakdownunschedule)
            ->with('breakdownunscheduleCount', $breakdownunscheduleCount)
            ->with('standbyrequest', $standbyrequest)
            ->with('standbyrequestCount', $standbyrequestCount)
            ->with('digunakanCount', $digunakanCount)
            ->with('totalCount', $totalCount);
    }
}


