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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('saleID');
            $table->string('itemNumber');
            $table->integer('customerID');
            $table->string('customerName');
            $table->string('itemName');
            $table->date('saleDate');
            $table->float('discount')->default(0);
            $table->integer('quantity')->default(0);
            $table->float('unitPrice')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
