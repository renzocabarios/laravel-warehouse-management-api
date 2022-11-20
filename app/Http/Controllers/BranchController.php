<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Branch::all(),
            'status' => 'success',
            'message' => 'Get branch success',
        ]);
    }


    public function store(Request $request)
    {

        $data = new Branch([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
        ]);


        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Add branch failed',

            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Add branch success',

        ]);
    }


    public function show($id)
    {
        return response()->json([
            'data' => [Branch::find($id)],
            'status' => 'success',
            'message' => 'Get branch success',

        ]);
    }


    public function update(Request $request, $id)
    {

        $data = Branch::findOrFail($id);

        $data->name = $request->get('name');
        $data->address = $request->get('address');

        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Update branch fail',

            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Update branch success',

        ]);
    }

    public function destroy($id)
    {
        $data = Branch::findOrFail($id);

        if (!$data) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Delete branch fail',

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