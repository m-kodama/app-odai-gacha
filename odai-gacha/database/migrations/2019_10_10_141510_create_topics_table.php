<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->bigIncrements('topic_id');
            $table->bigInteger('gacha_id')->unsigned();
            $table->foreign('gacha_id')->references('gacha_id')->on('gacha_master');
            $table->string('topic', 100);
            $table->bigInteger('rarity_id')->unsigned();
            $table->foreign('rarity_id')->references('rarity_id')->on('rarity');
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
        Schema::dropIfExists('topics');
    }
}
