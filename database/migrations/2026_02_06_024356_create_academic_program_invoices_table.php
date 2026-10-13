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
        Schema::create('academic_program_invoices', function (Blueprint $table) {
            $table->id();
            // Relations
            $table->unsignedBigInteger('user_id');
            // Business identifiers
            $table->string('order_id');            
            $table->string('invoice_number')->unique(); 
            // Stripe reference
            $table->string('stripe_session_id')->nullable();
            // Amount snapshot
            $table->decimal('sub_total', 10, 2);
            $table->decimal('gst_percent', 5, 2)->default(10.00);
            $table->decimal('gst_amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            // Status
            $table->string('payment_status')->default('paid');
            // paid | partial | refunded | cancelled
            $table->timestamps();
            // Indexes
            $table->index('order_id');
            $table->index('stripe_session_id');
            // Foreign key
            $table->foreign('user_id', 'fk_invoice_user')
                ->references('id')->on('users')
                ->onDelete('cascade');
            });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_program_invoices');
    }
};
