<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepositInfoResource;
use App\Laravue\Models\Deposit_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepositInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Deposit_info  $deposit_info
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit_info $deposit_info)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Deposit_info  $deposit_info
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit_info $deposit_info)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Deposit_info  $deposit_info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit_info $deposit_info)
    {
        if ($deposit_info === null) {
            return response()->json(['error' => 'Deposit not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'wallet_id' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $params['status'] = "approve";
            // $deposit_info->wallet_id = $params['wallet_id'];
            // $deposit_info->sender = $params['sender'];
            // $deposit_info->account_number = $params['account_number'];
            // $deposit_info->deposit_amount = $params['deposit_amount'];
            // $deposit_info->sent_date = $params['sent_date'];
            $deposit_info->status = $params['status'];
            $deposit_info->save();
        }

        return new DepositInfoResource($deposit_info);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Deposit_info  $deposit_info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit_info $deposit_info)
    {
        //
    }
}
