<?php

namespace App\Http\Controllers;

use App\Http\Resources\BankResource;
use App\Laravue\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BankResource::collection(Bank::all());
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
                'bank_name' => ['required'],
                'account_number' => ['required'],
                'name' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $bank = Bank::create([
                'bank_name' => $params['bank_name'],
                'account_number' => $params['account_number'],
                'name' => $params['name'],
            ]);

            return new BankResource($bank);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        if ($bank === null) {
            return response()->json(['error' => 'ban$bank not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'bank_name' => ['required'],
                'account_number' => ['required'],
                'name' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $bank->bank_name = $params['bank_name'];
            $bank->account_number = $params['account_number'];
            $bank->name = $params['name'];
            $bank->save();
        }

        return new BankResource($bank);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        try {
            $bank->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
