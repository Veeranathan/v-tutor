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
        Schema::create('academic_programs', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code')->unique();

            $table->string('subject');
            $table->year('year')->nullable();

            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();

            $table->string('document')->nullable(); // PDF / brochure
            $table->longText('description')->nullable();

            $table->integer('validity')->comment('Validity in days')->nullable();

            $table->json('display_for'); // tutor | student | website

            $table->boolean('popular')->default(false);
            $table->boolean('status')->default(true);

            $table->integer('display_order')->default(0);

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
        Schema::dropIfExists('academic_programs');
    }
};
