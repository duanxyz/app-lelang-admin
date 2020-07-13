<?php

namespace App\Http\Controllers;

use App\Laravue\Models\Deposit_info;
use App\Laravue\Models\Item;
use App\Laravue\Models\Member;
use App\Laravue\Models\Withdrawal_info;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportingController extends Controller
{
    public function index()
    {
        $user = Member::all();
        $item = Item::all();
        $deposit = Deposit_info::where("status", "approved")->count();
        $withdraw = Withdrawal_info::where("status", "approved")->count();
        $elektronik = Item::where("category", "elektronik")->count();
        $sertifikat = Item::where("category", "sertifikat")->count();
        $perhiasan = Item::where("category", "perhiasan")->count();
        $kendaraan = Item::where("category", "kendaraan")->count();
        $ordersByWeek = Member::select([
            DB::raw('count(id) as data'),
            DB::raw('Month(created_at) as bulan'),
        ])->whereYear('created_at', '2020')->groupBy('bulan')->get();
        $data = [
            'data' => [
                'user' => $user->count(),
                'item' => $item->count(),
                'deposit' => $deposit,
                'withdraw' => $withdraw,
            ],
            'item' => [
                'elektronik' => $elektronik,
                'sertifikat' => $sertifikat,
                'perhiasan' => $perhiasan,
                'kendaraan' => $kendaraan,
            ],
            'bulan' => $ordersByWeek,

        ];

        return response()->json($data);
    }
}
