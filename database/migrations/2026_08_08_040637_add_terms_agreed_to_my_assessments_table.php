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
        Schema::table('my_assessments', function (Blueprint $table) {
            $table->boolean('terms_agreed')->default(false)->after('assessment_form_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('my_assessments', function (Blueprint $table) {
            $table->dropColumn('terms_agreed');
        });
    }
};
