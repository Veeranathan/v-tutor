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
        Schema::table('academic_program_purchases', function (Blueprint $table) {

            $table->unsignedBigInteger('assigned_tutor_id')
                  ->nullable()
                  ->after('quantity');

            $table->date('start_date')
                  ->nullable()
                  ->after('assigned_tutor_id');

            $table->date('expires_at')
                  ->nullable()
                  ->after('start_date');

            $table->enum('status', ['active', 'expired', 'cancelled'])
                  ->default('active')
                  ->after('expires_at');

            $table->foreign('assigned_tutor_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academic_program_purchases', function (Blueprint $table) {

            $table->dropForeign(['assigned_tutor_id']);

            $table->dropColumn([
                'assigned_tutor_id',
                'start_date',
                'expires_at',
                'status'
            ]);
        });
    }
};
