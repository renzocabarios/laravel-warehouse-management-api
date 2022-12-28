<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchOwner;
use Illuminate\Support\Facades\DB;

class BranchOwnerController extends Controller
{
    public function index()
    {

        return response()->json([
            'data' => BranchOwner::with([])->get(),
            'status' => 'success',
            'message' => 'Get branch owner success',
        ]);    
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $data = BranchOwner::create([
                'userId' => $request->userId,
            ]);


            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Create branch owner failed',
            ]);
        }
        
        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create branch owner success',
        ]);    
    }


    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $data = BranchOwner::find($id);    

            if($data == null){
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Branch owner not found',
                ]);
            }

            $data->userId = $request->get('userId');

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
            'message' => 'Update branch owner success',
        ]);

    }

    public function show($id)
    {
        return response()->json([
            'data' => [BranchOwner::with([])->find($id)],
            'status' => 'success',
            'message' => 'Get branch owner success',
        ]);    
    }

    public function destroy($id)
    {
        $data = BranchOwner::find($id);

        if($data == null){
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Branch owner not found',
            ]);
        }
        $data->delete();
        
        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete branch owner success',
        ]);
    }
}