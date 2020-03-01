<?php

namespace App\Services;

use Ulid\Ulid;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\Gacha;
use App\Models\Topic;
use App\Models\Rarity;
use App\Http\Requests\GachaRequest;

class GachaService
{
    const AUTH_USE = 'use';
    const AUTH_EDIT = 'edit';
    const AUTH_DELETE = 'delete';

    public function getGacha(string $gachaId)
    {
        return Gacha::find($gachaId);
    }

    public function getGachaList(?string $searchWord)
    {
        return $searchWord
            ? Gacha::where('gacha_name', 'like', "%$searchWord%")
                ->orWhere('description', 'like', "%$searchWord%")
                ->list()
                ->orderBy(Gacha::UPDATED_AT, 'desc')
                ->get()
            : Gacha::list()
                ->orderBy(Gacha::UPDATED_AT, 'desc')
                ->get();
    }

    public function getGachaDetail(string $gachaId)
    {
        $topics = DB::table('gacha_master')
            ->select(DB::raw('gacha_master.gacha_name, topics.topic, rarity.rarity, rarity.probability'))
            ->join('topics', 'topics.gacha_id', '=', 'gacha_master.gacha_id')
            ->join('rarity', 'rarity.rarity_id', '=', 'topics.rarity_id')
            ->where('gacha_master.gacha_id', $gachaId)
            ->orderBy('gacha_master.gacha_id', 'asc')
            ->orderBy('rarity', 'desc')
            ->get();

        $odai = array();
        foreach ($topics as $topic) {
            if (!isset($odai[$topic->rarity])) {
                $odai[$topic->rarity] = [];
            }
            if (!isset($odai[$topic->rarity]['texts'])) {
                $odai[$topic->rarity]['rarity'] = $topic->rarity;
                $odai[$topic->rarity]['prob'] = $topic->probability;
                $odai[$topic->rarity]['texts'] = [];
            }

            $odai[$topic->rarity]['texts'][] = $topic->topic;
        }

        return $odai;
    }

    public function createGacha(GachaRequest $request)
    {
        $gachaId = null;
        DB::beginTransaction();
        try {
            // ガチャマスタ
            $gacha = new Gacha();
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
            foreach ($request['rarity'] as $rarity) {
                $rarity_id = Ulid::generate();
                $rarity_id_map[$rarity['rarity']] = $rarity_id;
                $rarity_params[] = [
                    'rarity_id' => $rarity_id,
                    'rarity' => $rarity['rarity'],
                    'rarity_name' => $rarity['rarityName'],
                    'probability' => $rarity['probability'] * 10,
                    'gacha_id' => $gacha->gacha_id,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }
            DB::table('rarity')->insert($rarity_params);
            // トピック
            $topic_params = [];
            foreach ($request['topics'] as $topic) {
                $topic_id = Ulid::generate();
                $topic_params[] = [
                    'topic_id' => $topic_id,
                    'topic' => $topic['topic'],
                    'gacha_id' => $gacha->gacha_id,
                    'rarity_id' => $rarity_id_map[$topic['rarity']],
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }
            DB::table('topics')->insert($topic_params);
            $gachaId = $gacha->gacha_id;
        } catch (Exception $e) {
            DB::rollback();
            return null;
        }
        DB::commit();
        return $gachaId;
    }

    public function updateGacha(GachaRequest $request, Gacha $gacha)
    {
        $gachaId = null;
        DB::beginTransaction();
        try {
            // ガチャマスタ
            $gacha->gacha_name = $request['gacha']['gachaName'];
            $gacha->description = $request['gacha']['description'];
            $gacha->needUsePass = $request['gacha']['needUsePass'];
            $gacha->needEditPass = $request['gacha']['needEditPass'];
            $gacha->needDeletePass = $request['gacha']['needDeletePass'];
            if (!is_null($request['gacha']['password']) && $request['gacha']['password'] !== "") {
                $gacha->password = bcrypt($request['gacha']['password']);
            } else {
                $gacha->password = null;
            }
            $gacha->save();
            // 現在時刻
            $now = Carbon::now();
            // レア度
            $rarity_id_map = [];
            foreach ($request['rarity'] as $rarity) {
                $rarity_id = $rarity['rarityId'] ?? Ulid::generate();
                $rarity_id_map[$rarity['rarity']] = $rarity_id;
                $params = [
                    'rarity' => $rarity['rarity'],
                    'rarity_name' => $rarity['rarityName'],
                    'probability' => $rarity['probability'] * 10,
                    'gacha_id' => $gacha->gacha_id,
                    'updated_at' => $now
                ];
                DB::table('rarity')->updateOrInsert(['rarity_id' => $rarity_id], $params);
            }
            // トピック
            foreach ($request['topics'] as $topic) {
                $topic_id = $topic['topicId'] ?? Ulid::generate();
                $params = [
                    'topic' => $topic['topic'],
                    'gacha_id' => $gacha->gacha_id,
                    'rarity_id' => $rarity_id_map[$topic['rarity']],
                    'updated_at' => $now
                ];
                if (!isset($topic['topicId'])) {
                    $params['created_at'] = $now;
                }
                DB::table('topics')->updateOrInsert(['topic_id' => $topic_id], $params);
            }
            foreach ($request['removedTopics'] as $topic) {
                Topic::where('topic_id', '=', $topic['topicId'])->delete();
            }
            $gachaId = $gacha->gacha_id;
        } catch (Exception $e) {
            DB::rollback();
            return null;
        }
        DB::commit();
        return $gachaId;
    }

    public function deleteGacha(Gacha $gacha)
    {
        DB::beginTransaction();
        try {
            Topic::where('gacha_id', '=', $gacha->gacha_id)->delete();
            Rarity::where('gacha_id', '=', $gacha->gacha_id)->delete();
            $gacha->delete();
        } catch (Exception $e) {
            DB::rollback();
            return null;
        }
        DB::commit();
        return true;
    }

    public function auth(Request $request, Gacha $gacha)
    {
        $authedGacha = $request->session()->get('authedGacha', function () {
            return array(
                'use' => array(),
                'edit' => array(),
                'delete' => array()
            );
        });

        if (Hash::check($request->password, $gacha->password)) {
            $type = null;
            switch ($request->type) {
                case 0:
                    $type = self::AUTH_USE;
                    break;
                case 1:
                    $type = self::AUTH_EDIT;
                    break;
                case 2:
                    $type = self::AUTH_DELETE;
                    break;
                default:
                    break;
            }
            if (is_null($type)) {
                return false;
            }
            array_push($authedGacha[$type], $gacha->gacha_id);
            $request->session()->put('authedGacha', $authedGacha);
            return true;
        }
        return false;
    }

    public function isAuthenticated(Gacha $gacha, string $type, Request $request)
    {
        if (strcmp($type, self::AUTH_USE) == 0 && !$gacha->needUsePass) {
            return true;
        }
        if (strcmp($type, self::AUTH_EDIT) == 0 && !$gacha->needEditPass) {
            return true;
        }
        if (strcmp($type, self::AUTH_DELETE) == 0 && !$gacha->needDeletePass) {
            return true;
        }

        $authedGacha = $request->session()->get('authedGacha', function () {
            return null;
        });
        if (empty($authedGacha)) {
            return false;
        }
        if (in_array($gacha->gacha_id, $authedGacha[$type])) {
            return true;
        }
        return false;
    }
}

?>
