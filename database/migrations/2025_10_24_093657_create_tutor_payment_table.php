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
         Schema::create('tutor_payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tutor_id');
            $table->unsignedBigInteger('booking_id');
            $table->double('tutor_amount', 10, 2)->default(0.00);
            $table->double('commission_amount', 10, 2)->default(0.00);
            $table->tinyInteger('booking_status')
                  ->default(1)
                  ->comment('1 = booked, 2 = cancel');
            $table->tinyInteger('payment_status')
                  ->default(0)
                  ->comment('0 = not paid, 1 = paid, 2 = refund, 3 = settled');
            $table->timestamps();

            // Optional: add indexes or foreign keys if applicable
            $table->index('tutor_id');
            $table->index('booking_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutor_payment');
    }
};
