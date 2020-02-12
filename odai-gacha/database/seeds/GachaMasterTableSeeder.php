
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
            'password' => bcrypt('1234'),
            'description' => 'その人の答えは・・・',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
