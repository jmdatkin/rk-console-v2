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
        Schema::create('driver_exception_route', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_id');
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('e_id');
            $table->foreign('sub_id')->references('id')->on('drivers');
            $table->foreign('route_id')->references('id')->on('routes');
            $table->foreign('e_id')->references('id')->on('driver_exceptions');
            $table->datetime('date');
            $table->unique(['sub_id','route_id','e_id','date']);

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
        Schema::dropIfExists('driver_exception_route');
    }
};
