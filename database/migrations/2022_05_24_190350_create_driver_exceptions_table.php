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
        Schema::create('driver_exceptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('substitute_driver_id')->nullable();
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('substitute_driver_id')->references('id')->on('drivers');
            $table->date('date_start');
            $table->date('date_end');
            $table->string('notes');
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
        Schema::dropIfExists('driver_exceptions');
    }
};
