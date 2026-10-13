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
        Schema::create('academic_program_session_logs', function (Blueprint $table) {

            $table->id();

            $table->foreignId('session_id')
                  ->constrained('academic_program_sessions')
                  ->cascadeOnDelete();

            $table->enum('action', [
                'cancelled',
                'rescheduled',
                'tutor_changed'
            ]);

            $table->dateTime('old_scheduled_at')->nullable();
            $table->dateTime('new_scheduled_at')->nullable();

            $table->foreignId('old_tutor_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('new_tutor_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->enum('action_by', [
                'student',
                'tutor',
                'admin'
            ]);

            $table->text('reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_program_session_logs');
    }
};
