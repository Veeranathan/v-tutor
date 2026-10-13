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

            $table->integer('student_class_booking_id')
                ->nullable()
                ->after('purchase_id');

            $table->foreign('student_class_booking_id')
                ->references('id')
                ->on('student_class_bookings')
                ->onDelete('cascade');
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
            $table->dropForeign(['student_class_booking_id']);
            $table->dropColumn('student_class_booking_id');
        });
    }
};
