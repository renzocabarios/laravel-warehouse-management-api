<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $primarykey = 'id';

    protected $fillable = [
        'email',
        "firstName",
        "lastName",
        'password',
    ];


    protected $hidden = [
        'password',
    ];
}