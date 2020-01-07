<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GachaController extends Controller
{
    public function index() {
        $gachaId = 1;   // TODO 一旦ガチャIDは固定
        $topics = DB::table('gacha_master')
            ->select(DB::raw('gacha_master.gacha_name, topics.topic, rarity.rarity, rarity.probability'))
            ->join('topics', 'topics.gacha_id', '=', 'gacha_master.gacha_id')
            ->join('rarity', 'rarity.rarity_id', '=', 'topics.rarity_id')
            ->where('gacha_master.gacha_id', $gachaId)// TODO 大丈夫？SQLインジェクション？
            ->orderBy('gacha_master.gacha_id', 'asc')
            ->orderBy('rarity', 'desc')
            ->get();
        info($topics);

        $odai = array();
        foreach($topics as $topic) {
            if(!isset($odai[$topic->rarity])) {
                $odai[$topic->rarity] = [];
            }
            if(!isset($odai[$topic->rarity]['texts'])) {
                $odai[$topic->rarity]['rarity'] = $topic->rarity;
                $odai[$topic->rarity]['prob'] = $topic->probability;
                $odai[$topic->rarity]['texts'] = [];
            }

            $odai[$topic->rarity]['texts'][] = $topic->topic;
        }
        return view('gacha/index', compact('odai'));
    }
}

/*
[{"gacha_id":1,"gacha_name":"シンクロナイズドシンキング","topic":"最近イラついたこと","rarity":0,"probability":500},.....] 


$odai = array(
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
)
*/