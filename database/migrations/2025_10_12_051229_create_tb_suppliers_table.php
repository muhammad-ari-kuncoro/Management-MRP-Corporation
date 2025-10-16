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
        Schema::create('tb_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name_suppliers');
            $table->string('nickname_suppliers');
            $table->string('type_suppliers');
            $table->string('phone_number');
            $table->string('email');
            $table->string('address');
            $table->string('address_shipping');
            $table->string('website');
            $table->string('name_pic');
            $table->string('phone_number_pic');
            $table->string('position_pic')->nullable();
            $table->integer('id_region');
            $table->integer('top');
            $table->integer('limit_kredit');
            $table->string('sales');
            $table->string('method_payment');
            $table->string('duration_shipping');
            $table->string('method_shipping');
            $table->enum('blacklist', ['no', 'yes'])->default('no');
            $table->bigInteger('branch_company_id')->unsigned()->nullable();
            $table->foreign("branch_company_id")->references("id")->on("tb_branch_company_items");
            $table->string('brand');
            $table->string('bank');
            $table->string('no_rek');
            $table->string('npwp');
            $table->string('siup');
            $table->string('scan_npwp')->nullable();
            $table->string('scan_siup')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_suppliers');
    }
};
