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
            $table->string('name');
            $table->integer('status')->comment('1 = Active / 0 = Deactivate')->default('1');
            $table->json('subject_id');
            $table->string('note')->nullable();
            $table->string('image')->nullable();
            $table->string('start_date');
            $table->string('end_date');

            $table->integer('adjustment_type')->nullable()->comment('1 = Addition / 2 = Subtraction');
            $table->double('initial_amount')->nullable();
            $table->double('adjustment_balance')->nullable();
            $table->double('total_amount')->nullable();
            $table->string('adjustment_cause')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
