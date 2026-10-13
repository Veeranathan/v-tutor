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
            if (!Schema::hasColumn('student_class_bookings', 'topic_details_id')) {
                Schema::table('student_class_bookings', function (Blueprint $table) {
                    $table->unsignedBigInteger('topic_details_id')->after('subject_id')->nullable();
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
            if (Schema::hasColumn('student_class_bookings', 'topic_details_id')) {
                Schema::table('student_class_bookings', function (Blueprint $table) {
                    $table->dropColumn('topic_details_id');
                });
            }
        }
    }
};
