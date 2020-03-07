<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(GachaMasterTableSeeder::class);
        $this->call(RarityImagesTableSeeder::class);
        $this->call(RarityTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
    }
}
