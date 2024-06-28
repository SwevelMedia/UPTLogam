<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Client extends Model
{
    protected $fillable = ['name', 'phone', 'address'];

    // Relationship with orders
    public function amount()
    {
        return self::count();
    }
    public function order()
    {
        return $this->hasMany(Order::class);
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
    public static function monthly()
    {
        // Ambil order terakhir
        $latestClient = self::latest()->first();

        // Ambil tanggal order terakhir
        $latestOrderDate = $latestClient ? $latestClient->created_at : Carbon::now();

        // Buat array untuk menyimpan hasil
        $monthlyData = [];

        // Loop untuk mengisi data bulanan
        for ($i = 11; $i >= 0; $i--) {
            // Hitung bulan sebelumnya
            $month = Carbon::now()->subMonths($i);

            // Ambil data order untuk bulan tertentu
            $clients = self::whereYear('created_at', $month->year)
                          ->whereMonth('created_at', $month->month)
                          ->count();

            // Tambahkan data ke array
            $monthlyData[$month->format('F Y')] = $clients;
        }

        return collect($monthlyData);
    }
};