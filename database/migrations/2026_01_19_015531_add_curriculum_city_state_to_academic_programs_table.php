<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('academic_programs', function (Blueprint $table) {
            $table->string('curriculum')->nullable()->after('year');
            $table->string('city')->nullable()->after('curriculum');
            $table->string('state')->nullable()->after('city');
        });
    }

    public function down()
    {
        Schema::table('academic_programs', function (Blueprint $table) {
            $table->dropColumn(['curriculum', 'city', 'state']);
        });
    }
};
