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
        Schema::table('assessment_suggestions', function (Blueprint $table) {
         $table->dropColumn('recommended_learning_pathway');
         $table->json('primary_learning_recommendation')->nullable();
         $table->json('secondary_learning_recommendation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_suggestions', function (Blueprint $table) {
            //
        });
    }
};
