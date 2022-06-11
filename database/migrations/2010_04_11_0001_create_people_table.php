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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('user_id')->nullable();
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->unsignedBigInteger('subclass_id')->nullable();
            // $table->string('subclass_type')->nullable();
            $table->string('firstName')->default('');
            $table->string('lastName')->default('');
            $table->string('email')->nullable()->unique();
            $table->string('phoneHome')->default('');
            $table->string('phoneCell')->default('');
            $table->string('notes')->default('')->nullable();
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
        Schema::dropIfExists('people');
    }
};
