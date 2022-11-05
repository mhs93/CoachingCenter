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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('stdpayment_id')->nullable();
            $table->integer('tchpayment_id')->nullable();
            $table->integer('income_id')->nullable();
            $table->integer('expense_id')->nullable();
            $table->integer('account_id')->nullable();
            $table->integer('transaction_type')->comment('1= Credit / 2= Debit / 3= Initail Balance');
            $table->double('amount');
            $table->string('payment_type')->comment('1 = Cheque, 2 = Cash');
            $table->string('cheque_number')->nullable();
            $table->string('note')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('transactions');
    }
};
