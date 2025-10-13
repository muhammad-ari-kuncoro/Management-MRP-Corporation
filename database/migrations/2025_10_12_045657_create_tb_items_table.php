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
        Schema::create('tb_items', function (Blueprint $table) {
            $table->id();
            $table->string('kd_item');
            $table->string('name_item');
            $table->string('spesification');
            $table->string('type');
            $table->integer('qty');
            $table->integer('weight_item');
            $table->string('image_item')->nullable();
            $table->decimal('price_item', 8, 2);
            $table->string('hpp',20,2);
            $table->string('category');
            $table->string('status_item');
            $table->bigInteger('branch_company_id')->unsigned()->nullable();
            $table->foreign("branch_company_id")->references("id")->on("tb_branch_company_items");
            $table->integer('minim_stok');
            $table->string('konversion_items_carbon');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_items');
    }
};
