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
        Schema::create('person_role_archive', function (Blueprint $table) {
            $table->id();
            $table->datetime('startOfWeek');
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('person_id')->references('resource_id')->on('people');
            $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('person_role_archive');
    }
};
