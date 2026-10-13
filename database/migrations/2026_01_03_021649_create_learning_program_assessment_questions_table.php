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
        Schema::create('learning_program_assessment_questions', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['qualitative', 'quantitative']);
            $table->string('subject'); // Based on student's selected subject
            $table->text('question');

            $table->enum('question_type', ['choose_best', 'text']);
            $table->json('options')->nullable(); // Only for choose_best

            $table->decimal('question_mark', 5, 2)->nullable();

            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_program_assessment_questions');
    }
};
