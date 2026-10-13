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
            $table->timestamp('student_login_at')
                ->nullable()
                ->after('student_joined');

            $table->timestamp('tutor_login_at')
                ->nullable()
                ->after('student_login_at');
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
                'student_login_at',
                'tutor_login_at',
            ]);
        });
    }
};
