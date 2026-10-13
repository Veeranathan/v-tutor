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
        Schema::create('topic_details', function (Blueprint $table) {
            $table->increments('id'); // int(11) auto-increment primary key
            $table->unsignedInteger('branch_id');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('topic_id');
            $table->string('topic_det_code', 7);
            $table->string('session_focus', 100);
            $table->string('learning_outcome', 250);
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
        Schema::dropIfExists('topic_details');
    }
};
