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
        if (Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'student_f_name')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('student_f_name')->nullable();
                    $table->string('student_l_name')->nullable();
                    $table->date('student_dob')->nullable();
                    $table->unsignedBigInteger('student_grade')->nullable();
                    $table->unsignedBigInteger('operate_accept')->default(2)->comment('1-Accept,2-Not Accept')->nullable();
                    $table->unsignedBigInteger('collect_data_accept')->default(2)->comment('1-Accept,2-Not Accept')->nullable();
                    $table->unsignedBigInteger('rules_accept')->default(2)->comment('1-Accept,2-Not Accept')->nullable();
                    $table->string('signature_full_name')->nullable();
                    $table->dateTime('signature_date')->nullable();
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
        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'student_f_name')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('student_f_name');
                    $table->dropColumn('student_l_name');
                    $table->dropColumn('student_dob');
                    $table->dropColumn('student_grade');
                    $table->dropColumn('operate_accept');
                    $table->dropColumn('collect_data_accept');
                    $table->dropColumn('rules_accept');
                    $table->dropColumn('signature_full_name');
                    $table->dropColumn('signature_date');
                });
            }
        }
    }
};
