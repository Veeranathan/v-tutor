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
        Schema::table('learning_program_assessment_questions', function (Blueprint $table) {

            $table->string('assessment_type')
                ->nullable()
                ->after('form_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_program_assessment_questions', function (Blueprint $table) {

            $table->dropColumn('assessment_type');
        });
    }
};