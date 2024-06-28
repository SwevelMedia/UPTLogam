<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $fillable = [
        'desc',
        'users_id',
        'start_plan',
        'start_actual',
        'stop_plan',
        'stop_actual',
        'information',
        'order_number'
    ];

    use HasFactory;

    public static function Alls()
    {
        return self::orderBy('id', 'desc')->get();
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function mesin()
    {
        return $this->belongsTo(Machine::class, 'machines_id');
    }

    public function deadline()
    {
        return self::latest()->first();
    }


}