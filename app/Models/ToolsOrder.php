<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ToolsOrder extends Model
{
    use HasFactory;
    protected $fillable = ['tools_id', 'order_number', 'status'];

    public function tools()
    {
        return $this->belongsTo(Tools::class, 'tools_id');
    }

    /**
     * Get the user that owns the MachineOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_number', 'order_number');
    }
}
