<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->longText('post_content')->change();
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->text('post_content')->change();
        });
    }
};
