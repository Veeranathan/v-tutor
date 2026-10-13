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
            $table->enum('payment_status', ['paid', 'pending', 'failed'])
                ->default('pending')
                ->after('payment_method');
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
            $table->dropColumn('payment_status');
        });
    }
};
