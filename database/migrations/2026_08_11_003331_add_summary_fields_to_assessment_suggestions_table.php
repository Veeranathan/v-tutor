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
        Schema::table('assessment_suggestions', function (Blueprint $table) {
            $table->text('quantitative_assessment_summary')->nullable()->after('quantitative_statement');
            $table->text('qualitative_responses_summary')->nullable()->after('qualitative_statement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_suggestions', function (Blueprint $table) {
            $table->dropColumn([
                'quantitative_assessment_summary',
                'qualitative_responses_summary',
            ]);
        });
    }
};
