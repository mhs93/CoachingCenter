<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Exam name');
            $table->tinyInteger('status')->comment('1 = Active / 0 = Deactivate')->default('1');
            $table->longText('batch_id');
            $table->longText('subject_id');
            $table->longText('start_time')->comment('Exam start date and time');
            $table->longText('end_time')->comment('Exam end date and time');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('exams');
    }
};
