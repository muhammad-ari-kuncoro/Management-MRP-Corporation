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
        Schema::create('tb_purchase_orders_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_order_id')->unsigned()->nullable();
            $table->foreign("purchase_order_id")->references("id")->on("tb_purchase_orders");
            $table->bigInteger('items_id')->unsigned()->nullable();
            $table->foreign("items_id")->references("id")->on("tb_items");
            $table->integer('qty');
            $table->decimal('discount', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_purchase_orders_details');
    }
};
