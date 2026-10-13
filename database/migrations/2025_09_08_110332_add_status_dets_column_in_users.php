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
            if (!Schema::hasColumn('users', 'status_remark')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->longText('status_remark')->nullable();
                    $table->unsignedBigInteger('status_change_user_id')->nullable();
                    $table->dateTime('status_change_date')->nullable();
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
            if (Schema::hasColumn('users', 'status_remark')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('status_remark');
                    $table->dropColumn('status_change_user_id');
                    $table->dropColumn('status_change_date');
                });
            }
        }
    }
};
