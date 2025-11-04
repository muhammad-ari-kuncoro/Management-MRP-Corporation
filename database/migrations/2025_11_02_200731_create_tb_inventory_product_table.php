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
        Schema::create('tb_inventory_product', function (Blueprint $table) {
            $table->id();
            $table->foreign("product_id")->references("id")->on("tb_product");
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->string('description_inventory_location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_inventory_product');
    }
};
