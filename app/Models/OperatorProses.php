<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperatorProses extends Model
{
    protected $table = 'operator_proses';

    protected $fillable = [
        'proses_order_id',
        'urutan',
        'proses_name',
        'id_machine_order',
        'start',
        'date',
        'shift',
        'stop',
        'users_id',
        'waktu_mesin',
        'problem'
    ];

    public $timestamps = false;

    /**
     * Get the prosesOrder that owns te OperatorProses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function employee()
    {
        return $this->belongsTo(User::class, 'users_id')->select('id', 'name');;
    }

    public function getFormattedWaktuMesinAttribute()
    {
        return $this->formatWaktu($this->waktu_mesin);
    }

    protected function formatWaktu($angka)
    {
        // Mengonversi integer menjadi string
        $angkaString = strval($angka);

        // Mendapatkan panjang string
        $length = strlen($angkaString);

        // Memastikan panjang string minimal 4 untuk menghindari kesalahan
        if ($length < 4) {
            return "";
        }

        // Memotong string menjadi bagian-bagian yang diinginkan
        $part1 = substr($angkaString, 0, $length - 4); // Semua kecuali 4 karakter terakhir
        $part2 = substr($angkaString, -4, 2); // 2 karakter dari posisi ke-3 dan ke-4 dari belakang
        $part3 = substr($angkaString, -2); // 2 karakter terakhir

        // Menggabungkan bagian-bagian tersebut dengan tanda ":"
        $formattedString = $part1 . ':' . $part2 . ':' . $part3;

        return $formattedString;
    }

    public function getFormattedWaktuOperatorAttribute()
    {
        if ($this->start != null && $this->stop != null) {
            $start = new DateTime($this->start);
            $stop = new DateTime($this->stop);
            $diff = $start->diff($stop);

            // Format selisih waktu ke jam, menit, detik
            $actual_time = $diff->format('%H:%I:%S');
            return $actual_time;
        } else {
            return ' ';
        }
    }


    public function machineOrder(): BelongsTo
    {
        return $this->belongsTo(MachineOrder::class, 'id_machine_order', 'id');
    }
}
