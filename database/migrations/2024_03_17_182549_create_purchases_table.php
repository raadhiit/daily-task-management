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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id('purchaseID');
            $table->string('itemNumber');
            $table->date('purchaseDate');
            $table->string('itemName');
            $table->float('unitPrice')->default(0);
            $table->integer('quantity')->default(0);
            $table->string('vendorName')->default('Test Vendor');
            $table->integer('vendorID')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
