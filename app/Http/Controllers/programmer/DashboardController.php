<?php

namespace App\Http\Controllers\programmer;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $jadwal = Schedule::get();

        $orders = [];
        if (auth()->user()->role == 'drafter') {
            $orderAll = Order::whereStatus(3)->get();
            foreach ($jadwal as $item) {
                foreach ($orderAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'CAD' && auth()->user()->id == $item->users_id) {
                        $orders[] = $order;
                    }
                }
            }
            $approval = Order::where('status', 5)->where('cad_approv', 0)->orderBy('id', 'desc')->get();
            $revisi = Order::where('status', 5)->where('cad_approv', 2)->orderBy('id', 'desc')->get();
        }


        if (auth()->user()->role == 'programmer') {
            $orderAll = Order::whereStatus(5)->get();
            foreach ($jadwal as $item) {
                foreach ($orderAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'CAM' && auth()->user()->id == $item->users_id && $order->cad_approv == 1) {
                        $orders[] = $order;
                    }
                }
            }

            $approval = Order::where('status', 7)->where('cam_approv', 0)->orderBy('id', 'desc')->get();
            $revisi = Order::where('status', 7)->where('cam_approv', 2)->orderBy('id', 'desc')->get();
        }

        $revisi = [];
        if (auth()->user()->role == 'drafter') {
            $orderAll = Order::whereStatus(5)->where('cad_approv', 2)->get();
            foreach ($jadwal as $item) {
                foreach ($orderAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'CAD' && auth()->user()->id == $item->users_id){
                        $revisi[] = $order;
                    }
                }
            }
        }

        if (auth()->user()->role == 'programmer') {
            $orderAll = Order::whereStatus(7)->where('cam_approv', 2)->get();
            foreach ($jadwal as $item) {
                foreach ($orderAll as $order) {
                    if ($item->order_number == $order->order_number && $item->desc == 'CAM' && auth()->user()->id == $item->users_id){
                        $revisi[] = $order;
                    }
                }
            }
        }

        $startOfMonth = Carbon::now()->startOfMonth();
        $now = Carbon::now();

        $sch = Schedule::where('users_id', auth()->user()->id)->get();
        $proyek = [];
        foreach ($sch as $sc) {
            if (auth()->user()->role == "drafter") {
                $ord = Order::where('status', '>', 2)->where('order_number', $sc['order_number'])->get();
            } else {
                $ord = Order::where('status', '>', 4)->where('cad_approv', 1)->where('order_number', $sc['order_number'])->get();
            }
            if ($ord->isNotEmpty()) {
                $proyek[] = $ord;
            }
        }


        $schB = Schedule::where('users_id', auth()->user()->id)->whereBetween('created_at', [$startOfMonth, $now])->get();
        $proyekBlnIni = [];
        foreach ($schB as $sc) {
            if (auth()->user()->role == "drafter") {
                $ord = Order::where('status', '>', 2)->where('order_number', $sc['order_number'])->get();
            } else {
                $ord = Order::where('status', '>', 4)->where('cad_approv', 1)->where('order_number', $sc['order_number'])->get();
            }
            if ($ord->isNotEmpty()) {
                $proyekBlnIni[] = $ord;
            }
        }

        $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();

        $schK = Schedule::where('users_id', auth()->user()->id)->whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])->get();
        $proyekBlnKmrn = [];
        foreach ($schK as $sc) {
            if (auth()->user()->role == "drafter") {
                $ord = Order::where('status', '>', 2)->where('order_number', $sc['order_number'])->get();
            } else {
                $ord = Order::where('status', '>', 4)->where('cad_approv', 1)->where('order_number', $sc['order_number'])->get();
            }
            if ($ord->isNotEmpty()) {
                $proyekBlnKmrn[] = $ord;
            }
        }
        $totalBlnKmrn = count($proyekBlnKmrn);
        $totalBlnIni = count($proyekBlnIni);
        $selisih = $totalBlnIni - $totalBlnKmrn;
        if ($totalBlnKmrn != 0) {
            $persentasePerubahan = ($selisih / $totalBlnKmrn) * 100;
        } else {
            $persentasePerubahan = $selisih * 100;
        }



        $proyekSelesai = [];
        foreach ($sch as $sc) {
            if (auth()->user()->role == "drafter") {
                $ord = Order::where('status', '>', 2)->where('order_number', $sc['order_number'])->where('cad_approv', 1)->get();
            } else {
                $ord = Order::where('status', '>', 4)->where('order_number', $sc['order_number'])->where('cam_approv', 1)->get();
            }
            if ($ord->isNotEmpty()) {
                $proyekSelesai[] = $ord;
            }
        }

        $proyekSelesaiBlnIni = [];
        foreach ($schB as $sc) {
            if (auth()->user()->role == "drafter") {
                $ord = Order::where('status', '>', 2)->where('order_number', $sc['order_number'])->where('cad_approv', 1)->get();
            } else {
                $ord = Order::where('status', '>', 4)->where('order_number', $sc['order_number'])->where('cam_approv', 1)->get();
            }
            if ($ord->isNotEmpty()) {
                $proyekSelesaiBlnIni[] = $ord;
            }
        }

        $schK = Schedule::where('users_id', auth()->user()->id)->whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])->get();
        $selesaiBlnKmrn = [];
        foreach ($schK as $sc) {
            if (auth()->user()->role == "drafter") {
                $ord = Order::where('status', '>', 2)->where('order_number', $sc['order_number'])->where('cad_approv', 1)->get();
            } else {
                $ord = Order::where('status', '>', 4)->where('order_number', $sc['order_number'])->where('cam_approv', 1)->get();
            }
            if ($ord->isNotEmpty()) {
                $selesaiBlnKmrn[] = $ord;
            }
        }

        $totalSelesaiKmrn = count($selesaiBlnKmrn);
        $totalSelesaiIni = count($proyekSelesaiBlnIni);
        $selisihSelesai = $totalSelesaiIni - $totalSelesaiKmrn;
        if ($totalSelesaiKmrn != 0) {
            $persentaseSelesai = ($selisihSelesai / $totalSelesaiKmrn) * 100;
        } else {
            $persentaseSelesai = $selisihSelesai * 100;
        }


        $order = new Order();

        if(request()->expectsJson()) {
            return response()->json([
                'order' => $order,
                'orders' => $orders,
                'count' => count($orders),
                'proyek' => $proyek,
                'proyekBlnIni' => $proyekBlnIni,
                'persentasePerubahan' => $persentasePerubahan,
                'proyekSelesai' => $proyekSelesai,
                'proyekSelesaiBlnIni' => $proyekSelesaiBlnIni,
                'persentaseSelesai' => $persentaseSelesai,
                'approval' => $approval,
                'revisi' => $revisi
            ]);
        }

        return view('programmer.dashboard.index')->with([
            'order' => $order,
            'orders' => $orders,
            'proyek' => $proyek,
            'proyekBlnIni' => $proyekBlnIni,
            'persentasePerubahan' => $persentasePerubahan,
            'proyekSelesai' => $proyekSelesai,
            'proyekSelesaiBlnIni' => $proyekSelesaiBlnIni,
            'persentaseSelesai' => $persentaseSelesai,
            'approval' => $approval,
            'revisi' => $revisi
        ]);
    }
}
