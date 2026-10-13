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
        Schema::table('academic_program_sessions', function (Blueprint $table) {
            $table->dateTime('start_time')->nullable()->after('scheduled_at');
            $table->dateTime('end_time')->nullable()->after('start_time');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academic_program_sessions', function (Blueprint $table) {
             $table->dropColumn(['start_time', 'end_time']);
        });
    }
};
