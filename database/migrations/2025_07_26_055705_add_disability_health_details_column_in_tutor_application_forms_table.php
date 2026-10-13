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
            if (!Schema::hasColumn('tutor_application_forms', 'disability_health_details')) {
                Schema::table('tutor_application_forms', function (Blueprint $table) {
                    $table->longText('disability_health_details')->after('disability_health')->nullable();
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
            if (Schema::hasColumn('tutor_application_forms', 'disability_health_details')) {
                Schema::table('tutor_application_forms', function (Blueprint $table) {
                    $table->dropColumn('disability_health_details');
                });
            }
        }
    }
};
