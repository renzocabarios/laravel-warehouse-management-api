<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function index()
    {

        return response()->json([
            'data' => Stock::with(["item", "branch"])->get(),
            'status' => 'success',
            'message' => 'Get stock success',
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'branchId' => 'required|numeric',
            'itemId' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'The form is not valid',
            ]);
        }
        try {
            DB::beginTransaction();

            $data = Stock::create([
                'branchId' => $request->branchId,
                'itemId' => $request->itemId,
                'quantity' => $request->quantity,
            ]);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Create stock failed',
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create stock success',
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'branchId' => 'required|numeric',
            'itemId' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'The form is not valid',
            ]);
        }
        try {
            DB::beginTransaction();
            $data = Stock::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Stock not found',
                ]);
            }

            $data->branchId = $request->get('branchId');
            $data->itemId = $request->get('itemId');
            $data->quantity = $request->get('quantity');

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
            'message' => 'Update stock success',
        ]);

    }

    public function show($id)
    {
        return response()->json([
            'data' => [Stock::with(["item", "branch"])->find($id)],
            'status' => 'success',
            'message' => 'Get stock success',
        ]);
    }

    public function destroy($id)
    {
        $data = Stock::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Stock not found',
            ]);
        }
        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete stock success',
        ]);
    }
}