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
        Schema::create('tutor_skills_capabilities', function (Blueprint $table) {
            $table->id();
          
        $table->unsignedBigInteger('tutor_id');

        $table->foreign('tutor_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

            $table->string('skills');
            $table->text('capabilities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutor_skills_capabilities');
    }
};
