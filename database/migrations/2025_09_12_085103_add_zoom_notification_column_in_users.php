<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'zoom_meet_onehr_cnt')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unsignedBigInteger('zoom_meet_onehr_cnt')->default(0)->nullable();
                    $table->dateTime('zoom_meet_onehr_time')->nullable();
                    $table->unsignedBigInteger('zoom_meet_five_min_cnt')->default(0)->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users')) {
            if (Schema::hasColumn('users', 'zoom_meet_onehr_cnt')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('zoom_meet_onehr_cnt');
                    $table->dropColumn('zoom_meet_onehr_time');
                    $table->dropColumn('zoom_meet_five_min_cnt');
                });
            }
        }
    }
};
