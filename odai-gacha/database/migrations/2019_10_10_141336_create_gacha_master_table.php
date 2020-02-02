<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGachaMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gacha_master', function (Blueprint $table) {
            $table->char('gacha_id', 26);
            $table->primary('gacha_id');
            $table->string('gacha_name', 50);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('password')->nullable();
            $table->boolean('needUsePass')->default(false);
            $table->boolean('needEditPass')->default(false);
            $table->boolean('needDeletePass')->default(false);
            $table->string('image_path')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('gacha_master');
    }
}