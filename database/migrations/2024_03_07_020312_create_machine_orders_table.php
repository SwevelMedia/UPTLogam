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
        Schema::create('machine_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->unsignedBigInteger('machines_id');
            $table->timestamps();
            $table->index('machines_id');
            $table->tinyInteger('status')->default(0);

            $table->foreign('machines_id')->references('id')->on('machines');
            $table->foreign('order_number')->references('order_number')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_orders');
    }
};
