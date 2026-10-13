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
    Schema::create('zoho_tokens', function (Blueprint $table) {
        $table->id();
        $table->string('access_token', 2048);
        $table->string('refresh_token', 2048)->nullable();
        $table->timestamp('expires_at')->nullable();
        // If you plan multi-tenant/multi-user, add user_id/org_id columns here
        $table->timestamps();
    });
}
public function down(): void
{
    Schema::dropIfExists('zoho_tokens');
}

};
