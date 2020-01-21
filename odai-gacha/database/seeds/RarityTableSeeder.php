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
                'rarity_name' => 'ノーマル',
                'probability' => 500,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'rarity' => 1,
                'rarity_name' => 'シルバー',
                'probability' => 350,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'rarity' => 2,
                'rarity_name' => 'ゴールド',
                'probability' => 130,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'rarity' => 3,
                'rarity_name' => 'プラチナ',
                'probability' => 20,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);
    }
}
