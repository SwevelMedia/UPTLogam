<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    protected $fillable = [
        'order_id', 'path', 'owner'
    ];
    protected $table = 'gambars';

    // Relationship with order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_id');
    }
}
