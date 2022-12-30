<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function index()
    {

        return response()->json([
            'data' => Branch::with(["branchOwner.branch", "stocks", "branchOwner.user"])->get(),
            'status' => 'success',
            'message' => 'Get branch success',
        ]);
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $data = Branch::create([
                'name' => $request->name,
                'address' => $request->address,
                'branchOwnerId' => $request->branchOwnerId,
            ]);


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
            'message' => 'Create branch success',
        ]);
    }


    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $data = Branch::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Branch not found',
                ]);
            }

            $data->name = $request->get('name');
            $data->address = $request->get('address');
            $data->branchOwnerId = $request->get('branchOwnerId');

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
            'message' => 'Update branch success',
        ]);


    }

    public function show($id)
    {
        return response()->json([
            'data' => [Branch::with(["branchOwner.branch", "stocks", "branchOwner.user"])->find($id)],
            'status' => 'success',
            'message' => 'Get branch success',
        ]);
    }

    public function destroy($id)
    {
        $data = Branch::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Branch not found',
            ]);
        }
        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete branch success',
        ]);
    }
}