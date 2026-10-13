<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('learning_program_assessments', function (Blueprint $table) {
            $table->id();

            // Assessment basic info
            $table->string('assessment_for')->nullable();   // me | child
            $table->string('visit_reason')->nullable();     // reason for visit

            // Academic details
            $table->string('school_year')->nullable();      // year
            $table->string('state')->nullable();            // state/location
            $table->string('subject')->nullable();          // subject
            $table->string('learning_need')->nullable();    // learning need
            $table->string('free_time')->nullable();        // free time preference

            // User details
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('country_code', 10)->nullable();

            // Tracking & meta
            $table->string('source')->nullable();           // fb | google | direct
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // Indexes (important for admin filtering & performance)
            $table->index('email');
            $table->index('phone');
            $table->index('assessment_for');
            $table->index('school_year');
            $table->index('subject');
            $table->index('state');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_program_assessments');
    }
};
