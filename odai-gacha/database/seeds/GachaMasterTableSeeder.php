<?php

use Illuminate\Database\Seeder;

class GachaMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gacha_master')->insert([
            'gacha_name' => 'シンクロナイズドシンキング',
            'user_id' => 1,
        ]);
    }
}
