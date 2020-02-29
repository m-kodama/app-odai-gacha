<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

use App\Services\GachaService;
use App\Models\Gacha;
use App\Models\Topic;
use App\Models\Rarity;
use App\Http\Requests\GachaRequest;

class GachaController extends Controller
{
    protected $gachaService;

    public function __construct(GachaService $gachaService)
    {
        $this->gachaService = $gachaService;
    }

    // ガチャ一覧
    public function index(Request $request)
    {
        $searchWord = $request->input('q', false);
        $gachas = $this->gachaService->getGachaList($searchWord);
        return view('gacha/index', compact('gachas'));
    }

    public function getMachine(Request $request, $gachaId)
    {
        $gacha = $this->gachaService->getGacha($gachaId);
        if (empty($gacha)) {
            abort(404);
        }
        if (!$this->gachaService->isAuthenticated($gacha, GachaService::AUTH_USE, $request)) {
            abort(404);
        }
        $odai = $this->gachaService->getGachaDetail($gachaId);
        if (empty($odai)) {
            abort(404);
        }
        return view('gacha/machine', compact('odai'));
    }

    public function createGachaDetail(GachaRequest $request) {
        $gachaId = $this->gachaService->createGacha($request);
        if(empty($gachaId)) {
            return back()->withInput();
            abort(400);
        }
        return $gacha_id;
    }

    public function updateGacha(GachaRequest $request, $gachaId) {
        $gacha = $this->gachaService->getGacha($gachaId);
        if (empty($gacha)) {
            abort(404);
        }
        if (!$this->gachaService->isAuthenticated($gacha, GachaService::AUTH_EDIT, $request)) {
            abort(404);
        }
        $updatedGachaId = $this->gachaService->updateGacha($request, $gacha);
        if(empty($updatedGachaId)) {
            return back()->withInput();
            abort(400);
        }
        return $updatedGachaId;
    }

    public function deleteGacha(Request $request, $gachaId) {
        $gacha = $this->gachaService->getGacha($gachaId);
        if (empty($gacha)) {
            abort(404);
        }
        if (!$this->gachaService->isAuthenticated($gacha, GachaService::AUTH_DELETE, $request)) {
            abort(404);
        }
        if ($this->gachaService->deleteGacha($gacha)) {
            return 'success';
        }
        return back()->withInput();
        abort(400);
    }

    public function create() {
        return view('gacha/edit');
    }

    public function edit(Request $request, $gachaId) {
        $gacha = $this->gachaService->getGacha($gachaId);
        if (empty($gacha)) {
            abort(404);
        }
        if (!$this->gachaService->isAuthenticated($gacha, GachaService::AUTH_EDIT, $request)) {
            abort(404);
        }
        $rarity = $gacha->rarity()->get();
        $topics = $gacha->topics()->get();
        return view('gacha/edit', compact('gacha', 'rarity', 'topics'));
    }

    public function auth(Request $request, $gachaId) {
        $gacha = $this->gachaService->getGacha($gachaId);
        if (empty($gacha)) {
            abort(404);
        }
        if ($this->gachaService->auth($request, $gacha)) {
            return $gachaId;
        }
        abort(400);
    }

}