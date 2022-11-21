<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        return response()->json([
            'data' => User::all(),
            'status' => 'success',
            'message' => 'Get user success',
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'firstName' => 'required',
            'lastName' => 'required',
            'password' => 'required'
        ]);

        $data = new User([
            'email' => $request->get('email'),
            'firstName' => $request->get('firstName'),
            'lastName' => $request->get('lastName'),
            'password' => bcrypt($request->get('password'))
        ]);


        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Create user fail',
            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Create user success',
        ]);
    }


    public function show($id)
    {
        return response()->json([
            'data' => [User::find($id)],
            'status' => 'success',
            'message' => 'Get user success',
        ]);
    }


    public function update(Request $request, $id)
    {

        $data = User::findOrFail($id);

        $data->firstName = $request->get('firstName');
        $data->firstName = $request->get('lastName');

        if (!$data->save()) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Update user fail',
            ]);
        }

        return response()->json([
            'data' => [],
            'status' => 'success',
            'message' => 'Update user success',
        ]);
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);

        if (!$data) {
            return response()->json([
                'data' => [],
                'status' => 'fail',
                'message' => 'Delete user fail',
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