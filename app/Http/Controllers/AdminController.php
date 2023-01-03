<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => Admin::with(["user"])->get(),
            'status' => 'success',
            'message' => 'Get admin success',
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'email' => 'required|email',
            'lastName' => 'required|string',
            'password' => 'required|string'
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

            $user = User::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'type' => "ADMIN",
            ]);

            $user->createToken('MyApp')->accessToken;

            $data = Admin::create([
                'userId' => $user->id,
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

        $validator = Validator::make($request->all(), [
            'userId' => 'required|numberic'
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
            'data' => [Admin::with(["user"])->find($id)],
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