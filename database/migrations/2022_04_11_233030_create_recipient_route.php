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
        Schema::create('recipient_route', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipient_id');
            $table->unsignedBigInteger('route_id');
            $table->integer('driver_custom_order')->default(0);
            // $table->enum('weekday', ['mon','tue','wed','thu','fri','sat','sun']);
            $table->integer('weekday');
            $table->foreign('recipient_id')->references('id')->on('recipients');
            $table->foreign('route_id')->references('id')->on('routes');
            $table->unique(['recipient_id','route_id','weekday']);
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
        Schema::dropIfExists('recipient_route');
    }
};
