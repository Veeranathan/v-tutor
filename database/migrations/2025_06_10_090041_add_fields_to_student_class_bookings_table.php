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
          Schema::table('student_class_bookings', function (Blueprint $table) {
        $table->integer('subject_area')->nullable();
        $table->longText('session_topic')->nullable();
        $table->longText('problem_areas')->nullable();
        $table->longText('session_outcome')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_class_bookings', function (Blueprint $table) {
            $table->dropColumn([
            'subject_area',
            'session_topic',
            'problem_areas',
            'session_outcome'
        ]);
        });
    }
};
