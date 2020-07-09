<?php

namespace App\Http\Controllers;

use App\Laravue\Models\Deposit_info;
use App\Laravue\Models\Item;
use App\Laravue\Models\Member;
use App\Laravue\Models\Withdrawal_info;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    public function index()
    {
        $user = Member::all()->count();
        $item = Item::all()->count();
        $deposit = Deposit_info::where("status", "approve")->count();
        $withdraw = Withdrawal_info::where("status", "approve")->count();
        $elektronik = Item::where("category", "elektronik")->count();
        $sertifikat = Item::where("category", "sertifikat")->count();
        $emas = Item::where("category", "emas")->count();
        $perikanan = Item::where("category", "perikanan")->count();
        $pertanian = Item::where("category", "pertanian")->count();
        $kendaraan = Item::where("category", "kendaraan")->count();
        $data = [
            'data' => [
                'user' => $user,
                'item' => $item,
                'deposit' => $deposit,
                'withdraw' => $withdraw,
            ],
            'item' => [
                'elektronik' => $elektronik,
                'sertifikat' => $sertifikat,
                'emas' => $emas,
                'perikanan' => $perikanan,
                'pertanian' => $pertanian,
                'kendaraan' => $kendaraan,
            ]

        ];

        return response()->json($data);
    }
}
