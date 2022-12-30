<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ViewController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function item()
    {
        return view('item');
    }

    public function user()
    {
        return view('user');
    }

    public function admin()
    {
        return view('admin');
    }

    public function branchOwner()
    {
        return view('branchOwner');
    }
    public function branch()
    {
        return view('branch');
    }
    public function branchCreate()
    {
        return view('branchCreate');
    }

    public function branchEdit()
    {
        return view('branchEdit');
    }
    
    public function vehicle()
    {
        return view('vehicle');
    }

}