<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'learning_program_assessment_questions',
            function (Blueprint $table) {

                /*
                |--------------------------------------------------------------------------
                | REMOVE OLD COLUMNS
                |--------------------------------------------------------------------------
                */

                $table->dropColumn([

                    'assessment_type',

                    'grade',

                    'passage',
                ]);

                /*
                |--------------------------------------------------------------------------
                | ADD FORM RELATION
                |--------------------------------------------------------------------------
                */

                $table->unsignedBigInteger('form_id')
                    ->nullable()
                    ->after('id');

                /*
                |--------------------------------------------------------------------------
                | PASSAGE NUMBER
                |--------------------------------------------------------------------------
                */

                $table->integer('passage_no')
                    ->nullable()
                    ->after('section');

                /*
                |--------------------------------------------------------------------------
                | FOREIGN KEY
                |--------------------------------------------------------------------------
                */

                $table->foreign('form_id')
                    ->references('id')
                    ->on('learning_program_assessment_forms')
                    ->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'learning_program_assessment_questions',
            function (Blueprint $table) {

                /*
                |--------------------------------------------------------------------------
                | DROP FOREIGN KEY
                |--------------------------------------------------------------------------
                */

                $table->dropForeign([
                    'form_id'
                ]);

                /*
                |--------------------------------------------------------------------------
                | DROP NEW COLUMNS
                |--------------------------------------------------------------------------
                */

                $table->dropColumn([

                    'form_id',

                    'passage_no',
                ]);

                /*
                |--------------------------------------------------------------------------
                | RESTORE OLD COLUMNS
                |--------------------------------------------------------------------------
                */

                $table->enum('assessment_type', [

                    'general',

                    'oc',

                    'selective',

                    'year-1',
                    'year-2',
                    'year-3',
                    'year-4',
                    'year-5',
                    'year-6',
                    'year-7',
                    'year-8',
                    'year-9',
                    'year-10',
                    'year-11',
                    'year-12',
                ])->nullable();

                $table->string('grade')
                    ->nullable();

                $table->longText('passage')
                    ->nullable();
            }
        );
    }
};
