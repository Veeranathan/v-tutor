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
        if (Schema::hasTable('zoom_users')) {
            if (!Schema::hasColumn('zoom_users', 'password')) {
                Schema::table('zoom_users', function (Blueprint $table) {
                    $table->longText('password')->after('email')->nullable();
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
        if (Schema::hasTable('zoom_users')) {
            if (Schema::hasColumn('zoom_users', 'password')) {
                Schema::table('zoom_users', function (Blueprint $table) {
                    $table->dropColumn('password');
                });
            }
        }
    }
};
