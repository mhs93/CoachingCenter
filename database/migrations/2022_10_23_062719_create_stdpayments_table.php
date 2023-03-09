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
            $table->integer('account_id')->nullable();
            $table->integer('adjustment_type')->nullable()->comment('1=Addition/2=Subtraction');
            $table->double('adjustment_balance')->nullable();
            $table->string('adjustment_cause')->nullable();
            $table->double('total_amount');
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
        Schema::dropIfExists('stdpayments');
    }
};
