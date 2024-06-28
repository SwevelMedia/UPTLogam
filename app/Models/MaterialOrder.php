<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialOrder extends Model
{
    protected $fillable = ['order_number', 'id_material', 'qty'];
    use HasFactory;

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material');
    }
}
