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
        if (Schema::hasTable('tutor_wwcc')) {
            if (!Schema::hasColumn('tutor_wwcc', 'wwcc_doc')) {
                Schema::table('tutor_wwcc', function (Blueprint $table) {
                    $table->text('wwcc_doc')->after('expiry_date')->nullable();
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
        if (Schema::hasTable('tutor_wwcc')) {
            if (Schema::hasColumn('tutor_wwcc', 'wwcc_doc')) {
                Schema::table('tutor_wwcc', function (Blueprint $table) {
                    $table->dropColumn('wwcc_doc');
                });
            }
        }
    }
};
