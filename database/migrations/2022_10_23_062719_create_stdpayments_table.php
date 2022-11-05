<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stdpayments', function (Blueprint $table) {
            $table->id();
            $table->integer('std_id');
            $table->string('month');
            $table->integer('total_amount');
            $table->integer('account_id')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->integer('additional_amount')->nullable();
            $table->integer('payment_type');
            $table->string('cheque_number')->nullable();
            $table->string('note')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stdpayments');
    }
};
