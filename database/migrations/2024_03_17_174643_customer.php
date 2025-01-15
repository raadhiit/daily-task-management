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
        Schema::create('customer', function (Blueprint $table) {
            $table->id('customerID');
            $table->string('fullName');
            $table->string('email')->nullable();
            $table->integer('mobile');
            $table->integer('phone2')->nullable();
            $table->string('address');
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('district');
            $table->string('status');
            $table->timestamp('createdOn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
