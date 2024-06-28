<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGambarsTable extends Migration
{
    public function up()
    {
        Schema::create('gambars', function (Blueprint $table) {
            $table->id();
            $table->string('owner');
            $table->unsignedBigInteger('order_id');
            $table->string('path');
            $table->timestamps();

            
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gambars');
    }
}
