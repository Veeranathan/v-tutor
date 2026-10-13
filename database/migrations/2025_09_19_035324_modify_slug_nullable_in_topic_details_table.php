<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('topic_details', function (Blueprint $table) {

            if (!Schema::hasColumn('topic_details', 'slug')) {
                $table->string('slug', 15)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('topic_details', function (Blueprint $table) {
            $table->string('slug', 15)->nullable(false)->change();
        });
    }
};
