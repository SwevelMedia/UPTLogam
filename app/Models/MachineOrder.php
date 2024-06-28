<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MachineOrder extends Model
{
    protected $fillable = ['order_number', 'machines_id', 'status'];
    use HasFactory;

    public function mesin()
    {
        return $this->belongsTo(Machine::class, 'machines_id');
    }

    public function toolsOrder()
    {
        return $this->hasMany(ToolsOrder::class, 'id_machine_order')->orderBy('id', 'asc');
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

    /**
     * Get all of the operatorProses for the MachineOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public static function getDigunakan(): Collection
    {
        return self::whereIn('status', [2, 3, 4, 5, 6, 7, 8])->get();
    }


    /**
     * Get all of the comments for the MachineOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operatorProses(): HasMany
    {
        return $this->hasMany(OperatorProses::class, 'id_machine_order', 'id')->orderBy('urutan', 'asc');
    }

    public function operatorProsesSelesai(): HasMany
    {
        return $this->hasMany(OperatorProses::class, 'id_machine_order', 'id')->where('waktu_mesin', null);
    }
}
