<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Item::with([])->get(),
            'status' => 'success',
            'message' => 'Get item success',
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = Item::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);


            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Create item failed',
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create item success',
        ]);
    }


    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $data = Item::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Item not found',
                ]);
            }

            $data->name = $request->get('name');
            $data->description = $request->get('description');

            $data->save();
            DB::commit();

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => $e,
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Update item success',
        ]);


    }

    public function show($id)
    {
        return response()->json([
            'data' => [Item::with([])->find($id)],
            'status' => 'success',
            'message' => 'Get item success',
        ]);
    }

    public function destroy($id)
    {
        $data = Item::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Item not found',
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