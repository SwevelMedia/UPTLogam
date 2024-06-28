<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $fillable = ['name', 'machine_code', 'status'];


    public function machineOrder()
    {
        return $this->hasMany(MachineOrder::class, 'machines_id');
    }
    public static function mesin()
    {
        return self::orderBy('status')->paginate(5);
    }
    public function maintenance()
    {
        return $this->hasMany(Maintenance::class, 'machine_id');
    }
}