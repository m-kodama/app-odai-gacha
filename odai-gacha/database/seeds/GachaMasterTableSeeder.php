
<?php
use Illuminate\Database\Seeder;
use Ulid\Ulid;

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
            'gacha_id' => '01E02KJWM2PHQT336EEP065X4N',
            'gacha_name' => 'シンクロナイズドシンキング',
            'user_id' => 1,
            'password' => null,
            'needUsePass' => false,
            'needEditPass' => false,
            'needDeletePass' => false,
            'description' => 'アイスブレイクに使えるゲームです。',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
    }
}

