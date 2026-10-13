<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('learning_program_assessment_questions', function (Blueprint $table) {
            // Correct answer (one of the options)
            $table->string('answer')->nullable()->after('options');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('learning_program_assessment_questions', function (Blueprint $table) {
            $table->dropColumn('answer');
        });
    }
};
