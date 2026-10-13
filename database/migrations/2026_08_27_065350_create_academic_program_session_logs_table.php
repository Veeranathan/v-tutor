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

            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('tutor_id')->nullable();

            $table->string('action'); 
            $table->unsignedBigInteger('action_by')->nullable(); 
            $table->dateTime('action_at')->useCurrent();

            $table->dateTime('scheduled_date')->nullable(); 
            $table->dateTime('start_time')->nullable(); 
            $table->dateTime('end_time')->nullable(); 

            $table->text('reason')->nullable();
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('academic_program_sessions')->onDelete('cascade');
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('action_by')->references('id')->on('users')->onDelete('set null');
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
