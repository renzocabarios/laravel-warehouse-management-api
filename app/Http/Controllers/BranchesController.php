<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branches;
use Illuminate\Support\Facades\DB;

class BranchesController extends Controller
{
    public function index()
    {

        return response()->json([
            'data' => Branches::with([])->get(),
            'status' => 'success',
            'message' => 'Get branches success',
        ]);    
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $data = Branches::create([
                'name' => $request->name,
                'address' => $request->address,
                'image' => $request->image,
            ]);


            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Create branches failed',
            ]);
        }
        
        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create branches success',
        ]);    
    }


    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $data = Branches::find($id);    

            if($data == null){
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Branches not found',
                ]);
            }

            $data->name = $request->get('name');
            $data->address = $request->get('address');
            $data->image = $request->get('image');

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
            'message' => 'Update branches success',
        ]);


    }

    public function show($id)
    {
        return response()->json([
            'data' => [Branches::with([])->find($id)],
            'status' => 'success',
            'message' => 'Get branches success',
        ]);    
    }

    public function destroy($id)
    {
        $data = Branches::find($id);

        if($data == null){
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Branches not found',
            ]);
        }
        $data->delete();
        
        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete branches success',
        ]);
    }
}
