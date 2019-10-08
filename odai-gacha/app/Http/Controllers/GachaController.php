<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GachaController extends Controller
{
    public function index() {
        $odai = array(
            'question' => array(
                array(
                    'rarity' => 3, 
                    'prob' => 20, // 2%
                    'texts' => array(
                        '好きな仮面ライダー', '好きなウルトラマン'
                    )
                ),
                array(
                    'rarity' => 2, 
                    'prob' => 130, // 13% 
                    'texts' => array(
                        '好きなアルファベット', '好きなファミレス', 'チャームポイント'
                    )
                ),
                array(
                    'rarity' => 1, 
                    'prob' => 350, // 35%
                    'texts' => array(
                        '好きな映画',
                        '好きな芸能人',
                        '好きな場所',
                        '好きな色',
                        'お風呂ではどこから洗う',
                        'ストレス発散法',
                        'ドラえもんから秘密道具を1つもらえるとしたら何をもらう？',
                        '無人島に1つだけ持っていくとしたら？',
                        '好きなアニメ',
                        '今、一番行きたいところ'
                    )
                ),
                array(
                    'rarity' => 0, 
                    'prob' => 500, // 50%
                    'texts' => array(
                        '苦手な食べ物',
                        '好きな飲み物',
                        '好きなお笑い芸人',
                        '好きな動物',
                        '好きな店',
                        'これだけはゆずれないこだわり',
                        '最近イラついたこと',
                        '最近楽しかったこと',
                        '最近買ったもの',
                        '最近欲しいもの',
                        '今、外国に行くならどこに行く？',
                        'お酒で酔うとどうなる？',
                        '休日は何してる？',
                        'もしも100万円あったら？',
                        '好きなスポーツ'
                    )
                ),
            ),
            'denpo' => array(
                array(
                    'rarity' => 3, 
                    'prob' => 20, // 2%
                    'texts' => array(
                        '織田信長', '世界平和', '聖徳太子'
                    )
                ),
                array(
                    'rarity' => 2, 
                    'prob' => 130, // 13% 
                    'texts' => array(
                        'モンスト', 'パズドラ', 'iPhone'
                    )
                ),
                array(
                    'rarity' => 1, 
                    'prob' => 350, // 35%
                    'texts' => array(
                        'ハリー・ポッター',
                        'プログラマー',
                        'ONE PIECE（漫画）',
                        '宇宙飛行士',
                        'パイロット',
                        '警察官',
                        'キットカット',
                        'マクドナルド',
                        'ケンタッキー',
                        'サーティーワンアイスクリーム'
                    )
                ),
                array(
                    'rarity' => 0, 
                    'prob' => 500, // 50%
                    'texts' => array(
                        'ドラえもん',
                        '遊園地',
                        'サッカー',
                        '組体操',
                        'スキー',
                        '野球',
                        'となりのトトロ',
                        '天空の城ラピュタ',
                        'ハロウィン',
                        'クリスマス',
                        'ひな祭り',
                        'アンパンマン',
                        '木村拓哉',
                        'お正月',
                        'きのこの山',
                        'たけのこの里',
                        '日本',
                        '台湾',
                        'アメリカ'
                    )
                ),
            ),
        );

        return view('gacha/index', compact('odai'));
    }
}