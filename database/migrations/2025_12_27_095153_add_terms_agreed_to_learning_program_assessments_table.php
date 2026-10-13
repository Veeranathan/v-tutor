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
            $table->boolean('terms_agreed')->default(0)->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_program_assessments', function (Blueprint $table) {
            $table->dropColumn('terms_agreed');
        });
    }
};
