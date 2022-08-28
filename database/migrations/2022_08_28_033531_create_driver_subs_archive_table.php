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
        Schema::create('driver_subs_archive', function (Blueprint $table) {
            $table->id();
            $table->datetime('startOfWeek');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('sub_driver_id');
            $table->datetime('date');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('route_id')->references('id')->on('routes');
            $table->foreign('sub_driver_id')->references('id')->on('drivers');
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
        Schema::dropIfExists('driver_subs_archive');
    }
};
