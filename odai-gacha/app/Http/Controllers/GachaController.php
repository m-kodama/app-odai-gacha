<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GachaController extends Controller
{
    public function index() {
        
        $gacha_master = DB::table('gacha_master')
            ->select(DB::raw('gacha_master.gacha_id, gacha_master.gacha_name, topics.topic_id, topics.topic, rarity.rarity_id, rarity.rarity, rarity.probability'))
            ->join('topics', 'topics.gacha_id', '=', 'gacha_master.gacha_id')
            ->join('rarity', 'rarity.rarity_id', '=', 'topics.rarity_id')
            ->orderBy('gacha_master.gacha_id', 'asc')
            ->orderBy('rarity', 'asc')
            ->get();
            info($gacha_master);
        return view('gacha/index', compact('odai'));
    }

}