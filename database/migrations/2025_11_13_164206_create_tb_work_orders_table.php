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
            $table->string('production_plan_id');
            $table->string('operator');
            $table->string('machine_used');
            $table->string('status');
            $table->string('actual_start_date');
            $table->string('actual_start_time');
            $table->string('actual_end_date');
            $table->string('actual_end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_work_orders');
    }
};
