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
        Schema::create('pending_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('resource_type');
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->string('job_action');
            $table->json('payload')->nullable();
            $table->string('schedule_type')->default('lock');
            $table->datetime('schedule_time')->nullable();
            $table->timestamp('committed_at')->nullable()->default(null);
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
        Schema::dropIfExists('pending_jobs');
    }
};
