<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyInteger('status')->comment('1 = Active / 0 = Deactivate')->default('1');
            $table->longText('subject_id');
            $table->longText('batch_id');
            $table->string('file');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('resources');
    }
};
