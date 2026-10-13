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
            if (!Schema::hasColumn('users', 'admin_rej_sus_reason')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->longText('admin_rej_sus_reason')->nullable();
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
            if (Schema::hasColumn('users', 'admin_rej_sus_reason')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('admin_rej_sus_reason');
                });
            }
        }
    }
};
