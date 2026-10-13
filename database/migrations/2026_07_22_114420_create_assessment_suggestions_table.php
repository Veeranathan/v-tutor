<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessment_suggestions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('learning_program_assessment_id')
                  ->constrained('learning_program_assessments')
                  ->onDelete('cascade');
            $table->foreignId('student_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->text('advisor_summary_report');

            $table->json('key_strengths'); // Array of selected options
            $table->string('additional_strength')->nullable();

            $table->json('learning_opportunities'); // Array of selected options
            $table->string('additional_opportunity')->nullable();

            $table->string('quantitative_status'); // Validated | Not Validated
            $table->string('quantitative_statement');

            $table->string('qualitative_status'); // Validated | Not Validated
            $table->string('qualitative_statement');

            $table->string('overall_alignment');
            $table->text('alignment_summary');

            $table->text('additional_notes')->nullable();

            $table->string('reading');   // Strong | Developing | Emerging | Needs Support
            $table->string('reasoning'); // Strong | Developing | Emerging | Needs Support
            $table->string('thinking');  // Strong | Developing | Emerging | Needs Support
            $table->string('logic');     // Strong | Developing | Emerging | Needs Support
            $table->string('writing');   // Strong | Developing | Emerging | Needs Support

            $table->json('recommended_learning_priorities'); // Array (max 4 selected in UI)
            $table->json('recommended_learning_pathway');    // Array of selected programs

            $table->text('about_this_report');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_suggestions');
    }
};