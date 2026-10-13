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
        Schema::create('programmes', function (Blueprint $table) {
            $table->id();
            
            $table->string('parent_name');
            $table->string('email')->unique();
            $table->string('student_name');
            $table->string('student_grade');
            $table->string('ref_source');
            $table->boolean('subscribe')->default(0);

            // Store selected programs as JSON
            $table->json('programs');

            // Store if terms were agreed
            $table->boolean('terms_agreed')->default(0);

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
        Schema::dropIfExists('programmes');
    }
};
