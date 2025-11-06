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
        Schema::create('tb_bills_of_materials_details', function (Blueprint $table) {
            $table->id();
            $table->foreign("bom_id")->references("id")->on("tb_bills_of_materials");
            $table->bigInteger('bom_id')->unsigned()->nullable();
            $table->foreign("item_id")->references("id")->on("tb_items");
            $table->bigInteger('item_id')->unsigned()->nullable();
            $table->integer('plan_qty')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_bills_of_materials_details');
    }
};
