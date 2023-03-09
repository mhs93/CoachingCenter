<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::dropIfExists('students');
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reg_no');
            $table->string('email');
            $table->integer('batch_id');
            $table->integer('gender');
            $table->string('current_address');
            $table->string('permanent_address');
            $table->string('contact_number');
            $table->string('parent_information');
            $table->string('parent_contact');
            $table->string('guardian_information');
            $table->string('guardian_contact');
            $table->string('profile')->nullable();
            $table->integer('status')->comment('1 = Active / 0 = Deactivate')->default('1');
            $table->integer('adjustment_type')->nullable()->comment('1 = Addition / 2 = Subtraction');
            $table->double('initial_amount');
            $table->double('adjustment_balance')->nullable();
            $table->string('adjustment_cause')->nullable();
            $table->double('total_amount');
            $table->string('monthly_fee');

            $table->text('note')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
