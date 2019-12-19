<?php

use Illuminate\Database\Seeder;

class RarityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rarity')->insert([
            [
                'rarity' => 0,
                'probability' => 500,
            ],
            [
                'rarity' => 1,
                'probability' => 350,
            ],
            [
                'rarity' => 2,
                'probability' => 130,
            ],
            [
                'rarity' => 3,
                'probability' => 20,
            ]
        ]);
    }
}
