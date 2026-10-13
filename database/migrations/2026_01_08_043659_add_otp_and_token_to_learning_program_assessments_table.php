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

            // OTP & Token fields
            $table->string('otp', 10)->nullable()->after('status');
            $table->timestamp('otp_expires')->nullable()->after('otp');
            $table->string('token', 100)->nullable()->after('otp_expires');

            // Optional indexes (recommended)
            $table->index('otp');
            $table->index('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_program_assessments', function (Blueprint $table) {
            $table->dropIndex(['otp']);
            $table->dropIndex(['token']);

            $table->dropColumn([
                'otp',
                'otp_expires',
                'token'
            ]);
        });
    }
};
