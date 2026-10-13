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
            if (!Schema::hasColumn('tutor_application_forms', 'select_addicted_to_drugs_details')) {
                Schema::table('tutor_application_forms', function (Blueprint $table) {
                    $table->longText('select_addicted_to_drugs_details')->after('select_addicted_to_drugs')->nullable();
                    $table->longText('select_showing_your_face_details')->after('select_showing_your_face')->nullable();
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
            if (Schema::hasColumn('tutor_application_forms', 'select_addicted_to_drugs_details')) {
                Schema::table('tutor_application_forms', function (Blueprint $table) {
                    $table->dropColumn('select_addicted_to_drugs_details');
                    $table->dropColumn('select_showing_your_face_details');
                });
            }
        }
    }
};
