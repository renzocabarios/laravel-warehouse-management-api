<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Admin::with([])->get(),
            'status' => 'success',
            'message' => 'Get admin success',
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = Admin::create([
                'userId' => $request->userId,
            ]);


            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Create admin failed',
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create admin success',
        ]);
    }


    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $data = Admin::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Admin not found',
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
            'message' => 'Update admin success',
        ]);


    }

    public function show($id)
    {
        return response()->json([
            'data' => [Admin::with([])->find($id)],
            'status' => 'success',
            'message' => 'Get admin success',
        ]);
    }

    public function destroy($id)
    {
        $data = Admin::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Admin not found',
            ]);
        }
        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete admin success',
        ]);
    }
}