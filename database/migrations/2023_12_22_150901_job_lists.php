<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_lists', function (Blueprint $table) {
            $table->id('id_jobList');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id_project')->on('projects')->onDelete('cascade');
            $table->string('project')->nullable();
            $table->integer('id_mch')->nullable();
            $table->string('part_name')->nullable();
            $table->string('die_part')->nullable();
            $table->string('id_job')->nullable();
            $table->string('main_task')->nullable();
            $table->integer('lead_time')->nullable();
            $table->string('validasi')->nullable();
            $table->string('priority')->nullable();
            $table->string('note', 1000)->nullable();
            $table->string('status_job')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_lists');
    }
};
