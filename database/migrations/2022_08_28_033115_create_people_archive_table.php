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
        Schema::create('people_archive', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resource_id');
            $table->string('firstName')->default('');
            $table->string('lastName')->default('');
            $table->string('email')->nullable();
            $table->string('phoneHome')->nullable()->default('');
            $table->string('phoneCell')->nullable()->default('');
            $table->string('notes')->default('')->nullable();
            $table->datetime('startOfWeek');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people_archive');
    }
};
