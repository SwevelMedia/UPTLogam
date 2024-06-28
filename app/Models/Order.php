<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Tools;
use App\Models\Schedule;

class Order extends Model
{
    protected $fillable = [
        'order_name',
        'material',
        'client_id',
        'status',
        'order_number',
        'id_ppic',
        'need_design',
        'description',
        'cad_approv',
        'cam_approv',
        'produksi',
        'finish_approv'
    ];

    // Define status constants
    const STATUS_PENDING = 0;
    const STATUS_NEED_CONFIRM = 1;
    const STATUS_SCHEDULING = 2;
    const STATUS_DESIGN = 3;
    const STATUS_TOOLKIT = 4;
    const STATUS_PRODUCTION = 5;
    const STATUS_DONE = 6;
    const STATUS_DECLINE = 10;

    public static function orders()
    {
        return self::orderBy('id', 'desc')->paginate(5);
    }
    public static function orders1()
    {
        return self::orderBy('status', 'desc')->paginate(3);
    }
    public function amount()
    {
        return self::count();
    }
    public function new()
    {
        return self::whereIn('status', ['0', '1', '2'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function newNotif()
    {
        return self::whereIn('status', ['0', '1', '2'])
            ->where('created_at', '>=', now()->subDays(3)) // Menambahkan batasan untuk data yang dibuat dalam 3 hari terakhir
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function finishNotif()
    {
        return self::where('status', 8)->where('produksi', 2)->get();
    }
    public function accept()
    {
        return self::where('status', '3')->get();
    }
    public function acceptNotif()
    {
        return self::where('status', '3')
            ->where('updated_at', '>=', now()->subDays(3))
            ->get();
    }
    public function drafter()
    {
        return self::where('status', '4')->get();
    }
    public function programmer()
    {
        return self::whereIn('status', ['5', '6'])->get();
    }
    public function programmerNotif()
    {
        return self::whereIn('status', ['5', '6'])
            ->where('updated_at', '>=', now()->subDays(3))
            ->where('cad_approv', '1')
            ->get();
    }
    public function toolman()
    {
        return self::where('status', '7')->get();
    }
    public function toolmanNotif()
    {
        return self::where('status', '7')
            ->where('updated_at', '>=', now()->subDays(3))
            ->get();
    }
    public function operator()
    {
        return self::where('status', '8')->get();
    }
    public function operatorNotif()
    {
        return self::where('status', '8')
            ->where('updated_at', '>=', now()->subDays(3))
            ->where('produksi', 0)
            ->get();
    }
    public function finish()
    {
        return self::where('status', '9')->get();
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function images()
    {
        return $this->hasMany(Gambar::class, 'order_id');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'order_number', 'order_number');
    }

    public function deadlineOp()
    {
        return $this->schedule()->latest()->first();
    }

    public function scheduleCAD()
    {
        return $this->hasOne(Schedule::class, 'order_number', 'order_number')->where('desc', 'CAD');
    }

    public function scheduleCAM()
    {
        return $this->hasOne(Schedule::class, 'order_number', 'order_number')->where('desc', 'CAM');
    }

    public function scheduleTOOLS()
    {
        return $this->hasOne(Schedule::class, 'order_number', 'order_number')->where('desc', 'TOOLS');
    }

    public function materialOrders()
    {
        return $this->hasMany(MaterialOrder::class, 'order_number', 'order_number');
    }
    public function machineOrders()
    {
        return $this->hasMany(MachineOrder::class, 'order_number', 'order_number')->orderBy('id', 'asc');
    }

    public static function thisMonth()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return static::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
    }

    public static function lastMonth()
    {
        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        return static::whereMonth('created_at', $previousMonth)
            ->whereYear('created_at', $previousYear)
            ->count();
    }

    public static function percentage()
    {
        $countTodays = static::thisMonth();
        $countSubMonth = static::lastMonth();

        $diff = $countTodays - $countSubMonth;
        $percentageChange = ($countSubMonth == 0) ? ($diff * 100) : (($diff / $countSubMonth) * 100);

        return number_format($percentageChange, 0);
    }

    public static function monthlyDesign()
    {

        $sch = Schedule::where('users_id', auth()->user()->id)->latest()->first();
        $schAll = Schedule::where('users_id', auth()->user()->id);

        if ($sch) {
            $latestOrder = self::where('order_number', $sch->order_number)->latest()->first();
        } else {
            $latestOrder = null;
        }

        $latestOrderDate = $latestOrder ? $latestOrder->created_at : Carbon::now();

        $monthlyData = [];

        if (auth()->user()->role == "drafter") {
            $st = 2;
        } else {
            $st = 6;
        }
        for ($i = 11; $i >= 0; $i--) {
            // Hitung bulan sebelumnya
            $month = Carbon::now()->subMonths($i);

            // Ambil data order untuk bulan tertentu dengan order_number yang sama dengan dari Schedule
            $orders = self::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', '>', $st)
                ->where('status', '<>', 10)
                ->get();

            $monthlyData[$month->format('F Y')] = $orders;
        }

        return collect($monthlyData);
    }
    public static function monthly()
    {
        // Ambil order terakhir
        $latestOrder = self::latest()->first();

        // Ambil tanggal order terakhir
        $latestOrderDate = $latestOrder ? $latestOrder->created_at : Carbon::now();

        // Buat array untuk menyimpan hasil
        $monthlyData = [];

        // Loop untuk mengisi data bulanan
        for ($i = 11; $i >= 0; $i--) {
            // Hitung bulan sebelumnya
            $month = Carbon::now()->subMonths($i);

            // Ambil data order untuk bulan tertentu
            $orders = self::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->get();

            $monthlyData[$month->format('F Y')] = $orders;
        }

        return collect($monthlyData);
    }

    public function newPpic()
    {
        return self::whereIn('status', [0, 1, 2])->limit(3)->get();
    }

    public function toolsOrder()
    {
        return $this->hasMany(ToolsOrder::class, 'order_number', 'order_number');
    }
}