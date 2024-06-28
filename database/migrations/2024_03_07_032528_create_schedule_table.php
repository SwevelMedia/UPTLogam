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
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();
            $table->string('desc')->nullable();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->string('start_plan')->nullable();
            $table->string('start_actual')->nullable();
            $table->string('stop_plan')->nullable();
            $table->string('stop_actual')->nullable();
            $table->string('information')->nullable();
            $table->string('order_number')->nullable();
            $table->timestamps();

            $table->foreign('order_number')->references('order_number')->on('orders');
            $table->foreign('users_id')->references('id')->on('users');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule');
    }
};