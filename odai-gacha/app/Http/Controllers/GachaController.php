<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

use App\Gacha;

class GachaController extends Controller
{
    public function index(Request $request) {//一覧
        // TODO 一時的にセッションリセットをいれる
        // $request->session()->flush();
        $gachas = Gacha::all();
        return view('gacha/index', compact('gachas'));
    }

    public function getMachine(Request $request, $gachaId) {
        $gacha = Gacha::findOrFail($gachaId);
        if ($gacha->needUsePass){
            $authedGacha = $request->session()->get('authedGacha', function(){
                abort(404);
            });
            if (!in_array($gachaId ,$authedGacha['use'])){
                abort(404);
            }
        }

        $topics = DB::table('gacha_master')
            ->select(DB::raw('gacha_master.gacha_name, topics.topic, rarity.rarity, rarity.probability'))
            ->join('topics', 'topics.gacha_id', '=', 'gacha_master.gacha_id')
            ->join('rarity', 'rarity.rarity_id', '=', 'topics.rarity_id')
            ->where('gacha_master.gacha_id', $gachaId)// TODO 大丈夫？SQLインジェクション？
            ->orderBy('gacha_master.gacha_id', 'asc')
            ->orderBy('rarity', 'desc')
            ->get();

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
        return view('gacha/machine', compact('odai'));
    }

    public function createGachaDetail(Request $request) {
        $gacha = new Gacha();
        $gacha->gacha_name = $request->gacha_name;
        $gacha->user_id = 1;
        $gacha->save();

        return redirect("/gacha");
    }

    public function updateGacha(Request $request, $gachaId) {
        $gacha = Gacha::findOrFail($gachaId);
        // TODO パスワードチェック
        $gacha->gacha_name = $request->gacha_name;
        $gacha->save();
        
        return redirect("/gacha");
    }

    public function deleteGacha($gachaId) {
        $gacha = Gacha::findOrFail($gachaId);
        // TODO パスワードチェック
        $gacha->delete();
        
        return redirect("/gacha");
    }

    public function create() {
        return view('gacha/edit');
    }
    
    public function edit($gachaId) {
        $gacha = Gacha::findOrFail($gachaId);
        return view('gacha/edit', compact('gacha'));
    }

    public function auth(Request $request, $gachaId) {
        $gacha = Gacha::findOrFail($gachaId);

        $authedGacha = $request->session()->get('authedGacha', function(){
            return array(
                'use' => array(),
                'edit' => array(),
                'delete' => array()
            );
        });

        if(Hash::check($request->password, $gacha->password)){
            array_push($authedGacha['use'], $gachaId);
            $request->session()->put('authedGacha', $authedGacha);
            return $gacha->gacha_id;
        }
        return false;
    }

}

/*
http://localhost:3000/gacha/01E02KJWM2PHQT336EEP065X4N/machine

Undefined variable: gacha_id {"exception":"[object] (ErrorException(code: 0): Undefined variable: gacha_id at /var/www/html/odai-gacha/app/Http/Controllers/GachaController.php:107)
[stacktrace]

Trying to get property 'use' of non-object {"exception":"[object] (ErrorException(code: 0): Trying to get property 'use' of non-object at /var/www/html/odai-gacha/app/Http/Controllers/GachaController.php:26)
[stacktrace]

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