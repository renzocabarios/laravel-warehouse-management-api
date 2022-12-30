<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/',
    [ViewController::class, 'login']
)->name('login');

Route::get(
    '/login',
    [ViewController::class, 'login']
)->name('login');

Route::get(
    '/register',
    [ViewController::class, 'register']
)->name('register');

Route::get(
    '/item',
    [ViewController::class, 'item']
)->name('item');

Route::get(
    '/user',
    [ViewController::class, 'user']
)->name('user');

Route::get(
    '/admin',
    [ViewController::class, 'admin']
)->name('admin');

Route::get(
    '/branch-owner',
    [ViewController::class, 'branchOwner']
)->name('branchOwner');

Route::get(
    '/branch',
    [ViewController::class, 'branch']
)->name('branch');



Route::get(
    '/branch/create',
    [ViewController::class, 'branchCreate']
)->name('branchCreate');

Route::get(
    '/branch/edit/{id}',
    [ViewController::class, 'branchEdit']
)->name('branchEdit');

Route::get(
    '/vehicle',
    [ViewController::class, 'vehicle']
)->name('vehicle');