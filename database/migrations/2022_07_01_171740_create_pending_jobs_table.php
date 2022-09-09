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
            $table->string('job_name');
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->json('payload')->nullable();
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
