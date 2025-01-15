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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('id_mch')->nullable();
            $table->string('sub')->nullable();
            $table->string('NPK')->unique();
            $table->string('password');
            $table->timestamps('last_login_at');
            $table->integer('level')->default(3)->comment('1=Admin, 2=foreman, 3=member');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
