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
   public function up(): void
{
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('subject');
        $table->text('message');
        $table->string('zoho_ticket_id')->nullable(); // link to Zoho Desk ticket
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('messages');
}
};
