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
        Schema::table('learning_program_assessment_questions', function (Blueprint $table) {
            $table->string('assessment_type')->nullable()->after('grade');
            $table->string('section')->nullable()->after('assessment_type');
            $table->text('passage')->nullable()->after('section');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_program_assessment_questions', function (Blueprint $table) {
            $table->dropColumn(['assessment_type', 'section', 'passage']);
        });
    }
};
