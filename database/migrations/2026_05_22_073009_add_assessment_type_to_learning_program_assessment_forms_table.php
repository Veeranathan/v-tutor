<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'learning_program_assessment_forms',
            function (Blueprint $table) {

                $table->string('assessment_type')
                    ->nullable()
                    ->after('description');
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'learning_program_assessment_forms',
            function (Blueprint $table) {

                $table->dropColumn('assessment_type');
            }
        );
    }
};