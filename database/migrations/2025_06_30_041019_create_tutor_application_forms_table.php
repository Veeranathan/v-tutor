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
        if (!Schema::hasTable('tutor_application_forms')) {
            Schema::create('tutor_application_forms', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('tutor_id')->nullable();
                $table->string('taf_id')->nullable();
                $table->string('first_name')->nullable();
                $table->string('middle_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('primary_email')->nullable();
                $table->string('primary_phone')->nullable();
                $table->longText('communication_address')->nullable();
                $table->text('com_addr_country')->nullable();
                $table->text('com_addr_state')->nullable();
                $table->text('com_addr_city')->nullable();
                $table->text('com_addr_street')->nullable();
                $table->text('com_addr_zip')->nullable();
                $table->text('com_addr_timezone')->nullable();
                $table->unsignedBigInteger('pick_permanent_address')->default(1)->nullable();
                $table->longText('permanent_address')->nullable();
                $table->text('perm_addr_country')->nullable();
                $table->text('perm_addr_state')->nullable();
                $table->text('perm_addr_city')->nullable();
                $table->text('perm_addr_street')->nullable();
                $table->text('perm_addr_zip')->nullable();
                $table->date('dob')->nullable();
                $table->string('nationality')->nullable();
                $table->unsignedBigInteger('current_residency_status')->default(0)->nullable();
                $table->longText('current_residency')->nullable();
                $table->unsignedBigInteger('disability_health')->default(3)->comment('1-Yes, 2-No, 3-Default, 3-Default')->nullable();
                $table->json('select_tutor_subjects')->nullable();
                $table->longText('tutor_subjects')->nullable();
                $table->json('select_assist')->nullable();
                $table->json('select_tutor_grade')->nullable();
                $table->unsignedBigInteger('select_tutor_status')->default(0)->nullable();
                $table->unsignedBigInteger('select_merits')->default(0)->nullable();
                $table->unsignedBigInteger('select_commit_per_week')->default(0)->nullable();
                $table->unsignedBigInteger('select_online_class_experience')->default(0)->nullable();
                $table->unsignedBigInteger('select_wwcc')->default(0)->nullable();
                $table->unsignedBigInteger('select_building_activities')->default(0)->nullable();
                $table->text('mother_tongue')->nullable();
                $table->text('primary_communication_language')->nullable();
                $table->text('secondary_communication_language')->nullable();
                $table->text('tertiary_communication_language')->nullable();
                $table->text('other_language')->nullable();
                $table->unsignedBigInteger('select_english_language_proficiency')->default(0)->nullable();
                $table->unsignedBigInteger('select_biological_parent')->default(3)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->unsignedBigInteger('select_not_biological_parent')->default(3)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->unsignedBigInteger('select_domestic_violence')->default(3)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->unsignedBigInteger('select_addicted_to_drugs')->default(3)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->unsignedBigInteger('select_showing_your_face')->default(3)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->unsignedBigInteger('select_worked_children')->default(3)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->longText('worked_children')->nullable();
                $table->unsignedBigInteger('select_working_wwcc')->default(3)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->json('select_australian_states_wwcc')->nullable();
                $table->unsignedBigInteger('select_crime_in_any_country')->default(3)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->longText('crime_in_any_country')->nullable();
                $table->unsignedBigInteger('select_pending_criminal_cases')->default(3)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->longText('pending_criminal_cases')->nullable();
                $table->unsignedBigInteger('select_children_related_offences')->default(3)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->longText('children_related_offences')->nullable();
                $table->longText('motivated_tutor')->nullable();
                $table->longText('belief_values')->nullable();
                $table->longText('understood_topic')->nullable();
                $table->longText('late_online_session')->nullable();
                $table->longText('parent_watching')->nullable();
                $table->longText('academic_achievements')->nullable();
                $table->text('video_interview')->nullable();
                $table->unsignedBigInteger('choose_auth_accept')->default(2)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->unsignedBigInteger('choose_term_accept')->default(2)->comment('1-Yes, 2-No, 3-Default')->nullable();
                $table->unsignedBigInteger('status')->default(3)->comment('1-Approved, 2-Rejected, 3-New, 4-Pending/Partial')->nullable();
                $table->longText('status_remark')->nullable();
                $table->timestamps();
            });
        }
        
        if (!Schema::hasTable('tutor_wwcc')) {
            Schema::create('tutor_wwcc', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('tutor_id')->nullable();
                $table->unsignedBigInteger('tutor_app_id')->nullable();
                $table->unsignedBigInteger('states')->default(0)->nullable();
                $table->text('wwcc_no')->nullable();
                $table->date('expiry_date')->nullable();
                $table->unsignedBigInteger('is_valid')->default(3)->comment('1-Valid, 2-Invalid, 3-Pending')->nullable();
                $table->unsignedBigInteger('generate_from')->default(2)->comment('1-Via Application Form, 2-Manual/Admin')->nullable();
                $table->unsignedBigInteger('status')->default(3)->comment('1-Active, 2-Inactive, 3-New/Pending')->nullable();
                $table->longText('status_remark')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutor_application_forms');
        Schema::dropIfExists('tutor_wwcc');
    }
};
