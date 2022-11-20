<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Item::all(),
            'status' => 'success',
            'message' => 'Get item success',
        ]);
    }


    public function store(Request $request)
    {

        $data = new Item([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
        ]);


        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Add item failed',

            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Add item success',

        ]);
    }


    public function show($id)
    {
        return response()->json([
            'data' => [Item::find($id)],
            'status' => 'success',
            'message' => 'Get item success',

        ]);
    }


    public function update(Request $request, $id)
    {

        $data = Item::findOrFail($id);

        $data->name = $request->get('name');
        $data->description = $request->get('description');

        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Update item fail',

            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Update item success',

        ]);
    }

    public function destroy($id)
    {
        $data = Item::findOrFail($id);

        if (!$data) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Delete item fail',

            ]);
        }

        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete item success',
        ]);
    }
}