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
        Schema::create('my_assessments', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('learning_program_assessment_id');
            $table->unsignedBigInteger('student_id');

            // Assessment data
            $table->json('qualitative_answers')->nullable();
            $table->json('quantitative_answers')->nullable();

            // Submission flags
            $table->boolean('qualitative_submitted')->default(false);
            $table->boolean('quantitative_submitted')->default(false);

            $table->timestamps();

            // FK constraints
            $table->foreign('learning_program_assessment_id')
                  ->references('id')
                  ->on('learning_program_assessments')
                  ->onDelete('cascade');

            $table->foreign('student_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_assessments');
    }
};
