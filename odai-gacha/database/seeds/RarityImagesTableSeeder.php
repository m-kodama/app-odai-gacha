<?php

use Illuminate\Database\Seeder;

class RarityImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rarity_images')->insert([
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X01',
                'rarity_image_path' => 'egg_01.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X02',
                'rarity_image_path' => 'egg_02.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X03',
                'rarity_image_path' => 'egg_03.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X04',
                'rarity_image_path' => 'egg_04.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X05',
                'rarity_image_path' => 'egg_05.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X06',
                'rarity_image_path' => 'egg_06.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X07',
                'rarity_image_path' => 'egg_07.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X08',
                'rarity_image_path' => 'egg_08.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X09',
                'rarity_image_path' => 'egg_09.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X10',
                'rarity_image_path' => 'egg_10.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X11',
                'rarity_image_path' => 'egg_11.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'rarity_image_id' => '01E02KJWM2PHQT336MOP065X12',
                'rarity_image_path' => 'egg_12.png',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]
        ]);
    }
}
