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
             $table->boolean('student_joined')
                  ->default(false)
                  ->after('join_url')
                  ->comment('Tracks whether the student clicked the join session link');
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
            //
        });
    }
};
