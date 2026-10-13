<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recordings', function (Blueprint $table) {
            $table->id();

            $table->integer('booking_id');

            $table->string('session_id')->nullable();
            $table->string('daily_recording_id')->nullable();

            $table->string('file_name')->nullable();

            $table->string('sharepoint_file_id')->nullable();

            $table->string('recording_folder')->nullable();

            $table->text('recording_url')->nullable();

            $table->enum('status', [
                'pending',
                'processing',
                'uploaded',
                'failed'
            ])->default('pending');

            $table->timestamp('recording_started_at')->nullable();
            $table->timestamp('recording_ended_at')->nullable();
            $table->timestamp('uploaded_at')->nullable();

            $table->timestamps();

            $table->foreign('booking_id')
                ->references('id')
                ->on('student_class_bookings')
                ->onDelete('cascade');

            $table->index('booking_id');
            $table->index('session_id');
            $table->index('daily_recording_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recordings');
    }
};