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
         Schema::create('academic_program_purchases', function (Blueprint $table) {
            $table->id();

            // IDs (MUST be unsigned)
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('academic_program_id');

            // Payment details
            $table->decimal('amount', 10, 2);
            $table->string('payment_status'); 
            // pending | paid | failed | refunded

            $table->string('stripe_session_id')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id', 'fk_pp_user')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('academic_program_id', 'fk_pp_program')
                  ->references('id')->on('academic_programs')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_program_purchases');
    }
};
