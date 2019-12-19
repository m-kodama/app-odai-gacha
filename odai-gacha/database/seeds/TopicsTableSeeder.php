<?php

use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('topics')->insert([
            'gacha_id' => 1,
            'topic' => '',
            'password' => bcrypt('admin1234'),  //TODO: 今はいい　あとで変更
        ]);
    }
}
