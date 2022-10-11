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
            $table->foreignId('account_id');
            $table->tinyInteger('transaction_type')->comment('1= Debit / 2= Credit');
            $table->string('amount');
            $table->string('purpose')->comment('1 = withdrow, 2 = deposit, 3 = recived payment, 4 = given payment, 5 = Initial Balance');
            $table->string('payment_type')->nullable()->comment('1 = Cheque, 2 = Balance Transfer');
            $table->string('cheque_number')->nullable();
            $table->string('cash_details')->nullable();
            $table->string('remarks');
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
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
