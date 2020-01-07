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
            [
                'gacha_id' => 1,
                'topic' => '好きな飲み物',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '苦手な食べ物',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きなお笑い芸人',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きな動物',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きな店',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => 'これだけはゆずれないこだわり',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '最近イラついたこと',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '最近楽しかったこと',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '最近買ったもの',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '最近欲しいもの',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '今、外国に行くならどこに行く？',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => 'お酒で酔うとどうなる？',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '休日は何してる？',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => 'もしも100万円あったら？',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きなスポーツ',
                'rarity_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きな映画',
                'rarity_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
           [
                'gacha_id' => 1,
                'topic' => '好きな芸能人',
                'rarity_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きな場所',
                'rarity_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きな色',
                'rarity_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => 'お風呂ではどこから洗う',
                'rarity_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => 'ストレス発散法',
                'rarity_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => 'ドラえもんから秘密道具を1つもらえるとしたら何をもらう？',
                'rarity_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '無人島に1つだけ持っていくとしたら？',
                'rarity_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きなアニメ',
                'rarity_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '今、一番行きたいところ',
                'rarity_id' => 2,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きなアルファベット',
                'rarity_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きなファミレス',
                'rarity_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => 'チャームポイント',
                'rarity_id' => 3,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きな仮面ライダー',
                'rarity_id' => 4,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'gacha_id' => 1,
                'topic' => '好きなウルトラマン',
                'rarity_id' => 4,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ]);
    }
}