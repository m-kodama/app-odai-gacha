<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRarityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rarity', function (Blueprint $table) {
            $table->char('rarity_id', 26);
            $table->primary('rarity_id');
            $table->unsignedTinyInteger('rarity');
            $table->integer('probability');
            $table->string('rarity_name');
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
        Schema::dropIfExists('rarity');
    }
}
