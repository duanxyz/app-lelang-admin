<?php

namespace App\Http\Controllers;

use App\Http\Resources\BalanceHistoryResource;
use App\Laravue\Models\Balance_history;
use App\Laravue\Models\Deposit_info;
use App\Laravue\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BalanceHistoryController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $balanceQuery = Balance_history::query();
        $limit = Arr::get($params, 'limit', '');
        $byId = Arr::get($params, 'id', '');
        if ((!empty($byId))) {
            $balanceQuery->where('wallet_id', $byId);
        }
        $balanceQuery->orderBy('updated_at', 'desc');
        //$limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        return BalanceHistoryResource::collection($balanceQuery->paginate($limit));
    }
}
