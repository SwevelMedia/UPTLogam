<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('operator_proses', function (Blueprint $table) {
            $table->id();
            $table->integer('urutan')->nullable();
            $table->unsignedBigInteger('id_machine_order');
            $table->string('proses_name');
            $table->tinyInteger('shift')->nullable();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('stop')->nullable();
            $table->string('waktu_mesin')->nullable();
            $table->string('problem')->nullable();
            $table->timestamps();

            $table->foreign('id_machine_order')->references('id')->on('machine_orders');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operator_proses');
    }
};