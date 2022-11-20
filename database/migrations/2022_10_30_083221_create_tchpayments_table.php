<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tchpayments', function (Blueprint $table) {
            $table->id();
            $table->integer('tch_id');
            $table->string('month');
            $table->integer('total_amount');
            $table->integer('account_id')->nullable();
            $table->integer('deduction_amount')->nullable();
            $table->integer('additional_amount')->nullable();
            $table->integer('payment_type')->comment('1=cheque/2=cash');
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
        Schema::dropIfExists('tchpayments');
    }
};
