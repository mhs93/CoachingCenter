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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Batch name');
            $table->tinyInteger('status')->comment('1 = Active / 0 = Deactivate')->default('1');
            $table->longText('subject_id');
            $table->string('note')->nullable();
            $table->double('batch_fee')->nullable();
            $table->timestamp('start_time')->comment('Batch start date and time');
            $table->timestamp('end_time')->comment('Batch end time');
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
        Schema::dropIfExists('batches');
    }
};
