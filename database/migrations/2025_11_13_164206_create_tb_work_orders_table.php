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
        Schema::create('tb_work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('work_order_code');
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign("product_id")->references("id")->on("tb_product");
            $table->bigInteger('bom_id')->unsigned()->nullable();
            $table->foreign("bom_id")->references("id")->on("tb_bills_of_materials");
            $table->string('no_reference');
            $table->integer('qty_ordered');
            $table->integer('qty_completed');
            $table->string('delivery_date_product');
            $table->softDeletes(); // ini otomatis bikin kolom deleted_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
       Schema::table('tb_work_orders', function (Blueprint $table) {
        $table->dropSoftDeletes('deleted_at');
    });
    }
};
