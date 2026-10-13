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
            $table->string('performance_comment')->after('about_this_report');
            $table->string('report_prepared_by')->nullable()->after('performance_comment');
            $table->foreignId('report_prepared_by_id')
                  ->nullable()
                  ->after('report_prepared_by')
                  ->constrained('users')
                  ->nullOnDelete();
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
            $table->dropForeign(['report_prepared_by_id']);
            $table->dropColumn([
                'performance_comment',
                'report_prepared_by',
                'report_prepared_by_id',
            ]);
        });
    }
};
