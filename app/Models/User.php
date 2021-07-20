<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class user extends Authenticatable
{
    public $table = "users";

    protected $fillable = [
        'avatar',
        'fname',
        'lname',
        'email',
        'username',
        'password',
        'password_plain_text',
        'roles',
        'ip_address',
        'device',
        'last_active',
        'is_deleted'
    ];

    protected $primaryKey = 'user_id';
}
