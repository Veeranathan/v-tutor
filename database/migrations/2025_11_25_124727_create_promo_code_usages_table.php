<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promo_code_usages', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('promo_code_id');
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('student_id');
             $table->unsignedBigInteger('tutor_id');

            // When promo was applied
            $table->dateTime('used_at')->nullable();

            // booked = trial or paid promo successfully completed
            // incomplete = applied but payment not completed (not for trial)
            $table->enum('status', ['booked', 'incomplete'])->default('booked');

            $table->timestamps();
            $table->unique(['promo_code_id', 'student_id', 'tutor_id'], 'unique_promo_usage');
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('promo_code_usages');
    }
};