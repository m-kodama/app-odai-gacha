<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@odaigacha',
            'password' => bcrypt('admin1234'),  //TODO: 今はいい　あとで変更
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
