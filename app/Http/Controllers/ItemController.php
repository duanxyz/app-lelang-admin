<?php

namespace App\Http\Controllers;

// namespace App\Traits;

use App\Http\Resources\ItemResource;
use App\Laravue\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use App\Traits\ImageUpload;

class ItemController extends Controller
{
    use ImageUpload;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $itemQuery = Item::query();
        $limit = Arr::get($searchParams, 'limit');
        $category = Arr::get($searchParams, 'category', '');
        $keyword = Arr::get($searchParams, 'keyword', '');
        $date = Arr::get($searchParams, 'date', '');
        $status = Arr::get($searchParams, 'status', '');
        if (!empty($category)) {
            $itemQuery->where('category', 'LIKE', '%' . $category . '%');
        }

        if (!empty($keyword)) {
            $itemQuery->where('item_name', 'LIKE', '%' . $keyword . '%');
        }

        if (!empty($date)) {
            $itemQuery->where('auction_date', 'LIKE', '%' . $date . '%');
        }

        if (!empty($status)) {
            $itemQuery->where('status', $status);
        }
        return itemResource::collection($itemQuery->paginate($limit));
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
                'item_name' => ['required'],
                'category' => ['required'],
                'deskripsi' => ['required'],
                'photo' => ['required'],
                'initial_price' => ['required'],
                'auction_date' => ['required'],
                'auction_time' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $imageName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move(public_path('images/items'), $imageName);
            $params = $request->all();
            $item = Item::create([
                'item_name' => $params['item_name'],
                'category' => $params['category'],
                'deskripsi' => $params['deskripsi'],
                'photo' => $imageName,
                'initial_price' => $params['initial_price'],
                'auction_date' => $params['auction_date'],
                'auction_time' => $params['auction_time'],
            ]);
            return new ItemResource($item);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laravue\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        // $category = [
        //     "emas",
        //     "elektronik",
        //     "pertanian",
        //     "perikanan",
        //     "kendaraan",
        //     "sertifikat",
        // ];
        // $category = Item::all();
        // if(request()->input('pertanian')){
        //     $category->load('pertanian')
        // }

        // $category = $item->inpu

        // return new ItemResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laravue\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laravue\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        if ($item === null) {
            return response()->json(['error' => 'barang not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'item_name' => ['required'],
                'category' => ['required'],
                'deskripsi' => ['required'],
                // 'photo' => ['required'],
                'initial_price' => ['required'],
                'auction_date' => ['required'],
                'auction_time' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {

            $params = $request->all();

            if ($request->hasFile('photo')) {
                $imageName = time() . '.' . $request->file('photo')->getClientOriginalExtension();
                $request->file('photo')->move(public_path('images/items'), $imageName);
                if (file_exists(public_path('images/items/' . $item->photo))) {
                    unlink(public_path('images/items/' . $item->photo));
                } else {
                    echo "File does not exists";
                }
                $item->photo = $imageName;
            }
            $item->item_name = $params['item_name'];
            $item->category = $params['category'];
            $item->deskripsi = $params['deskripsi'];
            $item->initial_price = $params['initial_price'];
            $item->auction_date = $params['auction_date'];
            $item->auction_time = $params['auction_time'];
            $item->save();
        }

        return new itemResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laravue\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        try {
            $item->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);
    }
}
