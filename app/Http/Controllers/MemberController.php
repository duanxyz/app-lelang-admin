<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Laravue\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $userQuery = Member::query();
        $byId = Arr::get($params, 'id', '');
        if ((!empty($byId))) {
            $userQuery->where('id', $byId);
        }
        //$limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        return MemberResource::collection($userQuery->paginate(15));
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
    public function store(Request $request, Member $member)
    {
        $create = $member->create($request->all());

        return new MemberResource($create);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return new MemberResource($member);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $params = $request->all();
        $member->update([
            'name' => $params['name'],
            'phone_number' => $params['phone_number'],
        ]);

        return new MemberResource($member);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }
}
