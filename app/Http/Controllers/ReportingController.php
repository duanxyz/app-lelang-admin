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
        $elektronik = Item::where("category", "elektronik")->where('status', 'selesai')->count();
        $sertifikat = Item::where("category", "sertifikat")->where('status', 'selesai')->count();
        $perhiasan = Item::where("category", "perhiasan")->where('status', 'selesai')->count();
        $kendaraan = Item::where("category", "kendaraan")->where('status', 'selesai')->count();
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
