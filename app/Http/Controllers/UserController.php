<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {

        return response()->json([
            'data' => User::with(["admin","branchOwner"])->get(),
            'status' => 'success',
            'message' => 'Get user success',
        ]);
    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();
            $data = User::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'image' => $request->image,
            ]);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollback();
            
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'Create user failed',
            ]);
        }

        return response()->json([
            'data' => [$data],
            'status' => 'success',
            'message' => 'Create user success',
        ]);
    }


    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $data = User::find($id);

            if ($data == null) {
                return response()->json([
                    'data' => [],
                    'status' => 'failed',
                    'message' => 'User not found',
                ]);
            }

            $data->firstName = $request->get('firstName');
            $data->lastName = $request->get('lastName');
            $data->email = $request->get('email');
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
            'message' => 'Update user success',
        ]);


    }

    public function show($id)
    {
        return response()->json([
            'data' => [User::with(["admin","branchOwner"])->find($id)],
            'status' => 'success',
            'message' => 'Get user success',
        ]);
    }

    public function destroy($id)
    {
        $data = User::find($id);

        if ($data == null) {
            return response()->json([
                'data' => [],
                'status' => 'failed',
                'message' => 'User not found',
            ]);
        }
        $data->delete();

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Delete user success',
        ]);
    }
}