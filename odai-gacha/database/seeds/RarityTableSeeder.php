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
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'rarity' => 1,
                'probability' => 350,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'rarity' => 2,
                'probability' => 130,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'rarity' => 3,
                'probability' => 20,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        ]);
    }
}
