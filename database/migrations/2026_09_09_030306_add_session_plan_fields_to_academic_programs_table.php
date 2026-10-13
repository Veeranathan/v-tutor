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
        Schema::table('academic_programs', function (Blueprint $table) {
             $table->string('parent_session_plan')->nullable()->after('document');
             $table->string('tutor_session_plan')->nullable()->after('parent_session_plan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academic_programs', function (Blueprint $table) {
            //
        });
    }
};
