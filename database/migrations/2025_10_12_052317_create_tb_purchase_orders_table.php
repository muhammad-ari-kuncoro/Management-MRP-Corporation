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
        Schema::create('tb_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_no');
            $table->string('po_date');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign("user_id")->references("id")->on("users");
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->foreign("supplier_id")->references("id")->on("tb_suppliers");
            $table->string('estimation_delivery_date')->nullable();
            $table->string('note')->nullable()->nullable();
            $table->enum('status', ['pph_new','draft', 'pending', 'waiting_gr','partial_items','done','rejected'])->default('draft');
            $table->string('currency')->nullable();
            $table->string('currency_rate')->nullable();
            $table->string('attachment')->nullable();
            $table->string('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->string('transportation_fee')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('total_diskon_harga')->nullable();
            $table->string('PPN')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('journal_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_purchase_orders');
    }
};
