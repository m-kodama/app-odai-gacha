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
    protected $gacha_service;

    public function __construct(GachaService $gacha_service)
    {
        $this->gacha_service = $gacha_service;
    }

    // ガチャ一覧
    public function index(Request $request)
    {
        $searchWord = $request->input('q', false);
        $gachas = $this->gacha_service->getGachaList($searchWord);
        return view('gacha/index', compact('gachas'));
    }

    public function getMachine(Request $request, $gachaId)
    {
        $gacha = $this->gacha_service->getGacha($gachaId);
        if (empty($gacha)) {
            abort(404);
        }
        if (!$this->gacha_service->isAuthenticated($gacha, GachaService::AUTH_USE, $request)) {
            abort(404);
        }
        $odai = $this->gacha_service->getGachaDetail($gachaId);
        if (empty($odai)) {
            abort(404);
        }
        return view('gacha/machine', compact('odai'));
    }

    public function createGachaDetail(GachaRequest $request)
    {
        $gachaId = $this->gacha_service->createGacha($request);
        if (empty($gachaId)) {
            return back()->withInput();
            abort(400);
        }
        return $gacha_id;
    }

    public function updateGacha(GachaRequest $request, $gachaId)
    {
        $gacha = $this->gacha_service->getGacha($gachaId);
        if (empty($gacha)) {
            abort(404);
        }
        if (!$this->gacha_service->isAuthenticated($gacha, GachaService::AUTH_EDIT, $request)) {
            abort(404);
        }
        $updatedGachaId = $this->gacha_service->updateGacha($request, $gacha);
        if (empty($updatedGachaId)) {
            return back()->withInput();
            abort(400);
        }
        return $updatedGachaId;
    }

    public function deleteGacha(Request $request, $gachaId)
    {
        $gacha = $this->gacha_service->getGacha($gachaId);
        if (empty($gacha)) {
            abort(404);
        }
        if (!$this->gacha_service->isAuthenticated($gacha, GachaService::AUTH_DELETE, $request)) {
            abort(404);
        }
        if ($this->gacha_service->deleteGacha($gacha)) {
            return 'success';
        }
        return back()->withInput();
        abort(400);
    }

    public function create()
    {
        return view('gacha/edit');
    }

    public function edit(Request $request, $gachaId)
    {
        $gacha = $this->gacha_service->getGacha($gachaId);
        if (empty($gacha)) {
            abort(404);
        }
        if (!$this->gacha_service->isAuthenticated($gacha, GachaService::AUTH_EDIT, $request)) {
            abort(404);
        }
        $rarity = $gacha->rarity()->get();
        $topics = $gacha->topics()->get();
        return view('gacha/edit', compact('gacha', 'rarity', 'topics'));
    }

    public function auth(Request $request, $gachaId)
    {
        $gacha = $this->gacha_service->getGacha($gachaId);
        if (empty($gacha)) {
            abort(404);
        }
        if ($this->gacha_service->auth($request, $gacha)) {
            return $gachaId;
        }
        abort(400);
    }
}
