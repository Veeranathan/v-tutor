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

        // Create fresh table
        Schema::create('academic_programs', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('grade_id');  
            $table->integer('branch_id');    

            // Program details
            $table->string('name');
            $table->string('code')->unique();

            $table->string('curriculum')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();

            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();

            $table->string('document')->nullable(); // PDF / brochure
            $table->longText('description')->nullable();

            $table->integer('validity')->nullable()->comment('Validity in days');

            $table->json('display_for'); // tutor | student | website

            $table->boolean('popular')->default(false);
            $table->boolean('status')->default(true);

            $table->integer('display_order')->default(0);

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('grade_id', 'fk_ap_grade')
                  ->references('id')->on('grades')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->foreign('branch_id', 'fk_ap_branch')
                  ->references('id')->on('branches')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_program_fresh');
    }
};
