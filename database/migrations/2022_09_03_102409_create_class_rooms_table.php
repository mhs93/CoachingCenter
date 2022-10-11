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
            $table->foreignId('batch_id')->constrained('batches');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->string('class_type');

            $table->string('class_link')->nullable()->comment('class video link');
            $table->string('access_key')->nullable()->comment('access key for watch class video');
            $table->string('duration')->comment('class duration');
            $table->timestamp('start_time')->nullable()->comment('class start date and time');
            $table->timestamp('end_time')->nullable()->comment('class end time');
            $table->boolean('status')->comment('1 = Active / 0 = Deactivate')->default('1');
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
        Schema::dropIfExists('class_rooms');
    }
};
