<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class user extends Authenticatable
{
    public $table = "users";

    protected $fillable = [
        'fname',
        'lname',
        'username',
        'password'
    ];

    protected $primaryKey = 'user_id';
}
