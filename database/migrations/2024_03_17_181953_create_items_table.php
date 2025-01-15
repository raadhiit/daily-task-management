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
        Schema::create('items', function (Blueprint $table) {
            $table->id('productID');
            $table->string('itemNumber');
            $table->string('itemName');
            $table->float('discount')->default(0);
            $table->integer('stock')->default(0);
            $table->float('unitPrice')->default(0);
            $table->string('imageURL')->default('imageNotAvailable.jpg');
            $table->string('status')->default('active');
            $table->string('location');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
