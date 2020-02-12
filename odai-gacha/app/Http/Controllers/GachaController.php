<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

use App\Models\Gacha;
use App\Models\Topic;
use App\Models\Rarity;
use App\Http\Requests\GachaRequest;
use Ulid\Ulid;
use Carbon\Carbon;

// TODO 当初の想定よりもロジックが多くなってしまったため、Modelクラスに処理を分ける
class GachaController extends Controller
{
    public function index(Request $request) {//一覧
        $searchWord = $request->input('q', false);
        $gachas = $searchWord
            ? Gacha::where('gacha_name', 'like', "%$searchWord%")
                ->orWhere('description', 'like', "%$searchWord%")
                ->list()
                ->orderBy(Gacha::UPDATED_AT, 'desc')
                ->get()
            : Gacha::list()->orderBy(Gacha::UPDATED_AT, 'desc')->get();
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
            ->where('gacha_master.gacha_id', $gachaId)
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

    public function createGachaDetail(GachaRequest $request) {
        DB::beginTransaction();
        try{
            // ガチャマスタ
            $gacha_id = Ulid::generate();
            $gacha = new Gacha();
            $gacha->gacha_id = $gacha_id;
            $gacha->gacha_name = $request['gacha']['gachaName'];
            $gacha->description = $request['gacha']['description'];
            $gacha->needUsePass = $request['gacha']['needUsePass'];
            $gacha->needEditPass = $request['gacha']['needEditPass'];
            $gacha->needDeletePass = $request['gacha']['needDeletePass'];
            if (!is_null($request['gacha']['password']) && $request['gacha']['password'] !== "") {
                $gacha->password = bcrypt($request['gacha']['password']);
            }
            $gacha->user_id = 1;
            $gacha->save();
            // 現在時刻
            $now = Carbon::now();
            // レア度
            $rarity_id_map = [];
            $rarity_params = [];
            foreach($request['rarity'] as $rarity) {
                $rarity_id = Ulid::generate();
                $rarity_id_map[$rarity['rarity']] = $rarity_id;
                $rarity_params[] = [
                    'rarity_id' => $rarity_id,
                    'rarity' => $rarity['rarity'],
                    'rarity_name' => $rarity['rarityName'],
                    'probability' => $rarity['probability'] * 10,
                    'gacha_id' => $gacha_id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('rarity')->insert($rarity_params);
            // トピック
            $topic_params = [];
            foreach($request['topics'] as $topic) {
                $topic_id = Ulid::generate();
                $topic_params[] = [
                    'topic_id' => $topic_id,
                    'topic' => $topic['topic'],
                    'gacha_id' => $gacha_id,
                    'rarity_id' => $rarity_id_map[$topic['rarity']],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('topics')->insert($topic_params);
        }catch(Exception $e){
            DB::rollback();
            return back()->withInput();
            abort(400);
        }
        DB::commit();
        return $gacha_id;
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

    public function edit(Request $request, $gachaId) {
        $_gacha = Gacha::findOrFail($gachaId);
        if ($_gacha->needEditPass){
            $authedGacha = $request->session()->get('authedGacha', function(){
                abort(404);
            });
            if (!in_array($gachaId ,$authedGacha['edit'])){
                abort(404);
            }
        }
        $gacha = $_gacha->list()->get()->first();
        $rarity = $_gacha->rarity()->get();
        $topics = $_gacha->topics()->get();
        return view('gacha/edit', compact('gacha', 'rarity', 'topics'));
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
            $type = null;
            switch ($request->type) {
                case 0:
                    $type = 'use';
                    break;
                case 1:
                    $type = 'edit';
                    break;
                case 2:
                    $type = 'delete';
                    break;
                default:
                    break;
            }
            if (is_null($type)) {
                abort(400);
            }
            array_push($authedGacha[$type], $gachaId);
            $request->session()->put('authedGacha', $authedGacha);
            return $gacha->gacha_id;
        }
        abort(400);
    }

}

/*
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