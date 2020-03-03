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
        $search_word = $request->input('q', false);
        $gachas = $this->gacha_service->getGachaList($search_word);
        return view('gacha/index', compact('gachas'));
    }

    public function getMachine(Request $request, $gacha_id)
    {
        $gacha = $this->gacha_service->getGacha($gacha_id);
        if (empty($gacha)) {
            abort(404);
        }
        if (!$this->gacha_service->isAuthenticated($gacha, GachaService::AUTH_USE, $request)) {
            abort(404);
        }
        $odai = $this->gacha_service->getGachaDetail($gacha_id);
        if (empty($odai)) {
            abort(404);
        }
        return view('gacha/machine', compact('odai'));
    }

    public function createGachaDetail(GachaRequest $request)
    {
        $gacha_id = $this->gacha_service->createGacha($request);
        if (empty($gacha_id)) {
            return back()->withInput();
            abort(400);
        }
        return $gacha_id;
    }

    public function updateGacha(GachaRequest $request, $gacha_id)
    {
        $gacha = $this->gacha_service->getGacha($gacha_id);
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

    public function deleteGacha(Request $request, $gacha_id)
    {
        $gacha = $this->gacha_service->getGacha($gacha_id);
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

    public function edit(Request $request, $gacha_id)
    {
        $gacha = $this->gacha_service->getGacha($gacha_id);
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

    public function auth(Request $request, $gacha_id)
    {
        $gacha = $this->gacha_service->getGacha($gacha_id);
        if (empty($gacha)) {
            abort(404);
        }
        if ($this->gacha_service->auth($request, $gacha)) {
            return $gacha_id;
        }
        abort(400);
    }
}
