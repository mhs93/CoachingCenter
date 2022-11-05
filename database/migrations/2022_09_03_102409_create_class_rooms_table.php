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

        Schema::create('class_rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('batch_id');
            $table->integer('subject_id');
            $table->string('class_type');
            $table->string('class_link')->nullable();
            $table->string('access_key')->nullable();
            $table->string('duration');
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->integer('status')->comment('1 = Active / 0 = Deactivate')->default('1');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('class_rooms');
    }
};
