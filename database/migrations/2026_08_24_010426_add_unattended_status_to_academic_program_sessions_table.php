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
        DB::statement("
            ALTER TABLE academic_program_sessions
            MODIFY status ENUM(
                'pending',
                'scheduled',
                'completed',
                'cancelled',
                'unattended'
            ) NOT NULL DEFAULT 'pending'
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            ALTER TABLE academic_program_sessions
            MODIFY status ENUM(
                'pending',
                'scheduled',
                'completed',
                'cancelled'
            ) NOT NULL DEFAULT 'pending'
        ");

    }
};
