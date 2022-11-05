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
            $table->string('parent_contact');
            $table->string('profile')->nullable();
            $table->integer('status')->comment('1 = Active / 0 = Deactivate')->default('1');
            $table->double('monthly_fee')->nullable();
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
