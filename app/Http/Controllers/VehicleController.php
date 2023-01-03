<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Vehicle::with([])->get(),
            'status' => 'success',
            'message' => 'Get vehicle success',
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'color' => 'required|string',
            'model' => 'required|string'
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

            $data = Vehicle::create([
                'color' => $request->color,
                'model' => $request->model,
            ]);


            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Create vehicle failed',
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create vehicle success',
        ]);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'color' => 'required|string',
            'model' => 'required|string'
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
            $data = Vehicle::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'Vehicle not found',
                ]);
            }

            $data->color = $request->get('color');
            $data->model = $request->get('model');

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
            'message' => 'Update vehicle success',
        ]);


    }

    public function show($id)
    {
        return response()->json([
            'data' => [Vehicle::with([])->find($id)],
            'status' => 'success',
            'message' => 'Get vehicle success',
        ]);
    }

    public function destroy($id)
    {
        $data = Vehicle::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Vehicle not found',
            ]);
        }
        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete vehicle success',
        ]);
    }
}