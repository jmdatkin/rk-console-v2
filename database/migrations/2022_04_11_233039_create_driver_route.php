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
        Schema::create('driver_route', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('route_id');
            $table->enum('weekday', ['mon','tues','wed','thurs','fri','sat','sun']);
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('route_id')->references('id')->on('routes');
            $table->unique(['driver_id','route_id','weekday']);
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
        Schema::dropIfExists('driver_route');
    }
};
