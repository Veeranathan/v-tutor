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
         if (Schema::hasTable('messages')) {
                Schema::table('messages', function (Blueprint $table) {
                    $table->Text('role')->nullable();
                    $table->Text('number')->nullable();
                    $table->Text('category')->nullable();
                    $table->Text('contact_method')->nullable();
                    $table->Text('best_time')->nullable();
                });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
