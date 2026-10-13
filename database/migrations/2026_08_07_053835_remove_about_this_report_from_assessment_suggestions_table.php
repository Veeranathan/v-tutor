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
            if (Schema::hasColumn('assessment_suggestions', 'about_this_report')) {
                $table->dropColumn('about_this_report');
            }
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
            //
        });
    }
};
