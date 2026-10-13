<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('learning_program_assessments', function (Blueprint $table) {
            $table->string('status')
                ->default('pending')
                ->after('terms_agreed')
                ->index();
            // pending | progress | completed
        });
    }

    public function down(): void
    {
        Schema::table('learning_program_assessments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
