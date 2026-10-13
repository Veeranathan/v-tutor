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
        $table->boolean('is_academic_program')
              ->default(false)
              ->after('permission_grade');

        $table->unsignedBigInteger('academic_program_purchase_id')
              ->nullable()
              ->after('is_academic_program');

        $table->foreign('academic_program_purchase_id')
              ->references('id')
              ->on('academic_program_purchases')
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
        Schema::table('student_class_bookings', function (Blueprint $table) {
            $table->dropForeign(['academic_program_purchase_id']);
            $table->dropColumn(['is_academic_program', 'academic_program_purchase_id']);
        });
    }
};
