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
       Schema::create('payouts', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('tutor_id');
        $table->string('tutor_unique_id')->nullable();
        $table->date('pay_from');
        $table->date('pay_to');
        
        $table->decimal('gross_pay', 10, 2)->default(0);
        $table->decimal('commission', 10, 2)->default(0);
        $table->decimal('net_pay', 10, 2)->default(0);
        $table->decimal('deductions', 10, 2)->default(0);

        $table->date('payment_date')->nullable();
        $table->enum('payment_status', ['Pending', 'Disbursed'])->default('Pending');

        $table->timestamps();

        $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payouts');
    }
};
