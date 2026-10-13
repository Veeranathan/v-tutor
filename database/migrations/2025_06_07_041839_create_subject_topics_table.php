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
        Schema::create('subject_topics', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('grade_id');
            $table->string('slug')->unique();
            $table->text('topics')->nullable(); // assuming topics are stored as text
            $table->string('capture_code')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('subject_topics');
    }
};
