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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->double('discount', 5, 2)->comment('Discount percentage');
            $table->string('discount_code', 10)
                  ->unique()
                  ->comment('Unique discount code, 6–10 characters');
            $table->text('promotion_hd')->comment('Promotion heading');
            $table->longText('promotion_sub_hd')->comment('Promotion sub heading');
            $table->boolean('status')->default(1)->comment('1 = active, 0 = inactive');
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
        Schema::dropIfExists('promotions');
    }
};
