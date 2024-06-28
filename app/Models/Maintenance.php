<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = ['machine_id', 'estimasi', 'keterangan', 'status'];

    public function mesin()
    {
        return $this->belongsTo(machine::class, 'machine_id');
    }
}
