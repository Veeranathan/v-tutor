<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'learning_program_assessment_forms',
            function (Blueprint $table) {

                $table->id();
                $table->string('form_name');
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
                ]);

                $table->string('grade')->nullable();

                $table->enum('category', [

                    'year-wise',

                    'subject-wise',
                ]);

                /*
                |--------------------------------------------------------------------------
                | SECTIONS
                |--------------------------------------------------------------------------
                | ["reading","writing"]
                |--------------------------------------------------------------------------
                */

                $table->json('sections')->nullable();

                /*
                |--------------------------------------------------------------------------
                | TOTAL PASSAGES
                |--------------------------------------------------------------------------
                */

                $table->integer('passage_count')
                    ->default(0);

                /*
                |--------------------------------------------------------------------------
                | PASSAGES JSON
                |--------------------------------------------------------------------------
                */

                $table->json('passages')
                    ->nullable();

                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                $table->boolean('status')
                    ->default(true);

                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'learning_program_assessment_forms'
        );
    }
};
