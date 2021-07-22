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
        'department_id',
        'email',
        'lang',
        'username',
        'password',
        'password_plain_text',
        'roles',
        'ip_address',
        'device',
        'last_active',
        'is_deleted',
        'by_deleted',
        'date_deleted'
    ];

    protected $primaryKey = 'user_id';
}
