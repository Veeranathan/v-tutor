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
        if (Schema::hasTable('student_class_bookings')) {
            if (!Schema::hasColumn('student_class_bookings', 'session_summary')) {
                Schema::table('student_class_bookings', function (Blueprint $table) {
                    $table->longText('session_summary')->nullable();
                    $table->unsignedBigInteger('permission_grade')->comment('1 - Beginning, 2 - Developing, 3 - Proficient, 4 - Strong, 5 - Mastery')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('student_class_bookings')) {
            if (Schema::hasColumn('student_class_bookings', 'session_summary')) {
                Schema::table('student_class_bookings', function (Blueprint $table) {
                    $table->dropColumn('session_summary');
                    $table->dropColumn('permission_grade');
                });
            }
        }
    }
};
