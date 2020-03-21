<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRirityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rarity', function (Blueprint $table) {
            $table
                ->char('rarity_image_id')
                ->foreign('rarity_image_id')
                ->references('rarity_image_id')
                ->on('rarity_images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rarity', function (Blueprint $table) {
            $table->dropColumn('rarity_image_id');
        });
    }
}
