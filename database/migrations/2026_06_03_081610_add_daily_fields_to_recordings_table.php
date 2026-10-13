<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recordings', function (Blueprint $table) {

            $table->integer('duration')->nullable()->after('recording_url');

            $table->integer('max_participants')->nullable()->after('duration');

            $table->string('daily_status')->nullable()->after('max_participants');

            $table->string('daily_instance_id')->nullable()->after('daily_status');

            $table->string('s3_key')->nullable()->after('daily_instance_id');
        });
    }

    public function down(): void
    {
        Schema::table('recordings', function (Blueprint $table) {

            $table->dropColumn([
                'duration',
                'max_participants',
                'daily_status',
                'daily_instance_id',
                's3_key'
            ]);
        });
    }
};