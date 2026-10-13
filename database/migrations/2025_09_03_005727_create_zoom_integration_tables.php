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
        // 2025_09_02_000001_create_zoom_users_table.php
        Schema::create('zoom_users', function (Blueprint $t) {
            $t->id();
            $t->unsignedBigInteger('tutor_id')->index();       // link to your tutors table
            $t->string('zoom_user_id')->index();               // Zoom "id"
            $t->string('email')->index();
            $t->string('password');
            $t->string('pmi')->nullable();
            $t->string('status')->default('active');           // active|inactive
            $t->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zoom_integration_tables');
    }
};
