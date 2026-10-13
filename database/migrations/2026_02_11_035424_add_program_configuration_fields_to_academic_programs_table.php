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
        Schema::table('academic_programs', function (Blueprint $table) {

            $table->string('program_type')->nullable()->after('display_order');
            $table->string('program_duration')->nullable()->after('program_type');
            $table->string('session_duration')->nullable()->after('program_duration');
            $table->text('session_interval')->nullable()->after('session_duration');
            $table->string('mode_of_delivery')->nullable()->after('session_interval');
            $table->string('program_tutor')->nullable()->after('mode_of_delivery');
            $table->string('booking_method')->nullable()->after('program_tutor');
            $table->json('assessments')->nullable()->after('booking_method');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academic_programs', function (Blueprint $table) {

            $table->dropColumn([
                'program_type',
                'program_duration',
                'session_duration',
                'session_interval',
                'mode_of_delivery',
                'program_tutor',
                'booking_method',
                'assessments'
            ]);

        });
    }
};
