<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoginResource;
use App\Http\Resources\MemberResource;
use App\Http\Resources\UserResource;
use App\Laravue\JsonResponse;
use App\Laravue\Models\Member;
use App\Laravue\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

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
        $limit = Arr::get($params, 'limit');
        $byId = Arr::get($params, 'id', '');
        $keyword = Arr::get($params, 'keyword', '');
        if ((!empty($byId))) {
            $userQuery->where('id', $byId);
        }
        if ((!empty($keyword))) {
            $userQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }
        $userQuery->orderBy('updated_at', 'desc');
        //$limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        return MemberResource::collection($userQuery->paginate($limit));
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

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(new JsonResponse([], 'login_error'), Response::HTTP_UNAUTHORIZED);
        }

        $user = $request->user();
        $token = $user->createToken('laravue');

        // return response()->json($data);
        // return new MemberResource($data);

        return response()->json(new LoginResource($user), Response::HTTP_OK)->header('Authorization', $token->plainTextToken);
    }
}
