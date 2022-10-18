<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_subs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_sub_period_id');
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('sub_driver_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_subs');
    }
};
