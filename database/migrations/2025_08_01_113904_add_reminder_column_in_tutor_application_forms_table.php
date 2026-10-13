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
        if (Schema::hasTable('tutor_application_forms')) {
            if (!Schema::hasColumn('tutor_application_forms', 'taf_reminder_count')) {
                Schema::table('tutor_application_forms', function (Blueprint $table) {
                    $table->unsignedBigInteger('taf_reminder_count')->after('status_remark')->default(0)->nullable();
                    $table->dateTime('taf_reminder_date')->after('taf_reminder_count')->nullable();
                    $table->unsignedBigInteger('wwcc_expiry_reminder_count')->after('taf_reminder_date')->default(0)->nullable();
                    $table->dateTime('wwcc_expiry_reminder_date')->after('wwcc_expiry_reminder_count')->nullable();
                    $table->unsignedBigInteger('wwcc_expired_reminder_count')->after('wwcc_expiry_reminder_date')->default(0)->nullable();
                    $table->dateTime('wwcc_expired_reminder_date')->after('wwcc_expired_reminder_count')->nullable();
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
        if (Schema::hasTable('tutor_application_forms')) {
            if (Schema::hasColumn('tutor_application_forms', 'taf_reminder_count')) {
                Schema::table('tutor_application_forms', function (Blueprint $table) {
                    $table->dropColumn('taf_reminder_count');
                    $table->dropColumn('taf_reminder_date');
                    $table->dropColumn('wwcc_expiry_reminder_count');
                    $table->dropColumn('wwcc_expiry_reminder_date');
                    $table->dropColumn('wwcc_expired_reminder_count');
                    $table->dropColumn('wwcc_expired_reminder_date');
                });
            }
        }
    }
};
