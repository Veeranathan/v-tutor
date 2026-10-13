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
        Schema::table('learning_program_assessments', function (Blueprint $table) {
            // Timestamp when OTP is successfully verified
            $table->timestamp('otp_verified_at')
                  ->nullable()
                  ->after('otp_expires');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_program_assessments', function (Blueprint $table) {
            $table->dropColumn('otp_verified_at');
        });
    }
};
