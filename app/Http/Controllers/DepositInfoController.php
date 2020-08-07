<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepositInfoResource;
use App\Laravue\Models\Deposit_info;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class DepositInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $userQuery = Deposit_info::query()->where('status', "not approved");
        $userQuery->orderBy('created_at', 'desc');
        $limit = Arr::get($searchParams, 'limit');
        return DepositInfoResource::collection($userQuery->paginate($limit));
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
        $validator = Validator::make(
            $request->all(),
            [
                'wallet_id' => ['required'],
                'proof' => ['required'],
                'sent_date' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $imageName = time() . '.' . $request->file('proof')->getClientOriginalExtension();
            $request->file('proof')->move(public_path('images/proof'), $imageName);
            $params = $request->all();
            $deposit = Deposit_info::create([
                'wallet_id' => $params['wallet_id'],
                'sent_date' => $params['sent_date'],
                'proof' => $imageName,
            ]);
            return new DepositInfoResource($deposit);
        }
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
        //
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
