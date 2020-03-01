<?php

use Illuminate\Database\Seeder;
use Ulid\Ulid;

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
                'rarity_id' => '01E02KJWM2PHQT336EEP065X4O',
                'rarity' => 0,
                'rarity_name' => 'ノーマル',
                'probability' => 500,
                'gacha_id' => '01E02KJWM2PHQT336EEP065X4N',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_id' => '01E02KJWM2PHQT336EEP065X4P',
                'rarity' => 1,
                'rarity_name' => 'シルバー',
                'probability' => 350,
                'gacha_id' => '01E02KJWM2PHQT336EEP065X4N',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_id' => '01E02KJWM2PHQT336EEP065X4Q',
                'rarity' => 2,
                'rarity_name' => 'ゴールド',
                'probability' => 130,
                'gacha_id' => '01E02KJWM2PHQT336EEP065X4N',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_id' => '01E02KJWM2PHQT336EEP065X4R',
                'rarity' => 3,
                'gacha_id' => '01E02KJWM2PHQT336EEP065X4N',
                'rarity_name' => 'プラチナ',
                'probability' => 20,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]
        ]);
    }
}
