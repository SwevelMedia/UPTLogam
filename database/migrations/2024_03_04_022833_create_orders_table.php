<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('order_name');
            $table->string('material');
            $table->unsignedBigInteger('client_id');
            $table->string('status')->nullable()->default(0);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('id_ppic')->nullable();
            $table->foreign('id_ppic')->references('id')->on('users');
            $table->tinyInteger('need_design')->nullable();
            $table->string('cad_approv', 1)->nullable()->default(0);
            $table->string('cam_approv', 1)->nullable()->default(0);
            $table->string('produksi', 1)->nullable()->default(0);
            $table->string('finish_approv', 1)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
