<?php

use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('teachers');
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->longText('subject_id');
            $table->string('name');
            $table->string('reg_no')->comment('This is teacher registration number (uniq)');
            $table->string('email');
            $table->integer('gender');
            $table->string('current_address');
            $table->string('permanent_address');
            $table->string('contact_number');
            $table->text('profile');
            $table->boolean('status')->comment('1 = Active / 0 = Deactivate')->default('1');
            $table->string('monthly_salary')->nullable();
            $table->string('note')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
};
