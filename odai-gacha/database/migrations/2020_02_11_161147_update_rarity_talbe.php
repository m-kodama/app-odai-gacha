<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRarityTalbe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rarity', function (Blueprint $table) {
            $table->char('gacha_id')->foreign('gacha_id')->references('gacha_id')->on('gacha_master');
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
            $table->dropColumn('gacha_id');
        });
    }
}
