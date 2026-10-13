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
        $table->string('grade')->nullable()->after('subject');
    });
}

public function down()
{
    Schema::table('learning_program_assessment_questions', function (Blueprint $table) {
        $table->dropColumn('grade');
    });
}
};
