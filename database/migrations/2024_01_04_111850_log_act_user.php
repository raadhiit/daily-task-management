<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('LogActUser', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->time('login')->nullable();
            $table->time('logout')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
