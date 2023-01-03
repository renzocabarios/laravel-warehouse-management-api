<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BranchOwner;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BranchOwnerController extends Controller
{
    public function index()
    {

        return response()->json([
            'data' => BranchOwner::with(["user"])->get(),
            'status' => 'success',
            'message' => 'Get branch owner success',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|email'
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
                'type' => "BRANCHOWNER",
            ]);

            $user->createToken('MyApp')->accessToken;

            $data = BranchOwner::create([
                'userId' => $user->id,
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
            'message' => 'Create branch owner success',
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|email'
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
            $data = BranchOwner::find($id);

            if ($data == null) {
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
            'data' => [BranchOwner::with(["user"])->find($id)],
            'status' => 'success',
            'message' => 'Get branch owner success',
        ]);
    }

    public function destroy($id)
    {
        $data = BranchOwner::find($id);

        if ($data == null) {
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