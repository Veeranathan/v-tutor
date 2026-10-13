<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::statement('ALTER TABLE schools MODIFY postcode VARCHAR(6) NULL');
        DB::statement('ALTER TABLE schools MODIFY suburb_id VARCHAR(200) NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         DB::statement('ALTER TABLE schools MODIFY postcode VARCHAR(6) NOT NULL');
        DB::statement('ALTER TABLE schools MODIFY suburb_id INT NOT NULL');
        
    }
};
