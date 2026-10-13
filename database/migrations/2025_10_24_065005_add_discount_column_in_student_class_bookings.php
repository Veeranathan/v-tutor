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
            if (!Schema::hasColumn('student_class_bookings', 'discount_amount')) {
                Schema::table('student_class_bookings', function (Blueprint $table) {
                    $table->double('discount_amount', 30, 2)->default(0.00)->nullable()->after('stripe_charge');
                    $table->double('net_total', 30, 2)->default(0.00)->nullable()->after('discount_amount');
                    $table->double('discount_percentage', 30, 2)->default(0.00)->nullable()->after('net_total');
                    $table->string('discount_code')->nullable()->after('discount_percentage');
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
            if (Schema::hasColumn('student_class_bookings', 'discount_amount')) {
                Schema::table('student_class_bookings', function (Blueprint $table) {
                    $table->dropColumn('discount_amount');
                    $table->dropColumn('net_total');
                    $table->dropColumn('discount_percentage');
                    $table->dropColumn('discount_code');
                });
            }
        }
    }
};
