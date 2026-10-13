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
        Schema::table(
            'learning_program_assessment_forms',
            function (Blueprint $table) {

                /*
                |----------------------------------------------------------
                | REMOVE OLD
                |----------------------------------------------------------
                */
                $table->dropColumn([
                    'assessment_type',
                    'grade',
                ]);

                /*
                |----------------------------------------------------------
                | ADD NEW
                |----------------------------------------------------------
                */
                $table->string('form_slug')
                    ->unique()
                    ->after('form_name');

                $table->text('description')
                    ->nullable()
                    ->after('form_slug');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'learning_program_assessment_forms',
            function (Blueprint $table) {

                /*
                |----------------------------------------------------------
                | REMOVE NEW
                |----------------------------------------------------------
                */
                $table->dropColumn([
                    'form_slug',
                    'description',
                ]);

                /*
                |----------------------------------------------------------
                | RESTORE OLD
                |----------------------------------------------------------
                */
                $table->string('assessment_type')
                    ->nullable();

                $table->string('grade')
                    ->nullable();
            }
        );
    }
};