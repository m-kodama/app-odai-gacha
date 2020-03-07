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
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X01',
                'probability' => 500,
                'gacha_id' => '01E02KJWM2PHQT336EEP065X4N',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_id' => '01E02KJWM2PHQT336EEP065X4P',
                'rarity' => 1,
                'rarity_name' => 'シルバー',
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X02',
                'probability' => 350,
                'gacha_id' => '01E02KJWM2PHQT336EEP065X4N',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_id' => '01E02KJWM2PHQT336EEP065X4Q',
                'rarity' => 2,
                'rarity_name' => 'ゴールド',
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X03',
                'probability' => 130,
                'gacha_id' => '01E02KJWM2PHQT336EEP065X4N',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_id' => '01E02KJWM2PHQT336EEP065X4R',
                'rarity' => 3,
                'rarity_name' => 'プラチナ',
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X04',
                'probability' => 20,
                'gacha_id' => '01E02KJWM2PHQT336EEP065X4N',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]
        ]);
    }
}
